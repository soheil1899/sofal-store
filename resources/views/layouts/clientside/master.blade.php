<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>

        سفالکده

    </title>


    <meta name="description"
          content="تمامی ظروف سفالی خود را از ما بخواهید"/>
    <meta name="keywords"
          content="فروشگاه اینترنتی, خرید آنلاین، بشقاب سفالی, کاسه سفالی, لیوان سفالی, کوزه, چهره سفالی, پیشدستی سفالی, فروش اینترنتی، "/>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="/js/jquery-3.4.1.min.js"></script>

    <link rel="stylesheet" href="/css/app.css">

</head>


<body style="background-color: #fff">

@include('layouts.clientside.header')


<div id="front" style="padding-top: 70px">

    @yield('content')

</div>


@include('layouts.clientside.footer')


</body>




<script src="/js/client.js"></script>


















