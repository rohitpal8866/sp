
<div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <!-- <a href="{{route('admin.dashboard.index')}}"><img src="{{ asset('assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a> -->
                            <a href="{{route('admin.dashboard.index')}}"><h2>{{ \App\Models\SiteConfiguration::first()->site_name?? 'Admin Panel' }}</h2></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item {{ Str::contains(Route::currentRouteName(), 'dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard.index')}}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item  {{ Str::contains(Request::url(), 'building') ? 'active' : '' }}">
                            <a href="{{ route('admin.building.index')}}" class='sidebar-link'>
                            <i class="bi bi-building"></i>
                                <span>Building</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ Str::contains(Request::url(), 'tenant') ? 'active' : '' }}">
                            <a href="{{ route('admin.tenant.index')}}" class='sidebar-link'>
                                <i class="bi bi-people"></i>
                                <span>Tenant</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ Str::contains(Request::url(), 'bill') ? 'active' : '' }}">
                            <a href="{{ route('admin.bill.index')}}" class='sidebar-link'>
                                <i class="bi bi-receipt"></i>
                                <span>Bills</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ Str::contains(Request::url(), 'report') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.index')}}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-bar-graph"></i>
                                <span>Reports</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ Str::contains(Request::url(), 'account-configuration') ? 'active' : '' }}">
                            <a href="{{ route('admin.siteconfig.index')}}" class='sidebar-link'>
                                <i class="bi bi-gear"></i>
                                <span>Account Configuration</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Raise Support</li>
                        <li class="sidebar-item">
                            <a onclick="getUpdateGit(this)" data-route="{{Route('git-pull')}}" class="sidebar-link" style="cursor: pointer;" target="_blank">
                                <i class="bi bi-life-preserver"></i>
                                <span>Get Updatee</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>

