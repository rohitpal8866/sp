@extends('admin.include.layout')

@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Building List</h3>
                <!-- <p class="text-subtitle text-muted">The default layout </p> -->
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard.index')}}">Dashboard</a></li>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Layout Default</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hoverable rows</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p>Add <code class="highlighter-rouge">.table-hover</code> to enable a hover
                                state on table
                                rows
                                within a
                                <code class="highlighter-rouge">&lt;tbody&gt;</code>.
                            </p>
                        </div>
                        <!-- table hover -->
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>RATE</th>
                                        <th>SKILL</th>
                                        <th>TYPE</th>
                                        <th>LOCATION</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-bold-500">Michael Right</td>
                                        <td>$15/hr</td>
                                        <td class="text-bold-500">UI/UX</td>
                                        <td>Remote</td>
                                        <td>Austin,Taxes</td>
                                        <td><a href="#"><i
                                                    class="badge-circle badge-circle-light-secondary font-medium-1"
                                                    data-feather="mail"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500">Morgan Vanblum</td>
                                        <td>$13/hr</td>
                                        <td class="text-bold-500">Graphic concepts</td>
                                        <td>Remote</td>
                                        <td>Shangai,China</td>
                                        <td><a href="#"><i
                                                    class="badge-circle badge-circle-light-secondary font-medium-1"
                                                    data-feather="mail"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500">Tiffani Blogz</td>
                                        <td>$15/hr</td>
                                        <td class="text-bold-500">Animation</td>
                                        <td>Remote</td>
                                        <td>Austin,Texas</td>
                                        <td><a href="#"><i
                                                    class="badge-circle badge-circle-light-secondary font-medium-1"
                                                    data-feather="mail"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500">Ashley Boul</td>
                                        <td>$15/hr</td>
                                        <td class="text-bold-500">Animation</td>
                                        <td>Remote</td>
                                        <td>Austin,Texas</td>
                                        <td><a href="#"><i
                                                    class="badge-circle badge-circle-light-secondary font-medium-1"
                                                    data-feather="mail"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500">Mikkey Mice</td>
                                        <td>$15/hr</td>
                                        <td class="text-bold-500">Animation</td>
                                        <td>Remote</td>
                                        <td>Austin,Texas</td>
                                        <td><a href="#"><i
                                                    class="badge-circle badge-circle-light-secondary font-medium-1"
                                                    data-feather="mail"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection