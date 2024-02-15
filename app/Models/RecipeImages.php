<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeImages extends Model
{
    use HasFactory;
    protected $table = 'recipe_images';
    const DIR_PATH = 'public/uploads/recipe_images';

    protected $appends = [
        'name',
        'full_name',
        'normalized_file_path',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    public function getNormalizedFilePathAttribute(): string
    {
        return "storage/uploads/notes_files/{$this->recipe->id}/{$this->name}";
    }

    public function getFullNameAttribute(): string {
        return asset($this->normalized_file_path);
    }
}
