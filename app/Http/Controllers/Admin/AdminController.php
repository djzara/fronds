<?php
/**
 * User: zara
 * Date: 2019-04-21
 * Time: 13:35
 */

namespace Fronds\Http\Controllers\Admin;

use Fronds\Http\Controllers\Controller;

/**
 * Class AdminController
 * @package Fronds\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    public function loginHome()
    {
        return view('admin.auth.login');
    }
}
