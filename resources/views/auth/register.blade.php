@extends('layouts.clientside.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 d-none d-lg-block pt-5">
            <img class="mt-5" src="/images/7.jpg" width="100%">
        </div>


        <div class="col-md-8 col-lg-6 py-5">
            <h3 class="pb-5" style="text-align: center"><strong>ثبت نام در سفالکده</strong></h3>
            <form class="pb-5" method="POST" action="{{ route('register') }}">
                @csrf


                <div class="form-group">

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="نام کاربری">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="آدرس ایمیل">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="رمز عبور">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="تکرار رمز عبور">
                </div>

                <button type="submit" class="btn btn-outline-primary btn-block mt-5"><strong>ثبت نام کنید</strong></button>

                <a class="pointer btn btn-outline-secondary btn-block" href="{{route('login')}}">
                    قبلا ثبت نام کرده اید؟
                    <strong class="mr-3">وارد شوید</strong>
                </a>
            </form>


        </div>
        <div class="col-lg-3 pt-5 d-none d-lg-block">
            <img class="mt-5" src="/images/77.jpg" width="100%">
        </div>
    </div>
</div>
@endsection
