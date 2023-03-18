<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirstController extends Controller
{
    public function building($text = "建物です")
    {
        return $text;
    }

    public function room($room)
    {
        return '部屋番号は' . "{$room}" . 'です';
    }
}
