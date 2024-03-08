<?php

namespace App\Models;

use App\Enums\RecipeDifficulty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Recipe extends Model
{
    use HasFactory;
    protected $table = 'recipes';
    protected $guarded = ['id'];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
        'difficulty' => RecipeDifficulty::class,
    ];

    public function tags(): HasManyThrough {
        return $this->hasManyThrough(
            Tag::class,
            RecipeTags::class,
            'recipe_id',
            'id',
            'id',
            'tag_id'
        );
    }

    public function images() : HasMany
    {
        return $this->hasMany(RecipeImages::class);
    }
}

