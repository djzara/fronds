<?php

declare(strict_types=1);

namespace Fronds\Lib\Traits;

use Webpatser\Uuid\Uuid;

/**
 * Trait FrondsUsesUUID
 *
 * @package Fronds\Lib\Traits
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
trait FrondsUsesUUID
{
    protected static string $uuidColName = 'uuid';

    protected static function booted()
    {
        static::creating(static function ($model) {
            $model->{static::$uuidColName} = Uuid::generate()->string;
        });
    }
}
