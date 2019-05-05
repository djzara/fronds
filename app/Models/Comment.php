<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:45
 */

namespace Fronds\Models;


use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Fronds\Models\Comment
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Comment withoutTrashed()
 * @mixin \Eloquent
 * @property string $body
 * @property string $comment_email
 * @property string $display_name
 * @property int $is_hidden
 * @property string|null $internal_owner
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereCommentEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereInternalOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Comment whereIsHidden($value)
 */
class Comment extends Model
{
    use SoftDeletes, UuidModelTrait;

    /**
     * @return HasOne
     */
    public function internal(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'internal_owner');
    }
}
