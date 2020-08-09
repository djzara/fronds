<?php

namespace Fronds\Lib\Providers;

use Blade;
use Fronds\Lib\Collections\Extensions\BladeExtensionCollection;
use Fronds\Lib\Enums\TypeEnum;
use Fronds\Lib\Exceptions\Usage\FrondsIllegalArgumentException;
use Fronds\Lib\Exceptions\Usage\FrondsInvalidExtensionException;
use Fronds\Lib\Extensions\Blade\BladeExtension;
use Fronds\Lib\Extensions\Blade\ListedMenuWidget;
use Fronds\Lib\Extensions\Blade\MenuContent;
use Fronds\Lib\Extensions\Blade\MenuWidget;
use Fronds\Lib\Extensions\Blade\MenuWidgetClose;
use Illuminate\Support\ServiceProvider;

class FrondsTemplateProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Bootstrap services.
     *
     * @return void
     * @throws FrondsIllegalArgumentException
     */
    public function boot()
    {
        $this->bladeExtensions()->each(static function (BladeExtension $extension) {
            Blade::directive($extension->getName(), static function ($arguments) use ($extension) {
                return $extension->getExtensionSource(trim($arguments));
            });
        });
    }

    /**
     * @return BladeExtensionCollection
     * @throws FrondsIllegalArgumentException
     */
    protected function bladeExtensions(): BladeExtensionCollection
    {
        $extColl = new BladeExtensionCollection();
        $extColl->add(MenuWidget::build()
        ->name('frondsMenu')
        ->argument('templatePrefix', TypeEnum::name('string'))
        ->get());

        $extColl->add(MenuWidgetClose::build()
        ->name('endFrondsMenu')
        ->get());


        $extColl->add(ListedMenuWidget::build()
        ->name('frondsMenuItem')
        ->argument('menuLabel', TypeEnum::name('string'))
        ->argument('menuContents', TypeEnum::name('string'))
        ->get());

        $extColl->add(MenuContent::build()
        ->name('frondsMenuContent')
        ->argument('menuTemplate', TypeEnum::name('string')));
        return $extColl;
    }
}
