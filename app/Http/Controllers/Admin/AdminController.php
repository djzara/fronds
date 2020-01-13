<?php
/**
 * User: zara
 * Date: 2019-04-21
 * Time: 13:35
 */

namespace Fronds\Http\Controllers\Admin;

use Fronds\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AdminController
 * @package Fronds\Http\Controllers\Admin
 */
class AdminController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/a';

    /**
     * Boilerplate from setup
     * AdminController constructor
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = route('fronds.admin.manage');
    }

    /**
     * @return View
     */
    public function loginHome(): View
    {
        $submitLoginTo = route('fronds.admin.submit.login');
        return view('admin.auth.login', ['submitLoginTo' => $submitLoginTo]);
    }

    /**
     * @return View
     */
    public function manage(): View
    {
        return view('admin.manage');
    }
}
