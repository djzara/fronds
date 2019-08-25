<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:46
 */

namespace Fronds\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Fronds\Models\Field
 *
 * @property int $id
 * @property string $field_label
 * @property string|null $field_markup_id
 * @property string $field_type
 * @property string $field_hint
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Field onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereFieldHint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereFieldLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereFieldMarkupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Field whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Field withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Field withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\Form[] $forms
 */
class Field extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'field_label',
        'field_markup_id',
        'field_type',
        'field_hint'
    ];

    /**
     * @return BelongsToMany
     */
    public function forms() : BelongsToMany {
        return $this->belongsToMany(Form::class, 'form_fields');
    }

}
