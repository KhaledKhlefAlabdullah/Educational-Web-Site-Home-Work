<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="{{route('blade.home')}}">{{__("Knowledge")}}</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-item nav-link active" href="{{route('blade.home')}}">{{__("Home")}}</a></li>
                <li><a class="nav-item nav-link " href="{{route('blade.about')}}">{{__("About")}}</a></li>
                <li><a class="nav-item nav-link " href="{{route('courses.index')}}">{{__("courses")}}</a></li>
                <li><a class="nav-item nav-link " href="{{route('blade.trainers')}}">{{__("Trainers")}}</a></li>
                <li><a class="nav-item nav-link " href="{{route('blade.events')}}">{{__("Events")}}</a></li>
                <li><a class="nav-item nav-link " href="{{route('blade.pricing')}}">{{__("Pricing")}}</a></li>
                <li><a class="nav-item nav-link " href="{{route('blade.contact')}}">{{__("Contact")}}</a></li>
                <li class="dropdown fas fa-caret-down"><a href="#" ><i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#"><i></i></a></li>

                        <x-sub-dropdown title="{{__('language')}}">
                            <ul>
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                         </x-sub-dropdown>

                        @if (Route::has('login'))
                            @auth
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                         class="btn "
                                                         onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}">{{__("Log in")}}</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{route('register')}}" >{{__("register")}}</a></li>
                                @endif
                            @endif
                        @endauth

                    </ul>
                </li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
        &nbsp;
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                @auth
                    @if(auth()->user()->details->user_type == 'admin')
                        <a href="{{route('admin.index')}}" class="get-started-btn"> {{__('Dashboard')}}</a>
                    @else
                        <a href="{{ url('/profile') }}" class="get-started-btn">{{__("Profile")}}</a>
                    @endif
                @else
                    <a href="{{route('register')}}" class="get-started-btn" >{{__("register")}}</a>
                @endauth

            </div>
        @endif


    </div>

</header><!-- End Header -->
