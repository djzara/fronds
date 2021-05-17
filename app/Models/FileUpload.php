<?php

declare(strict_types=1);
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 16:50
 */

namespace Fronds\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Fronds\Models\FileUpload
 *
 * @property int $id
 * @property string $original_file_name
 * @property string $file_mime
 * @property string $current_file_name
 * @property string $current_file_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|FileUpload newModelQuery()
 * @method static Builder|FileUpload newQuery()
 * @method static \Illuminate\Database\Query\Builder|FileUpload onlyTrashed()
 * @method static Builder|FileUpload query()
 * @method static bool|null restore()
 * @method static Builder|FileUpload whereCreatedAt($value)
 * @method static Builder|FileUpload whereCurrentFileName($value)
 * @method static Builder|FileUpload whereCurrentFileUrl($value)
 * @method static Builder|FileUpload whereDeletedAt($value)
 * @method static Builder|FileUpload whereFileMime($value)
 * @method static Builder|FileUpload whereId($value)
 * @method static Builder|FileUpload whereOriginalFileName($value)
 * @method static Builder|FileUpload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FileUpload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FileUpload withoutTrashed()
 * @mixin Eloquent
 * @property string|null $uploaded_by
 * @method static Builder|FileUpload whereUploadedBy($value)
 */
class FileUpload extends Model
{

    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'original_file_name',
        'file_mime',
        'current_file_name',
        'current_file_url'
    ];
}
