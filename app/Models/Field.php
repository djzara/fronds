<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:46
 */

namespace Fronds\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @method static Builder|Field newModelQuery()
 * @method static Builder|Field newQuery()
 * @method static \Illuminate\Database\Query\Builder|Field onlyTrashed()
 * @method static Builder|Field query()
 * @method static bool|null restore()
 * @method static Builder|Field whereCreatedAt($value)
 * @method static Builder|Field whereDeletedAt($value)
 * @method static Builder|Field whereFieldHint($value)
 * @method static Builder|Field whereFieldLabel($value)
 * @method static Builder|Field whereFieldMarkupId($value)
 * @method static Builder|Field whereFieldType($value)
 * @method static Builder|Field whereId($value)
 * @method static Builder|Field whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Field withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Field withoutTrashed()
 * @mixin Eloquent
 * @property-read Collection|Form[] $forms
 * @property-read int|null $forms_count
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
    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(Form::class, 'form_fields');
    }
}
