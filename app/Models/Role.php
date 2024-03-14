<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property string $name
 * @property string $description
 * @property boolean $active
 */
class Role extends Model
{
    const ADMIN = 'admin';
    const USER = 'user';

    protected $table = 'roles';
    protected $guarded = ['id'];

    protected $appends = ['is_admin'];
    public function getIsAdminAttribute()
    {
       return $this->name === self::ADMIN;
    }
}