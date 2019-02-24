<?php
/**
 * User: zara
 * Date: 2019-02-18
 * Time: 20:56
 */

namespace Fronds\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginVerificationToken extends Model
{

    public const DELETED_AT = 'used_on';

    use SoftDeletes;




}