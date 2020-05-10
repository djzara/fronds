<?php

namespace Tests\Browser\Views\Admin;

use Fronds\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminManage;
use Tests\DuskTestCase;

class AdminManagePageTest extends DuskTestCase
{

    private $userId;

    public function setUp(): void
    {
        parent::setUp();
        $this->userId = factory(User::class, 1)->create()[0]->id;
    }

    /**
     * @throws \Throwable
     */
    public function testManageHeader(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage)
                ->assertPresent('@manage-header');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testManageHeaderBanner(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage)
                ->assertPresent('@manage-header-text')
                ->assertSeeIn('@manage-header-text', __('page.admin.header.home'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testManagePanelPresence(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage)
                ->assertPresent('@manage-action-panel');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testManagePanelHeader(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage)
                ->assertPresent('@manage-action-panel-header');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testManagePanelBody(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage)
                ->assertPresent('@manage-action-panel-body');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testManagePanelFooter(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage)
                ->assertPresent('@manage-action-panel-footer');
        });
    }
}
