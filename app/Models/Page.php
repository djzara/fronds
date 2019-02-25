<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 17:09
 */

namespace Fronds\Models;


use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Fronds\Models\Page
 *
 * @property string $id
 * @property string $page_title
 * @property string|null $page_body
 * @property int $page_content_width in pixels, 0 is full
 * @property int $page_content_height in pixels, 0 is full
 * @property int|null $form_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page wherePageBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page wherePageContentHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page wherePageContentWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page wherePageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Page withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Page withoutTrashed()
 * @mixin \Eloquent
 */
class Page extends Model
{

    use SoftDeletes, UuidModelTrait;

    protected $fillable = [
        'page_title',
        'page_body',
        'page_content_width',
        'page_content_height',
        'form_id'
    ];
}