<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:45
 */

namespace Fronds\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Fronds\Models\Comment
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Comment onlyTrashed()
 * @method static Builder|Comment query()
 * @method static bool|null restore()
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereDeletedAt($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comment withoutTrashed()
 * @mixin Eloquent
 * @property string $body
 * @property string $comment_email
 * @property string $display_name
 * @property int $is_hidden
 * @property string|null $internal_owner
 * @method static Builder|Comment whereBody($value)
 * @method static Builder|Comment whereCommentEmail($value)
 * @method static Builder|Comment whereDisplayName($value)
 * @method static Builder|Comment whereInternalOwner($value)
 * @method static Builder|Comment whereIsHidden($value)
 * @property-read User $internal
 */
class Comment extends Model
{
    use SoftDeletes;
    use UuidModelTrait;
    use HasFactory;

    /**
     * @return HasOne
     */
    public function internal(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'internal_owner');
    }
}
