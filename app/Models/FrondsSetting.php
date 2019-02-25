<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 17:04
 */

namespace Fronds\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Fronds\Models\FrondsSetting
 *
 * @property int $id
 * @property string $setting_name
 * @property string|null $setting_value
 * @property int $setting_switch
 * @property string $setting_time
 * @property string $setting_type
 * @property string|null $owner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereSettingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereSettingSwitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereSettingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereSettingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereSettingValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FrondsSetting whereUpdatedAt($value)
 * @mixin \Eloquent
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


}