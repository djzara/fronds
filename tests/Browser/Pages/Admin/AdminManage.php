<?php

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Page;

/**
 * Class AdminManage
 * @package Tests\Browser\Pages\Admin
 */
class AdminManage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/a/manage';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@manage-header' => '#fronds-admin-header',
            '@manage-header-text' => '#fronds-admin-header-banner',
            '@manage-action-panel' => '.fronds-action-panel',
            '@manage-action-panel-header' => '.fronds-action-panel-header',
            '@manage-action-panel-body' => '.fronds-action-panel-body',
            '@manage-action-panel-footer' => '.fronds-action-panel-footer',
        ];
    }
}
