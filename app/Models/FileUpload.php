<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:50
 */

namespace Fronds\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Fronds\Models\FileUpload
 *
 * @property int $id
 * @property string $original_file_name
 * @property string $file_mime
 * @property string $current_file_name
 * @property string $current_file_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\FileUpload onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereCurrentFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereCurrentFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereFileMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereOriginalFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\FileUpload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\FileUpload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\FileUpload withoutTrashed()
 * @mixin \Eloquent
 */
class FileUpload extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'original_file_name',
        'file_mime',
        'current_file_name',
        'current_file_url',
        ''
    ];

}
