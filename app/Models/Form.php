<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:57
 */

namespace Fronds\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Fronds\Models\Form
 *
 * @property int $id
 * @property string $created_by
 * @property string $form_link_title
 * @property string $form_title
 * @property string $form_description
 * @property string $form_raw_body Pull from RTE
 * @property int $is_published
 * @property string $submit_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Fronds\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\Field[] $fields
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\FormField[] $values
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Form onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereFormDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereFormLinkTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereFormRawBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereFormTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereSubmitTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Form withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\Form withoutTrashed()
 * @mixin \Eloquent
 * @property-read int|null $fields_count
 */
class Form extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'form_link_title',
        'form_title',
        'form_description',
        'form_raw_body',
        'is_published',
        'submit_to'
    ];

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsToMany
     */
    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class, 'form_fields', 'form_id', 'field_id');
    }

}
