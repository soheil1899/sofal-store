@extends('layouts.clientside.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 d-none d-lg-block pt-5">
                <img class="mt-5" src="/images/7.jpg" width="100%">
            </div>



            <div class="col-md-8 col-lg-6 py-5">


                <h3 class="pb-5" style="text-align: center"><strong>ورود به سفالکده</strong></h3>
                <form class="pb-5" method="POST" action="{{ route('login') }}">
                    @csrf


                    <div class="form-group">

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" aria-describedby="emailHelp"
                               placeholder="آدرس ایمیل" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور"
                               name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <a class="pointer" href="{{ route('password.request') }}">
                            <u>
                                رمز عبور خود را فراموش کرده اید؟
                            </u>
                        </a>
                    </div>

                    <div class="form-group form-check pr-2 mt-5 mb-1">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label pr-3" for="exampleCheck1">مرا به خاطر داشته باش</label>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-block"><strong>وارد شوید</strong></button>

                    <a class="pointer btn btn-outline-secondary btn-block" href="{{route('register')}}">
                        هنوز ثبت نام نکرده اید؟
                        <strong class="mr-3">ثبت نام کنید</strong>
                    </a>
                </form>

            </div>

            <div class="col-lg-3 pt-5 d-none d-lg-block">
                <img class="mt-5" src="/images/77.jpg" width="100%">
            </div>
        </div>
    </div>
@endsection
