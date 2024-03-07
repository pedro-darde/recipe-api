<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\RecipeImages;
use App\Models\RecipeTags;
use App\Models\Tag;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateRecipeService
{
    static function create(array $data)
    {
        try {
            DB::beginTransaction();

            /** @var Recipe $recipe */
            $recipe = Recipe::query()->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'difficulty' => $data['difficulty'],
                'ingredients' => $data['ingredients'],
                'steps'      => $data['steps']
            ]);

            if (!empty(@$data['images'])) {
                self::storeImages($data['images'], $recipe->id);
            }

            if (!empty($data['tags'])) {
                $tagsInsertData = array_map(function ($tagId) use ($recipe) {
                    return [
                        'tag_id' => $tagId,
                        'recipe_id' => $recipe->id
                    ];
                }, $data['tags']);

                RecipeTags::insert($tagsInsertData);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }


    private static function storeImages(array $images, $recipeId): void
    {
        /** @var UploadedFile $file */
        foreach ($images as $file) {
            $pathFile = RecipeImages::DIR_PATH . "/{$recipeId}";
            $file->storeAs($pathFile, $file->getClientOriginalName(), 'local');
            RecipeImages::create([
                'name' => $file->getClientOriginalName(),
                'path' => "{$pathFile}/{$file->getClientOriginalName()}",
                'recipe_id' => $recipeId,
            ]);
        }
    }
}