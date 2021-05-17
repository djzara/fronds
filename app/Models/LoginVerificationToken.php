<?php

declare(strict_types=1);
/**
 * User: zara
 * Date: 2019-02-18
 * Time: 20:56
 */

namespace Fronds\Models;

use Crypt;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Fronds\Models\LoginVerificationToken
 *
 * @property int $id
 * @property string $user_id
 * @property string $token
 * @property string $origin_ip
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $used_on
 * @method static bool|null forceDelete()
 * @method static Builder|LoginVerificationToken newModelQuery()
 * @method static Builder|LoginVerificationToken newQuery()
 * @method static \Illuminate\Database\Query\Builder|LoginVerificationToken onlyTrashed()
 * @method static Builder|LoginVerificationToken query()
 * @method static bool|null restore()
 * @method static Builder|LoginVerificationToken whereCreatedAt($value)
 * @method static Builder|LoginVerificationToken whereId($value)
 * @method static Builder|LoginVerificationToken whereOriginIp($value)
 * @method static Builder|LoginVerificationToken whereToken($value)
 * @method static Builder|LoginVerificationToken whereUpdatedAt($value)
 * @method static Builder|LoginVerificationToken whereUsedOn($value)
 * @method static Builder|LoginVerificationToken whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|LoginVerificationToken withTrashed()
 * @method static \Illuminate\Database\Query\Builder|LoginVerificationToken withoutTrashed()
 * @mixin Eloquent
 * @property-read User $user
 * @property-read bool $valid_origin
 */
class LoginVerificationToken extends Model
{

    public const DELETED_AT = 'used_on';

    use SoftDeletes;
    use HasFactory;

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
