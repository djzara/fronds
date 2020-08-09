<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

/**
 * Class ManagePageAction
 *
 * @package Tests\Browser\Components
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class ManagePageAction extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '#fronds-actions-pages-modal';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@page-action-title' => '#modal-header',
            '@page-action-form-title' => '#fronds-actions-pages-title',
            '@page-action-form-slug' => '#fronds-actions-pages-slug',
            '@page-action-form-layout' => '#fronds-actions-pages-layout',
            '@page-action-success-msg' => '#fronds-add-page-message-success',
            '@page-action-title-error' => '#fronds-actions-pages-title .fronds-text-invalid',
            '@page-action-slug-error' => '#fronds-actions-pages-slug .fronds-text-invalid',
            '@page-action-modal-ok' => '.modal-footer button.btn.btn-primary',
            '@page-action-modal-cancel' => '.modal-footer button.btn.btn-secondary'
        ];
    }
}
