<?php

namespace Tests\Browser\Views\Admin\Actions;

use Fronds\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\ManagePageAction;
use Tests\Browser\Pages\Admin\AdminManage;
use Fronds\Models\Page as PageModel;
use Tests\DuskTestCase;
use DB;
use Throwable;

/**
 * Class PageActionTest
 * @package Tests\Browser\Views\Admin\Actions
 */
class PageActionTest extends DuskTestCase
{

    use RefreshDatabase;

    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        PageModel::truncate();
        $this->user = factory(User::class, 1)->create();
    }

    /**
     * @throws Throwable
     */
    public function testAddPageFormAppears(): void
    {
        factory(User::class, 1)->create();
        $this->browse(
            static function (Browser $browser) {
                $browser->loginAs(User::first())
                    ->visit(new AdminManage())
                    ->click('@manage-page-add-btn')
                    ->waitFor('@manage-page-modal')
                    ->within(
                        new ManagePageAction(),
                        static function (Browser $browser) {
                            $browser->assertSee('Add Page')
                                ->assertPresent('@page-action-form-title')
                                ->assertSee('Page Title')
                                ->assertPresent('@page-action-form-slug')
                                ->assertSee('Slug')
                                ->assertPresent('@page-action-form-layout')
                                ->assertSee('Page layout');
                        }
                    );
            }
        );
    }

    /**
     * @throws Throwable
     */
    public function testAddPageClosesOnCancel(): void
    {
        $localUser = $this->user;
        $this->browse(
            static function (Browser $browser) use ($localUser) {
                $browser->loginAs($localUser)
                    ->visit(new AdminManage())
                    ->click('@manage-page-add-btn')
                    ->waitFor('@manage-page-modal')
                    ->within(
                        new ManagePageAction(),
                        static function (Browser $browser) {
                            $browser->click('@page-action-modal-cancel');
                        }
                    )
                    ->waitUntilMissing((new ManagePageAction())->selector());
            }
        );
    }

    /**
     * @throws Throwable
     */
    public function testAddPageClearsOnCancel(): void
    {
        $localUser = $this->user;
        $this->browse(
            static function (Browser $browser) use ($localUser) {
                $browser->loginAs($localUser)
                    ->visit(new AdminManage())
                    ->click('@manage-page-add-btn')
                    ->waitFor('@manage-page-modal')
                    ->within(
                        new ManagePageAction(),
                        static function (Browser $browser) {
                            $browser->type('fronds-actions-pages-title', 'Test Title')
                                ->type('fronds-actions-pages-slug', 'test-title')
                                ->select('fronds-actions-pages-layout', 'full-page')
                                ->click('@page-action-modal-cancel');
                        }
                    )
                    ->waitUntilMissing((new ManagePageAction())->selector())
                    ->click('@manage-page-add-btn')
                    ->assertVue('pageInfo.title', '', '@manage-page-component-name')
                    ->assertVue('pageInfo.slug', '', '@manage-page-component-name')
                    // full-page is the current default
                    ->assertVue(
                        'pageInfo.selectedLayout',
                        'full-page',
                        '@manage-page-component-name'
                    );
            }
        );
    }

    /**
     * @throws Throwable
     */
    public function testAddPageErrorsOnMissingInput(): void
    {
        $localUser = $this->user;
        $this->browse(
            static function (Browser $browser) use ($localUser) {
                $browser->loginAs($localUser)
                    ->visit(new AdminManage())
                    ->click('@manage-page-add-btn')
                    ->waitFor('@manage-page-modal')
                    ->within(
                        new ManagePageAction(),
                        static function (Browser $browser) {
                            $browser->click('@page-action-modal-ok')
                                ->pause(2500)
                                ->assertSee(__('validation.custom.title.required'))
                                ->assertSee(__('validation.custom.slug.required'));
                        }
                    )
                    ->assertVue(
                        'formElementsInfo.title.valid',
                        'false',
                        '@manage-page-component-name'
                    )->assertVue('formElementsInfo.slug.valid', 'false', '@manage-page-component-name');
            }
        );
    }

    /**
     * @throws Throwable
     */
    public function testAddPageErrorsOnInvalidInput(): void
    {
        factory(PageModel::class)->create(['page_title' => 'Test Title', 'slug' => 'test-title']);
        $localUser = $this->user;
        $this->browse(
            static function (Browser $browser) use ($localUser) {
                $browser->loginAs($localUser)
                    ->visit(new AdminManage())
                    ->click('@manage-page-add-btn')
                    ->waitFor('@manage-page-modal')
                    ->within(
                        new ManagePageAction(),
                        static function (Browser $browser) {
                            $browser->type('fronds-actions-pages-title', 'Test Title')
                                ->type('fronds-actions-pages-slug', 'test-title')
                                ->select('fronds-actions-pages-layout', 'full-page')
                                ->click('@page-action-modal-ok')
                                ->pause(2500)
                                ->assertSee(__('validation.custom.slug.unique'));
                        }
                    );
            }
        );
    }

    /**
     * @throws Throwable
     */
    public function testAddPageSuccessOnValidInput(): void
    {
        $this->markTestSkipped('debugging false positive');
        $localUser = $this->user;
        $this->browse(
            static function (Browser $browser) use ($localUser) {
                $browser->loginAs($localUser)
                    ->visit(new AdminManage())
                    ->click('@manage-page-add-btn')
                    ->waitFor('@manage-page-modal')
                    ->within(
                        new ManagePageAction(),
                        static function (Browser $browser) {
                            $browser->type('fronds-actions-pages-title', 'Testing Title 2')
                                ->select('fronds-actions-pages-layout', 'full-page')
                                ->click('@page-action-modal-ok');
                        }
                    )
                    ->assertVue('formElementsInfo.slug.valid', null, '@manage-page-component-name')
                    ->assertVue('formElementsInfo.layout.valid', null, '@manage-page-component-name')
                    ->assertVue('formElementsInfo.title.valid', null, '@manage-page-component-name')
                    ->pause(2500)
                    ->assertSee('Page Created Successfully');
            }
        );
    }
}
