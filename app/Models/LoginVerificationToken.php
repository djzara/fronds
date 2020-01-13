<?php
/**
 * User: zara
 * Date: 2019-02-18
 * Time: 20:56
 */

namespace Fronds\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Crypt;

/**
 * Fronds\Models\LoginVerificationToken
 *
 * @property int $id
 * @property string $user_id
 * @property string $token
 * @property string $origin_ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $used_on
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\LoginVerificationToken onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken whereOriginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken whereUsedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\LoginVerificationToken whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\LoginVerificationToken withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\LoginVerificationToken withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Fronds\Models\User $user
 * @property-read bool $valid_origin
 */
class LoginVerificationToken extends Model
{

    public const DELETED_AT = 'used_on';

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'token',
        'origin_ip'
    ];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * We can use this custom accessor to do the validation of the
     * token
     * @return bool
     */
    public function getValidOriginAttribute(): bool
    {
        $tokenParts = Crypt::decrypt($this->token);
        $currentIp = request()->ip();
        return $currentIp === $tokenParts['ip']
            && $this->user->email === $tokenParts['username']
            && $tokenParts['is_valid'] === true;
    }
}
