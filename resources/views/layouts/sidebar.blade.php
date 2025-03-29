<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color:#0d6efd;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- DASHBOARDS -->
                @if(Auth::user() && Auth::user()->role_id == 1) <!-- Administrator -->
                <a class="nav-link text-white hover:bg-light" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-house me-2"></i> Dashboard
                </a>
                @endif

                @if(Auth::user() && Auth::user()->role_id == 2) <!-- Head -->
                <a class="nav-link text-white hover:bg-light" href="{{ route('head.dashboard') }}">
                    <i class="fas fa-house me-2"></i> Dashboard
                </a>
                @endif

                @if(Auth::user() && Auth::user()->role_id == 3) <!-- BAC Secretary -->
                <a class="nav-link text-white hover:bg-light" href="{{ route('bacsec.dashboard') }}">
                    <i class="fas fa-house me-2"></i> Dashboard
                </a>
                @endif

                @if(Auth::user() && Auth::user()->role_id == 4) <!-- Budget Officer -->
                <a class="nav-link text-white hover:bg-light" href="{{ route('budget_officer.dashboard') }}">
                    <i class="fas fa-house me-2"></i> Dashboard
                </a>
                @endif

                @if(Auth::user() && Auth::user()->role_id == 5) <!-- Campus Director -->
                <a class="nav-link text-white hover:bg-light" href="{{ route('campus_director.dashboard') }}">
                    <i class="fas fa-house me-2"></i> Dashboard
                </a>
                @endif

                <!-- ADMIN SECTION ONLY -->
                @if(Auth::user() && Auth::user()->role_id == 1)
                    <div class="sb-sidenav-menu-heading text-white">Management</div>

                    <!-- User Management Dropdown -->
                    <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" 
                        data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                        <i class="fas fa-users me-2"></i> User 
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                    </a>
                    <div class="collapse" id="collapseUsers" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-white hover:bg-dark" href="{{ route('admin.roles.index') }}">Roles</a>
                            <a class="nav-link text-white" href="{{ route('admin.users.index') }}">Users</a>
                            <a class="nav-link text-white" href="{{ route('admin.offices.index') }}">Offices</a>
                        </nav>
                    </div>

                    <!-- PPMP Resources Dropdown -->
                    <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" 
                        data-bs-target="#collapsePPMP" aria-expanded="false" aria-controls="collapsePPMP">
                        <i class="fas fa-folder-open me-2"></i> PPMP Resources
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                    </a>
                    <div class="collapse" id="collapsePPMP" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-white" href="{{ route('admin.ppmp_status.index') }}">PPMP Status</a>
                            <a class="nav-link text-white" href="{{ route('admin.ppmp_project_statuses.index') }}">PPMP Project Statuses</a>
                            <a class="nav-link text-white" href="#">Source of Fund</a>
                            <a class="nav-link text-white" href="#">APP Status</a>
                        </nav>
                    </div>
                @endif

                
                <!-- HEAD SECTION ONLY -->
                @if(Auth::user() && Auth::user()->role_id == 2)
                    <div class="sb-sidenav-menu-heading text-white">Head Management</div>

                    <!-- PPMP Navigation Link -->
                    <a class="nav-link text-white" href="{{ route('head.ppmps.index') }}">
                        <i class="fas fa-folder-open me-2"></i> PPMP
                    </a>
                    <a class="nav-link text-white" href="{{ route('head.app_projects.index') }}">
                        <i class="fas fa-file-alt me-2"></i> Assigned APP Projects
                    </a>
                @endif

                <!-- BAC SEC SECTION ONLY -->
                @if(Auth::user() && Auth::user()->role_id == 3)
                    <div class="sb-sidenav-menu-heading text-white">Bac Sec Management</div>

                    <!-- APP Management Dropdown -->
                    <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" 
                        data-bs-target="#collapseBacSec" aria-expanded="false" aria-controls="collapseBacSec">
                        <i class="fas fa-folder me-2"></i> APP 
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down text-white"></i></div>
                    </a>
                    <div class="collapse" id="collapseBacSec" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link text-white hover:bg-dark" href="{{ route('bacsec.app.index') }}">APP</a>
                            <a class="nav-link text-white" href="{{ route('bacsec.app_projects.index') }}">APP Projects</a>
                        </nav>
                    </div>
                @endif


                <!-- BUDGET OFFICER SECTION ONLY -->
                @if(Auth::user() && Auth::user()->role_id == 4)
                    <div class="sb-sidenav-menu-heading text-white">Budget Officer Management</div>

                    <a class="nav-link text-white" href="{{ route('budget_officer.submitted_projects.index') }}">
                        <i class="fas fa-folder-open me-2"></i> Submitted APP Projects
                    </a>
                    <a class="nav-link text-white" href="{{ route('budget_officer.certified_projects.index') }}">
                        <i class="fas fa-file-signature me-2"></i> Certified APP Projects
                    </a>
                @endif


                <!-- CAMPUS DIRECTOR SECTION ONLY -->
                @if(Auth::user() && Auth::user()->role_id == 5)
                    <div class="sb-sidenav-menu-heading text-white">Campus Director Management</div>

                    <a class="nav-link text-white" href="{{ route('campus_director.certified_project.index') }}">
                        <i class="fas fa-file-signature me-2"></i> Certified APP Projects
                    </a>
                    <a class="nav-link text-white" href="{{ route('campus_director.endorsed_projects.index') }}">
                        <i class="fas fa-folder-open me-2"></i> Endorsed APP Projects
                    </a>
                @endif


            </div>
        </div>
    </nav>
</div>
