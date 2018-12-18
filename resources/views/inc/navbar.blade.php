<nav class="navbar navbar-expand-md navbar-laravel bg-primary" style="margin-bottom:10px;">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">
            {{ config('app.name', 'E3mly') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <!--
                    show feedback for both mod. and admins
                    
                    -->
                    
                  
                    @if(Auth::guard('moderator')->check())
                    
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/feedback">Feedbacks against Posts</a>
                    </li> 

                    <li class="nav-item">
                            <a class="nav-link text-white" href="/moderator">All Posts</a>
                    </li>
                    @endif

                    @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/profile">Users</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="/feedback">Feedbacks against Users</a>
                        </li>                                             
                    @endif 
                    
                    @if(Auth::guard('web')->check())    
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/posts">view posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/posts/create">create project</a>
                        </li>
                    @endif   
                    
                   
                </ul>
            </div>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if(Auth::guest())
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}"><i class="fa fa-sign-in-alt "></i> {{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('register'))
                            <a class="nav-link text-white" href="{{ route('register') }}"><i class="fa fa-user-plus "></i> {{ __('Register') }}</a>
                        @endif
                    </li>
                @else
                    <li class="na-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <span class="fa fa-globe-africa"style="margin-right:5px;"></span>Notifications <span class="badge badge-danger">2<span>
                        </a>     
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                            <li><a class="dropdown-item" href="/home">Dashboard<a></li>
                            <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>