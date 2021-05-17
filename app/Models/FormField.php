<?php

declare(strict_types=1);
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:52
 */

namespace Fronds\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

/**
 * Fronds\Models\FormField
 *
 * @property int $form_id
 * @property int $field_id
 * @property string $field_value
 * @method static Builder|FormField newModelQuery()
 * @method static Builder|FormField newQuery()
 * @method static Builder|FormField query()
 * @method static Builder|FormField whereFieldId($value)
 * @method static Builder|FormField whereFieldValue($value)
 * @method static Builder|FormField whereFormId($value)
 * @mixin Eloquent
 * @property-read Collection|Field[] $definition
 * @property-read Form $form
 * @property-read User $uploader
 * @property-read int|null $definition_count
 * @property string|null $owned_by
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FormField whereOwnedBy($value)
 */
class FormField extends Model
{

    use SoftDeletes;
    use HasFactory;
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
