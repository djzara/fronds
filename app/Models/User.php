<?php

namespace Fronds\Models;

use Alsofronie\Uuid\UuidModelTrait;
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
}
