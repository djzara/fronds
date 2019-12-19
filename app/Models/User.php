<?php

namespace Fronds\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Fronds\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $fronds_folder_key
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereFrondsFolderKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fronds\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\Form[] $forms
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\FrondsSetting[] $settings
 * @property-read \Fronds\Models\LoginVerificationToken $token
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fronds\Models\FileUpload[] $uploads
 * @property-read int|null $comments_count
 * @property-read int|null $forms_count
 * @property-read int|null $notifications_count
 * @property-read int|null $settings_count
 * @property-read int|null $uploads_count
 */
class User extends Authenticatable
{
    use Notifiable, UuidModelTrait;

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
