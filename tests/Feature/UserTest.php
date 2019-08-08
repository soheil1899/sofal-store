<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\ArticleController;

class UserTest extends TestCase
{

    public function testAvg()
    {
        $num1 = 20;
        $num2 = 60;

        $mycon = new ArticleController();
        $avg = $mycon->avg($num1, $num2);
        $this->assertEquals(40, $avg);
    }
}
