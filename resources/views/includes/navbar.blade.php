<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('homepage') }}">TeamWorks</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('homepage') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('showCourses') }}">Enrollment</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Courses
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @auth()
                        @forelse(auth()->user()->courses as $course)
                            <a class="dropdown-item" href="{{ route('postsInACourse', $course) }}">{{$course->name}}</a>
                        @empty
                            <a class="dropdown-item" href="{{ route('showCourses') }}">Enroll Courses!</a>
                        @endforelse
                    @endauth
                </div>
            </li>

            @if(!Route::is('admin.panel'))
                    @role('admin')
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            Admin Panel
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.panel') }}">
                                        {{ __('Main Page') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">
                                        {{ __('Manage Roles') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('permissions.index') }}">
                                        {{ __('Manage Permissions') }}
                                    </a>
                                </li>
                                <li>
                                <a class="dropdown-item" href="{{ route('admin.panel.organization') }}">
                                        {{ __('Manage Universities Organizations') }}
                                    </a>
                                </li>

                        </ul>
                    </li>
                    @endrole
                    @role('moderator')
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            Moderator Panel
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('courses.index') }}">
                                        {{ __('Manage Courses') }}
                                    </a>
                                </li>

                        </ul>
                    </li>
                    @endrole
                    @endif
                    @if(!Route::is('dashboard'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                    </li>
                    @endif
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                            @if(Auth::user()->avatar)
                            <img src="{{asset('/storage/images/'
                                .Auth::user()->avatar)}}" alt="avatar" width="40"/>
                            @endif
                        </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                     <a class="dropdown-item" href="{{route('users.edit', Auth::user()->id)}}">{{ __('Edit') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
