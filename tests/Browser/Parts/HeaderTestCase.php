<?php
/**
 * User: zara
 * Date: 2019-01-22
 * Time: 20:27
 */

namespace Tests\Browser\Parts;


use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class HeaderTestCase extends DuskTestCase
{

    public function testHomePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('fronds.home')
                ->assertSee('A link');
        });
    }
}
