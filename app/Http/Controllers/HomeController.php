<?php
/**
 * User: zara
 * Date: 2018-12-29
 * Time: 22:40
 */

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function home() {
        return view('home');
    }

}
