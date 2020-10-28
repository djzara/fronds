<?php

declare(strict_types=1);

namespace Fronds\Lib\Extensions\Blade;

use Fronds\Lib\Extensions\ExtensionBuilder;

/**
 * Class MenuContent
 *
 * @package Fronds\Lib\Extensions\Blade
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 * @codeCoverageIgnore
 */
class MenuContent extends ExtensionBuilder implements BladeExtension
{

    /**
     * @param  mixed  $arguments
     * @return mixed|string
     */
    public function getExtensionSource($arguments)
    {
        $menuContentFolder = trim(explode(',', $arguments)[0], ' \'"');
        $menuContentView = trim(explode(',', $arguments)[1], ' \'"');
        $viewPath = '\'theme.'.config('fronds.theme'). ".menus.$menuContentFolder.$menuContentView'";
        return <<<HTML
<section data-fronds-menu-name="$menuContentView" style="display:none;">
<?php echo \$__env->make({$viewPath},
        \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])
        +['panelName' => '$menuContentView'])->render(); ?>
</section>
HTML;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function withValues(array $arguments): void
    {
    }

    public static function build(): ExtensionBuilder
    {
        return new self();
    }

    protected function getExtension(): BladeExtension
    {
        return $this;
    }
}
