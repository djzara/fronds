<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:57
 */

namespace Fronds\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read User $creator
 * @property-read Collection|Field[] $fields
 * @property-read Collection|FormField[] $values
 * @method static bool|null forceDelete()
 * @method static Builder|Form newModelQuery()
 * @method static Builder|Form newQuery()
 * @method static \Illuminate\Database\Query\Builder|Form onlyTrashed()
 * @method static Builder|Form query()
 * @method static bool|null restore()
 * @method static Builder|Form whereCreatedAt($value)
 * @method static Builder|Form whereCreatedBy($value)
 * @method static Builder|Form whereDeletedAt($value)
 * @method static Builder|Form whereFormDescription($value)
 * @method static Builder|Form whereFormLinkTitle($value)
 * @method static Builder|Form whereFormRawBody($value)
 * @method static Builder|Form whereFormTitle($value)
 * @method static Builder|Form whereId($value)
 * @method static Builder|Form whereIsPublished($value)
 * @method static Builder|Form whereSubmitTo($value)
 * @method static Builder|Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Form withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Form withoutTrashed()
 * @mixin Eloquent
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
