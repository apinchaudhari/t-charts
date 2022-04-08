@stack('navbar_start')
<nav class="navbar navbar-top navbar-expand navbar-dark border-bottom">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @stack('navbar_search')

            @can('read-common-search')
                <livewire:common.search />
            @endcan

            <ul class="navbar-nav align-items-center ml-md-auto">
               
            </ul>

            @stack('navbar_profile')

            <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <div class="media align-items-center">
                            @if (setting('default.use_gravatar', '0') == '1')
                                <img src="{{ $user->picture }}" alt="{{ $user->name }}" class="rounded-circle image-style user-img" title="{{ $user->name }}">
                            @elseif (is_object($user->picture))
                                <img src="{{ Storage::url($user->picture->id) }}" class="rounded-circle image-style user-img" alt="{{ $user->name }}" title="{{ $user->name }}">
                            @else
                                <img src="{{ asset('public/img/user.svg') }}" class="user-img" alt="{{ $user->name }}"/>
                            @endif
                            @if (!empty($user->name))
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm font-weight-bold">{{ $user->name }}</span>
                                </div>
                            @endif
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        @stack('navbar_profile_welcome')

                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">{{ trans('general.welcome') }}</h6>
                        </div>

                        @stack('navbar_profile_edit')

                        @canany(['read-auth-users', 'read-auth-profile'])
                            <a href="{{ route('users.edit', $user->id) }}" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>{{ trans('auth.profile') }}</span>
                            </a>
                        @endcanany
                        
                        
                        <div class="dropdown-divider"></div>

                        @stack('navbar_profile_logout_start')

                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="fas fa-power-off"></i>
                            <span>{{ trans('auth.logout') }}</span>
                        </a>

                        @stack('navbar_profile_logout_end')
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
@stack('navbar_end')