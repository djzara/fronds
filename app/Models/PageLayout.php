<?php

declare(strict_types=1);

namespace Fronds\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Webpatser\Uuid\Uuid as WebpatserUuid;

/**
 * Fronds\Models\PageLayout
 *
 * @property int $id
 * @property string $uuid
 * @property string $layout_name
 * @property int $columns
 * @property int $width
 * @property int $supports_actions
 * @property int|null $max_actions
 * @property string $units
 * @property string $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|PageLayout newModelQuery()
 * @method static Builder|PageLayout newQuery()
 * @method static \Illuminate\Database\Query\Builder|PageLayout onlyTrashed()
 * @method static Builder|PageLayout query()
 * @method static Builder|PageLayout whereColumns($value)
 * @method static Builder|PageLayout whereCreatedAt($value)
 * @method static Builder|PageLayout whereCreatedBy($value)
 * @method static Builder|PageLayout whereDeletedAt($value)
 * @method static Builder|PageLayout whereId($value)
 * @method static Builder|PageLayout whereLayoutName($value)
 * @method static Builder|PageLayout whereMaxActions($value)
 * @method static Builder|PageLayout whereSupportsActions($value)
 * @method static Builder|PageLayout whereUnits($value)
 * @method static Builder|PageLayout whereUpdatedAt($value)
 * @method static Builder|PageLayout whereUuid($value)
 * @method static Builder|PageLayout whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|PageLayout withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PageLayout withoutTrashed()
 * @mixin Eloquent
 */
class PageLayout extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $guarded = [
        'uuid', 'created_by'
    ];

    public function setUuidAttribute(): void
    {
        $this->attributes['uuid'] = WebpatserUuid::generate()->string;
    }
}
