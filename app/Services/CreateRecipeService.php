<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\RecipeImages;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateRecipeService
{
    static function create(array $data)
    {
        try {
            DB::beginTransaction();
            $recipe = Recipe::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'difficulty' => $data['difficulty'],
                'ingredients' => $data['ingredients'],
            ]);

            if (!empty(@$data['images '])) {
                self::storeImages($data['images'], $recipe->id);
            }

            if (!empty($data['tags'])) {
                  $recipe->tags()->createMany($data['tags']);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }


    }


    private static function storeImages(array $images, $recipeId): void
    {
        /** @var UploadedFile $image */
        foreach ($images as $file) {
            $pathFile = RecipeImages::DIR_PATH . "/{$recipeId}";
            $file->storeAs($pathFile, $file->getClientOriginalName(), 'local');
            RecipeImages::create([
                'name' => $file->getClientOriginalName(),
                'path' => "{$pathFile}/{$file->getClientOriginalName()}",
                'note_id' => $recipeId,
            ]);
        }
    }

    private static function createTags(array $tags, int $recipeId) {
        $tags = array_map(function($tag) use ($recipeId) {
            return [
                'tag_id' => $tag,
                'recipe_id' => $recipeId
            ];
        }, $tags);

        DB::table('tags')->insert($tags);
    }
}