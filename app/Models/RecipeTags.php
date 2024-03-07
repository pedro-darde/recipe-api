<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @mixin Builder
 * @method  static insert(array $values)
 */
class RecipeTags extends Model
{
    use HasFactory;
    protected $table = 'recipe_tags';
    protected $guarded = ['id'];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
