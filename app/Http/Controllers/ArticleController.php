<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return view('clientside.article');
    }

    public function getarticles()
    {
        return Article::with(['keywords', 'article_group', 'tags', 'contents.galleries', 'user.userinfo'])->orderBy('order', 'desc')->get();
    }

    public function avg($num1, $num2)
    {
        return ($num1+$num2)/2 ;
    }
}
