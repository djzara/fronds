<?php
/**
 * User: zara
 * Date: 2019-04-21
 * Time: 20:29
 */

namespace Tests\Browser\Views\Admin;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminLogin;
use Tests\DuskTestCase;

class AdminLoginPageTest extends DuskTestCase
{

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginButton() : void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('btnText', __('controls.button.admin.login'), '@fronds-admin-login-btn')
                ->assertVueIsNot('btnText', __('controls.input.admin.email'), '@fronds-admin-login-btn')
                ->assertSee(__('page.admin.title'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginEmailInput() : void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('inputLabel', __('controls.input.admin.email'), '@fronds-admin-login-email')
                ->assertVueIsNot('inputLabel', __('controls.button.admin.login'), '@fronds-admin-login-email')
                ->assertSee(__('page.admin.title'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginPassInput() : void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('inputLabel', __('controls.input.admin.password'), '@fronds-admin-login-pass')
                ->assertVueIsNot('inputLabel', __('controls.button.admin.login'), '@fronds-admin-login-pass')
                ->assertSee(__('page.admin.title'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginForm() : void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('id', 'fronds-login-form', '@fronds-login-form')
                ->assertSee(__('page.admin.title'));
        });
    }
}
