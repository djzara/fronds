<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 17:04
 */

namespace Fronds\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Fronds\Models\FrondsSetting
 *
 * @property int $id
 * @property string $setting_name
 * @property string|null $setting_value
 * @property int $setting_switch
 * @property string $setting_time
 * @property string $setting_type
 * @property User $owner
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|FrondsSetting newModelQuery()
 * @method static Builder|FrondsSetting newQuery()
 * @method static Builder|FrondsSetting query()
 * @method static Builder|FrondsSetting whereCreatedAt($value)
 * @method static Builder|FrondsSetting whereId($value)
 * @method static Builder|FrondsSetting whereOwner($value)
 * @method static Builder|FrondsSetting whereSettingName($value)
 * @method static Builder|FrondsSetting whereSettingSwitch($value)
 * @method static Builder|FrondsSetting whereSettingTime($value)
 * @method static Builder|FrondsSetting whereSettingType($value)
 * @method static Builder|FrondsSetting whereSettingValue($value)
 * @method static Builder|FrondsSetting whereUpdatedAt($value)
 * @mixin Eloquent
 */
class FrondsSetting extends Model
{
    protected $table = 'fronds_settings';

    protected $fillable = [
        'setting_name',
        'setting_value',
        'setting_switch',
        'setting_type',
        'owner'
    ];

    /**
     * @return BelongsTo
     */
    public function ownedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner', 'id');
    }
}
