<?php

declare(strict_types=1);

namespace Fronds\Models;

use Eloquent;
use Fronds\Lib\Traits\FrondsUsesUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class MenuDefinition
 *
 * @package Fronds\Models
 * @author Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 * @property int $id
 * @property string $uuid
 * @property string $menu_title
 * @property string $menu_type
 * @property int $is_hidden
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|MenuDefinition newModelQuery()
 * @method static Builder|MenuDefinition newQuery()
 * @method static \Illuminate\Database\Query\Builder|MenuDefinition onlyTrashed()
 * @method static Builder|MenuDefinition query()
 * @method static Builder|MenuDefinition whereCreatedAt($value)
 * @method static Builder|MenuDefinition whereDeletedAt($value)
 * @method static Builder|MenuDefinition whereId($value)
 * @method static Builder|MenuDefinition whereIsHidden($value)
 * @method static Builder|MenuDefinition whereMenuTitle($value)
 * @method static Builder|MenuDefinition whereMenuType($value)
 * @method static Builder|MenuDefinition whereUpdatedAt($value)
 * @method static Builder|MenuDefinition whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|MenuDefinition withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MenuDefinition withoutTrashed()
 * @mixin Eloquent
 * @property-read Collection|MenuItem[] $items
 * @property-read int|null $items_count
 */
class MenuDefinition extends Model
{

    use FrondsUsesUUID;
    use SoftDeletes;

    protected $fillable = [
        'menu_title',
        'menu_type',
        'is_hidden'
    ];

    protected $hidden = [
        'id',
        'deleted_at',
        'created_at',
        'is_hidden'
    ];


    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
