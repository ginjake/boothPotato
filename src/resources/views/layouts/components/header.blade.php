<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand w-50" href="#"><img src="{{ asset(('images/logoHeader.png')) }}"  class="mw-100"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">

                @guest
                    @isset($user)
                    <li class="nav-item">
                        <p class="nav-link"> {{ $user->name}}さんの欲しいモノ</p>
                    </li>
                    @endisset
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @isset($user)
                        @if($user->id != Auth::user()->id)
                            <li class="nav-item mt-1">
                                <p class="nav-link"> {{ $user->name}}さんの欲しいモノ</p>
                            </li>
                        @endif
                    @endisset
                    <li class="nav-item m-2">
                        <a href="{{ route('gift.create')}}" class="btn btn-primary"> {{ __('欲しいモノ登録') }} </a>
                    <li>
                    <li class="nav-item m-2">
                        <a href="https://twitter.com/intent/tweet?text={{urlencode(Auth::user()->name)}}さんのBOOTH欲しいモノです {{ url()->current()}}?id={{urlencode(Auth::user()->twitterId).urlencode(' #booth欲しいモノリスト')}} " target="_blank" class="btn btn-primary"> {{ __('ツイート') }} </a>
                    <li>
                    <li class="nav-item dropdown m-2">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
