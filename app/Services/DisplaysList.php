<?php

declare(strict_types=1);

namespace Fronds\Services;

/**
 * Interface DisplaysList
 *
 * @package Fronds\Services
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
interface DisplaysList
{

    /**
     * @param  bool  $paginated
     * @param  int  $pageSize
     * @return array
     */
    public function getForDisplay(bool $paginated = true, int $pageSize = 10): array;

    public function getListParamName(): string;
}
