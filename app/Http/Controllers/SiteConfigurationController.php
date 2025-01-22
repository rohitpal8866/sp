<?php

namespace App\Http\Controllers;

use App\Models\SiteConfiguration;
use Illuminate\Http\Request;

class SiteConfigurationController extends Controller
{
    public function index(Request $request){
        $configuration = SiteConfiguration::first();
        return view("admin.site_configuration.index" , compact('configuration'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $logoPath = null;
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('public/assets/images/logo');
        }

        $siteConfiguration = SiteConfiguration::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => $request->input('site_name'),
                'logo' => $logoPath ? basename($logoPath) : null,
            ]
        );
    
        config(['app.name' => $request->input('site_name')]);
        if ($logoPath) {
            config(['app.logo' => $logoPath]);
        }
    
        return response()->json([
            'message' => 'Record updated successfully'
        ], 200);

        // return redirect()->back()->with('success', 'Site configuration updated successfully!');
    }
}
