<?php

namespace Tests\Browser\Views\Admin\Actions;

use Fronds\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\ManagePageAction;
use Tests\Browser\Pages\Admin\AdminManage;
use Fronds\Models\Page as PageModel;
use Tests\DuskTestCase;
use DB;

/**
 * Class PageActionTest
 * @package Tests\Browser\Views\Admin\Actions
 */
class PageActionTest extends DuskTestCase
{

    /**
     * @var User
     */
    private $user;

    public function setUp():void
    {
        parent::setUp();
        DB::table('pages')->truncate();
        $this->user = factory(User::class, 1)->create()[0];
    }

    /**
     * @throws \Throwable
     */
    public function testAddPageFormAppears(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage())
                ->click('@manage-page-add-btn')
                ->waitFor('@manage-page-modal')
                ->within(new ManagePageAction(), static function (Browser $browser) {
                    $browser->assertSee('Add Page')
                        ->assertPresent('@page-action-form-title')
                        ->assertSee('Page Title')
                        ->assertPresent('@page-action-form-slug')
                        ->assertSee('Slug')
                        ->assertPresent('@page-action-form-layout')
                        ->assertSee('Page layout');
                })
                ->assertVue('showPagesForm', true, '@manage-page-component-name');

        });
    }

    /**
     * @throws \Throwable
     */
    public function testAddPageClosesOnCancel(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage())
                ->click('@manage-page-add-btn')
                ->waitFor('@manage-page-modal')
                ->within(new ManagePageAction(), static function (Browser $browser) {
                    $browser->click('@page-action-modal-cancel');
                })
                ->waitUntilMissing((new ManagePageAction())->selector())
                ->assertVue('showPagesForm', false, '@manage-page-component-name');

        });
    }

    /**
     * @throws \Throwable
     */
    public function testAddPageClearsOnCancel(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage())
                ->click('@manage-page-add-btn')
                ->waitFor('@manage-page-modal')
                ->within(new ManagePageAction(), static function (Browser $browser) {
                    $browser->type('@page-action-form-title', 'Test Title')
                        ->select('@page-action-form-layout', 'full-page')
                        ->click('@page-action-modal-cancel');
                })
                ->assertVue('pageInfo.title', 'Test Title', '@manage-page-component-name')
                ->assertVue('pageInfo.slug', 'test-title', '@manage-page-component-name')
                ->assertVue('pageInfo.selectedLayout', 'full-page', '@manage-page-component-name')
                ->waitUntilMissing((new ManagePageAction())->selector())
                ->click('@manage-page-add-btn')
                ->waitFor('@manage-page-modal')
                ->assertVue('pageInfo.title', '', '@manage-page-component-name')
                ->assertVue('pageInfo.slug', '', '@manage-page-component-name')
                // full-page is the current default
                ->assertVue('pageInfo.selectedLayout', 'full-page', '@manage-page-component-name');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testAddPageErrorsOnMissingInput(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage())
                ->click('@manage-page-add-btn')
                ->waitFor('@manage-page-modal')
                ->within(new ManagePageAction(), static function (Browser $browser) {
                    $browser->click('@page-action-modal-ok')
                    ->pause(2500)
                    ->assertSee(__('validation.custom.title.required'))
                    ->assertSee(__('validation.custom.slug.required'));
                })
                ->assertVue('formElementsInfo.title.valid', false, '@manage-page-component-name')
                ->assertVue('formElementsInfo.slug.valid', false, '@manage-page-component-name');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testAddPageErrorsOnInvalidInput(): void
    {
        factory(PageModel::class)->create(['page_title' => 'Test Title', 'slug' => 'test-title']);
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage())
                ->click('@manage-page-add-btn')
                ->waitFor('@manage-page-modal')
                ->within(new ManagePageAction(), static function (Browser $browser) {
                    $browser->type('@page-action-form-title', 'Test Title')
                        ->select('@page-action-form-layout', 'full-page')
                        ->click('@page-action-modal-ok')
                        ->pause(2500)
                        ->assertSee(__('validation.custom.slug.unique'));
                })
                ->assertVue('formElementsInfo.slug.valid', false, '@manage-page-component-name');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testAddPageSuccessOnValidInput(): void
    {
        $this->markTestSkipped('debugging false positive');
        $this->browse(static function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visit(new AdminManage())
                ->click('@manage-page-add-btn')
                ->waitFor('@manage-page-modal')
                ->within(new ManagePageAction(), static function (Browser $browser) {
                    $browser->type('@page-action-form-title', 'Testing Title 2')
                        ->select('@page-action-form-layout', 'full-page')
                        ->click('@page-action-modal-ok');
                })
                ->assertVue('formElementsInfo.slug.valid', null, '@manage-page-component-name')
                ->assertVue('formElementsInfo.layout.valid', null, '@manage-page-component-name')
                ->assertVue('formElementsInfo.title.valid', null, '@manage-page-component-name')
                ->pause(2500)
                ->assertSee('Page Created Successfully');

        });
    }

}
