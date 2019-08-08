@extends('layouts.clientside.master')

@section('content')

    <div class="container pt-3 px-5">



        <div class="row-seperator mt-5">
            <div>
                <strong>
                    پرفروش ترین محصولات
                </strong>
            </div>
        </div>
        <section class="pt-3">
            <home-slider-component :type="'mostsell'"></home-slider-component>
        </section>



        <section class="pb-4">
            <div class="row mb-2">
                <div class="col-12 col-lg-6 mb-lg-0 mb-4">
                    <div class="row m-0">
                        <div class="mb-4 cashi">
                            <img src="/images/22.jpg" width="100%" height="100%">
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="cashi">
                            <img src="/images/3.jpg" width="100%" height="100%">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="cashi height-100">
                        <img src="/images/1.jpg" width="100%" height="100%">
                    </div>
                </div>
            </div>
        </section>


        <div class="row-seperator mt-5">
            <div>
                <strong>
                    آخرین مطالب
                </strong>
            </div>
        </div>
        <section class="py-3">
            <home-slider-article-component></home-slider-article-component>
        </section>



        <div class="row-seperator mt-5">
            <div>
                <strong>
                    محصولات جدید
                </strong>
            </div>
        </div>

        <section class="pt-3">
            <home-slider-component :type="'newest'"></home-slider-component>
        </section>
    </div>



@endsection





