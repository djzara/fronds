<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:52
 */

namespace Fronds\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Fronds\Models\FormField
 *
 * @property int $form_id
 * @property int $field_id
 * @property string $field_value
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField whereFieldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField whereFormId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\Field[] $definition
 * @property-read \Fronds\Models\Form $form
 * @property-read \Fronds\Models\User $uploader
 * @property-read int|null $definition_count
 */
class FormField extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'field_id',
        'field_value'
    ];

    /**
     * @return BelongsTo
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    /**
     * @return HasOne
     */
    public function definition(): HasOne
    {
        return $this->hasOne(Field::class, 'id', 'field_id');
    }

    /**
     * @return BelongsTo
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owned_by');
    }
}
