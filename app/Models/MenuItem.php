<?php

declare(strict_types=1);

namespace Fronds\Models;

use Fronds\Lib\Traits\FrondsUsesUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class MenuItem
 *
 * @package Fronds\Models
 * @author Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 * @property int $id
 * @property string $uuid
 * @property string $direct_to
 * @property string|null $external_link
 * @property string|null $page_id
 * @property string $label
 * @property string|null $field_id
 * @property int $list_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int $menu_definition_id
 * @method static Builder|MenuItem newModelQuery()
 * @method static Builder|MenuItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|MenuItem onlyTrashed()
 * @method static Builder|MenuItem query()
 * @method static Builder|MenuItem whereCreatedAt($value)
 * @method static Builder|MenuItem whereDeletedAt($value)
 * @method static Builder|MenuItem whereDirectTo($value)
 * @method static Builder|MenuItem whereExternalLink($value)
 * @method static Builder|MenuItem whereFieldId($value)
 * @method static Builder|MenuItem whereId($value)
 * @method static Builder|MenuItem whereLabel($value)
 * @method static Builder|MenuItem whereListOrder($value)
 * @method static Builder|MenuItem whereMenuDefinitionId($value)
 * @method static Builder|MenuItem wherePageId($value)
 * @method static Builder|MenuItem whereUpdatedAt($value)
 * @method static Builder|MenuItem whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|MenuItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MenuItem withoutTrashed()
 * @mixin \Eloquent
 * @property-read MenuDefinition $definition
 */
class MenuItem extends Model
{

    use SoftDeletes;
    use FrondsUsesUUID;

    protected $fillable = [
        'uuid',
        'direct_to',
        'external_link',
        'page_id',
        'label',
        'field_id',
        'list_order',
        'menu_definition_id'
    ];

    protected $hidden = [
        'id',
        'deleted_at',
        'menu_definition_id'
    ];
    /**
     * @return BelongsTo
     */
    public function definition(): BelongsTo
    {
        return $this->belongsTo(MenuDefinition::class, 'menu_definition_id');
    }

    /**
     * @param $val
     */
    public function setExternalLinkAttribute($val): void
    {
        $this->attributes['external_link'] = strtolower($val);
    }
}
