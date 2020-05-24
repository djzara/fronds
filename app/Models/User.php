<?php

namespace Fronds\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Fronds\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $fronds_folder_key
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFrondsFolderKey($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Comment[] $comments
 * @property-read Collection|Form[] $forms
 * @property-read Collection|FrondsSetting[] $settings
 * @property-read LoginVerificationToken $token
 * @property-read Collection|FileUpload[] $uploads
 * @property-read int|null $comments_count
 * @property-read int|null $forms_count
 * @property-read int|null $notifications_count
 * @property-read int|null $settings_count
 * @property-read int|null $uploads_count
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fronds\Models\User withoutTrashed()
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use UuidModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'fronds_folder_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * @return HasMany
     */
    public function forms() : HasMany
    {
        return $this->hasMany(Form::class, 'created_by');
    }

    /**
     * @return HasMany
     */
    public function settings() : HasMany
    {
        return $this->hasMany(FrondsSetting::class, 'owner');
    }

    /**
     * @return HasOne
     */
    public function token() : HasOne
    {
        return $this->hasOne(LoginVerificationToken::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'internal_owner');
    }

    /**
     * @return HasMany
     */
    public function uploads() : HasMany
    {
        return $this->hasMany(FileUpload::class, 'uploaded_by');
    }
}
