@extends('layouts.clientside.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-lg-3 d-none d-lg-block py-4">
            <img src="/images/7.jpg" width="100%">
        </div>



        <div class="col-md-8 col-lg-6 py-5">

            <h3 class="pb-5" style="text-align: center"><strong>یادآوری کلمه عبور</strong></h3>
            <form class="pb-5" method="POST" action="{{ route('password.email') }}">
                @csrf


                <div class="form-group">
                    <label class="m-2">ما ایمیلی برای شما ارسال می کنیم تا رمزعبور خود را تغییر دهید.</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" aria-describedby="emailHelp"
                           placeholder="آدرس ایمیل" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>


                <button type="submit" class="btn btn-outline-primary btn-block mt-5">یادآوری کلمه عبور</button>

            </form>


        </div>

    <div class="col-lg-3 py-4 d-none d-lg-block">
        <img src="/images/77.jpg" width="100%">
    </div>
    </div>
</div>
@endsection
