<?php
/**
 * User: zara
 * Date: 2019-04-21
 * Time: 13:35
 */

namespace Fronds\Http\Controllers\Admin;

use Fronds\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class AdminController
 * @package Fronds\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @return View
     */
    public function loginHome() : View
    {
        return view('admin.auth.login');
    }
}
