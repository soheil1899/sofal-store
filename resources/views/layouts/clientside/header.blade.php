<header id="client-header" style="position: fixed; width: 100%;z-index: 100; background-color: #fff">


    <style>
        .navbar-expand-lg{
            box-shadow: 0 3px 10px #ccc;
        }
    </style>


    <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler mb-2" style="background-color: #f1f1f1" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <img src="/images/line-menu.png" width="24px" height="24px">
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-0 p-0 mr-4">
                <li class="nav-item active">
                    <a class="nav-link px-3" href="/">
                        <strong>
                            سبد خرید
                        </strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{route('store')}}">
                        <strong>
                            فروشگاه
                        </strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{route('article')}}">
                        <strong>
                            مطالب
                        </strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="#">
                        <strong>
                            تماس با ما
                        </strong>
                    </a>
                </li>


            </ul>
            @if(auth()->check())
            <div class="m-auto d-none d-lg-block" style="padding-left: 290px;">
            @else
            <div class="m-auto d-none d-lg-block" style="padding-left: 200px;">
            @endif
                <a title="فروشگاه اینترنتی سفالکده" href="/dashboard">
                    <img src="/images/logo3.jpg" width="40px" height="60px" style="border-radius: 5px">
                </a>
            </div>

            <ul class="navbar-nav mr-0 p-0 ml-lg-4 mr-4">
                @if (auth()->check())
                    <li class="nav-item active">
                        <a class="nav-link px-3" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <strong>
                                خروج
                            </strong>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link px-3" href="{{route('login')}}">
                            <strong>
                                ورود
                            </strong>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link px-3" href="{{route('register')}}">
                            <strong>
                                ثبت نام
                            </strong>
                        </a>
                    </li>
                @endif
            </ul>


        </div>
    </nav>


</header>
