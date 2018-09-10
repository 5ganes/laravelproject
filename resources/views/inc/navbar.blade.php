<style>
    .navbar-collapse{ display: flex;background: black }
    .navbar-nav{display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    width: 50%;}
    .ml-auto{display: flex;
    flex-direction: row;
    width: 20%;
    justify-content: space-evenly;}
</style>
<nav class="navbar navbar-inverse">
    <div class="container">
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button> --}}

        <div class="navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'TestProject') }}</a></li>
                <li><a class="navbar-brand" href="/">Home</a></li>
                <li><a class="navbar-brand" href="/about">About</a></li>
                <li><a class="navbar-brand" href="/services">Services</a></li>
                <li><a class="navbar-brand" href="/posts">Blog</a></li>
                <li><a class="navbar-brand" href="/posts/create">Create Post</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="/dashboard">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>