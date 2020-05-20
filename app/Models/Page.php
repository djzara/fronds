<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 17:09
 */

namespace Fronds\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Fronds\Models\Page
 *
 * @property string $id
 * @property string $page_title
 * @property string|null $page_body
 * @property int $page_content_width in pixels, 0 is full
 * @property int $page_content_height in pixels, 0 is full
 * @property int|null $form_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static \Illuminate\Database\Query\Builder|Page onlyTrashed()
 * @method static Builder|Page query()
 * @method static bool|null restore()
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereDeletedAt($value)
 * @method static Builder|Page whereFormId($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page wherePageBody($value)
 * @method static Builder|Page wherePageContentHeight($value)
 * @method static Builder|Page wherePageContentWidth($value)
 * @method static Builder|Page wherePageTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Page withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Page withoutTrashed()
 * @mixin Eloquent
 * @property-read Form $formDef
 * @property string $slug
 * @method static Builder|Page whereSlug($value)
 * @property string $page_layout
 * @method static Builder|Page wherePageLayout($value)
 */
class Page extends Model
{

    use SoftDeletes;
    use UuidModelTrait;

    protected $fillable = [
        'page_title',
        'page_layout',
        'slug'
    ];
}
