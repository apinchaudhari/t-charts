@stack('menu_start')
    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-default" id="sidenav-main">
        <div class="scrollbar-inner">
            <div class="sidenav-header d-flex align-items-center">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="avatar menu-avatar background-unset">
                                <img class="border-radius-none border-0 mr-3" alt="T-Charts" src="{{ asset('public/img/akaunting-logo-white.svg') }}">
                            </span>
                        </a>

                    </li>
                </ul>
                <div class="ml-auto left-menu-toggle-position overflow-hidden">
                    <div class="sidenav-toggler d-none d-xl-block left-menu-toggle" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
            <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <ul class="navbar-nav">
                        <li class="nav-item">  
                            <a class="nav-link" href="{{ route('superadmindashboard') }}">
                                <i class="fa fa-tachometer-alt"></i>    
                                <span class="nav-link-text">Dashboard</span>  
                            </a>
                        </li>
                        <li class="nav-item">  
                            <a class="nav-link" href="{{ route('companies.index') }}">
                                <i class="fa fa-building"></i>    
                                <span class="nav-link-text">Company</span>  
                            </a>
                        </li>
                        <li class="nav-item">  
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fa fa-users"></i>    
                                <span class="nav-link-text">Users</span>  
                            </a>
                        </li>
                        <li class="nav-item">  
                            <a class="nav-link" href="{{ route('roles.index') }}">
                                <i class="fas fa-list"></i>    
                                <span class="nav-link-text">Roles</span>  
                            </a>
                        </li>
                        <li class="nav-item">  
                            <a class="nav-link" href="{{ route('permissions.index') }}">
                                <i class="fas fa-key"></i>    
                                <span class="nav-link-text">Permissions</span>  
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@stack('menu_end')
