<?php

namespace App\Http\Controllers;

use App\Http\Helpers\JsonResponseHelper;
use App\Models\Recipe;
use App\Services\CreateRecipeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    public function all(Request $request): JsonResponse {

        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 0);

        $data = Recipe::query()
            ->with(['images','tags'])
            ->forPage($page, $perPage)
            ->get();

        return JsonResponseHelper::successWithPagination($data, Recipe::class);
    }

    public function create(Request $request): JsonResponse
    {
        try {

            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'tags' => 'array|min:1',
                'ingredients' => 'array|min:1',
                'steps' => 'array|min:1',
                'time' => 'integer|gt:0',
                'difficulty' => 'required|in:"easy", "medium", "hard", "professional"',
                'images' => 'array',
            ]);

            CreateRecipeService::create($validated);

            return JsonResponseHelper::modelSaved('Recipe');

        } catch (\Exception $ex) {
           return JsonResponseHelper::serverError($ex);
        }
    }


    public function update(Request $request, $id) {
        $recipe = Recipe::find($id);
        $recipe->fill($request->all());
        $recipe->save();
        return $recipe;
    }


    public function delete($id) {
        $recipe = Recipe::find($id);
        $recipe->delete();
        return $recipe;
    }

    public function show(int $id) {
        return Recipe::find($id);
    }
}
