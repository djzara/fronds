<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:52
 */

namespace Fronds\Models;


use Illuminate\Database\Eloquent\Model;

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
 */
class FormField extends Model
{

    public $timestamps = false;
    protected $primaryKey = 'form_id';
    public $incrementing = false;

    protected $fillable = [
        'form_id',
        'field_id',
        'field_value'
    ];
}