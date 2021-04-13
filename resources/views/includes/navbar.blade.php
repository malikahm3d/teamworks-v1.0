<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="{{ route('homepage') }}">
        <img src="/images/logo00.png" alt="logo" width="100">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="nav ml-auto" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link text-info font-weight-bold" href="{{ route('homepage') }}">
                    Home
                    <span class="sr-only">
                        (current)
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-info" href="{{ route('showCourses') }}">
                    Enrollment
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-info" href="#" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Courses
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @auth()
                        @forelse(auth()->user()->courses as $course)
                            <a class="dropdown-item text-info"
                               href="{{ route('postsInACourse', $course) }}">{{ $course->name }}</a>
                        @empty
                            <a class="dropdown-item text-info" href="{{ route('showCourses') }}">Enroll Courses!</a>
                        @endforelse
                    @endauth
                </div>
            </li>

            <!-- if user is admin show this dropdown menu -->
            @role('admin')
            @if (!Route::is('admin.panel'))

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-info" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false">
                        Admin Panel
                    </a>
                    <ul class="dropdown-menu text-info d-block-flex" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item text-info" href="{{ route('admin.panel') }}">
                                {{ __('Main Page') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-info" href="{{ route('roles.index') }}">
                                {{ __('Manage Roles') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-info" href="{{ route('permissions.index') }}">
                                {{ __('Manage Permissions') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-info" href="{{ route('admin.panel.organization') }}">
                                {{ __('Manage Universities Organizations') }}
                            </a>
                        </li>

                    </ul>
                </li>
            @endif
            @endrole

            <!-- if user is moderator show this dropdown menu -->
            @role('moderator')
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-info" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false">
                        Moderator Panel
                    </a>
                    <ul class="dropdown-menu text-info d-block-flex" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item text-info" href="{{ route('courses.index') }}">
                                {{ __('Manage Courses') }}
                            </a>
                        </li>
                    </ul>
            @endrole

            @if (!Route::is('dashboard'))
                <li class="nav-item">
                    <a class="nav-link text-info" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
            @endif
        <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                {{-- <li class="nav-item">
                    <button class="bg_main_color font-bold py-2 px-4 rounded text-info" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </button>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link text-info" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                    {{-- <button class="bg_main_color font-bold py-2 px-3 rounded text-info" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </button> --}}
                    <li class="nav-item">
                        <a class="nav-link text-info" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-info" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('/storage/images/' . Auth::user()->avatar) }}" alt="avatar" width="40" />
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <li>
                            {{-- Settings page --}}
                            <a class="dropdown-item text-info" href="{{ route('users.edit', Auth::user()->id) }}"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         document.getElementById('logout-form').submit();">
                                {{ __('Settings') }}
                            </a>
                        </li>
                        <li>
                            {{-- logout --}}
                            <a class="dropdown-item text-info" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
        </ul>
        {{-- <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form> --}}
    </div>
</nav>
