<?php

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Page;

class AdminLogin extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url(): string
    {
        return '/a';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements(): array
    {
        return [
            '@fronds-admin-login-btn' => '#fronds-admin-login-btn',
            '@fronds-admin-login-email' => '#fronds-admin-login-email',
            '@fronds-admin-login-pass' => '#fronds-admin-login-pass',
            '@fronds-admin-login-btn-action' => '#fronds-admin-login-btn #fronds-btn'
        ];
    }
}
