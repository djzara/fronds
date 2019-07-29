<?php
/**
 * User: zara
 * Date: 2018-12-29
 * Time: 22:40
 */

namespace Fronds\Http\Controllers;

/**
 * Class HomeController
 * @package Fronds\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }
}
