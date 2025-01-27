<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Flat;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function index(){
        $data = User::whereHas('roles', function ($query) {
            $query->where('role', 'tenant');
        })->latest('created_at')->paginate(8);

        return view('admin.tanent.index' ,compact('data'));
    }

    public function create(){
        return view('admin.tanent.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email|unique:users,email',
            'flat' => 'nullable|exists:flats,id',
            'note' => 'nullable|string',
            'document.*' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', // Allow multiple files
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
    
        DB::beginTransaction();
        try{

            // Create user
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone ?? null,
                'email' => $request->email ?? null,
            ]);
        
            // Associate flat if provided
            if ($request->flat) {
                $flat = Flat::findOrFail($request->flat);
                $user->flat()->associate($flat);
            }
        
            Roles::create([
                'user_id' => $user->id, 'role' => 'tenant'
            ]);
            // Store Profile Picture
            if ($request->hasFile('profile_picture')) {
                $profile_picture = $request->file('profile_picture');
                $folderPath = 'assets/images/' . $user->id;
                $fileName = uniqid() . '.' . $profile_picture->getClientOriginalExtension();
                $profilePath = $profile_picture->storeAs($folderPath, $fileName, 'public');
            
                Document::create([
                    'model_type' => User::class,
                    'model_id' => $user->id,
                    'uuid' => 'profile_picture',
                    'document' => $profilePath,
                    'type' => $profile_picture->getClientOriginalExtension(),
                ]);
            }

            // Handle file uploads
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $folderPath = 'assets/images/' . $user->id;
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs($folderPath, $fileName, 'public');
                
                    Document::create([
                        'model_type' => User::class,
                        'model_id' => $user->id,
                        'uuid' => 'documents',
                        'document' => $filePath,
                        'type' => $file->getClientOriginalExtension(),
                    ]);
                }
            }
        
            DB::commit();
            return response()->json([
                'message' => 'Tenant has been created successfully.',
                'data' => $user
            ], 200);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Tenant create error'. $e->getMessage());
            return response()->json(['message'=> $e->getMessage()],422);            
        }
        
    }
    

    /**
     * Show the specified building.
     */
    public function show($id)
    {
        $data = User::findOrFail($id);


        return view('admin.tanent.create',compact('data'));
    }

    /**
     * Update the specified building.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
            'flat' => 'nullable|exists:flats,id',
            'note' => 'nullable|string',
            'document.*' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', // Allow multiple files
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
    
        DB::beginTransaction();
        try{

            $user = User::findOrFail($id);
            // Create user
            // $user = User::update([
            //     'name' => $request->name,
            //     'phone' => $request->phone ?? null,
            //     'email' => $request->email ?? null,
            // ]);
            $user->name = $request->name ;
            $user->phone = $request->phone ?? null;
            $user->email = $request->email ?? null;
            $user->save();
            // Associate flat if provided
            if ($request->flat) {
                $flat = Flat::findOrFail($request->flat);
                $flat->user_id = $id; // Set the user's ID
                $flat->save(); // Save the changes to the database
            }
        
            Roles::create([
                'user_id' => $user->id, 'role' => 'tenant'
            ]);
            // Store Profile Picture
            if ($request->hasFile('profile_picture')) {

                $exitingProfile = Document::where('model_id', $id)->where('model_type','App\Models\User')->where('uuid','profile_picture')->first();

                if($exitingProfile){
                    $exitingProfile->delete();
                }

                $profile_picture = $request->file('profile_picture');
                $folderPath = 'assets/images/' . $id;
                $fileName = uniqid() . '.' . $profile_picture->getClientOriginalExtension();
                $profilePath = $profile_picture->storeAs($folderPath, $fileName, 'public');
            
                Document::create([
                    'model_type' => User::class,
                    'model_id' => $id,
                    'uuid' => 'profile_picture',
                    'document' => $profilePath,
                    'type' => $profile_picture->getClientOriginalExtension(),
                ]);
            }

            // Handle file uploads
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $folderPath = 'assets/images/' . $id;
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs($folderPath, $fileName, 'public');
                
                    Document::create([
                        'model_type' => User::class,
                        'model_id' => $user->id,
                        'uuid' => 'documents',
                        'document' => $filePath,
                        'type' => $file->getClientOriginalExtension(),
                    ]);
                }
            }
        
            DB::commit();
            return response()->json([
                'message' => 'Tenant has been Update successfully.',
                'data' => $user
            ], 200);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Tenant create error'. $e->getMessage());
            return response()->json(['message'=> $e->getMessage()],422);            
        }
    }

    /**
     * Remove the specified building.
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User has been deleted successfully.',
        ], 200);
    }

    public function getFlats(Request $request)
    {
        // Validate the building_id input
        $request->validate([
            'building_id' => 'required|exists:buildings,id'
        ]);

        // Fetch the flats for the selected building
        $flats = Flat::where('building_id', $request->building_id)->where('user_id', null)->get();

        // Return flats as a JSON response
        return response()->json([
            'flats' => $flats
        ]);
    }

    public function removeDocument($id){
        Document::find( $id )->delete();

        return back()->with('success','Document has been deleted successfully.');
    }


}
