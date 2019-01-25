<?php
/**
 * User: zara
 * Date: 2019-01-22
 * Time: 20:29
 */

namespace Tests\Browser\Views;


use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class HomePageTest extends DuskTestCase
{

    /**
     * @throws \Throwable
     */
    public function testHomePage() : void {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('fronds.home')
                ->assertSee('A link');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testHeaderContainer() : void {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('fronds.home')
                ->assertPresent('@fronds-header-cont');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testActionBar() : void {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('fronds.home')
                ->assertPresent('@fronds-action-bar')
            ;
        });
    }
}
