<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property mixed name
 * @property mixed description
 * @property mixed active
 * @mixin Builder
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'active'];
    protected $appends = ['slug'];

    public function getSlugAttribute()
    {
        return Str::slug($this->name);
    }
}
