<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{


    public function all() {
        return Recipe::all();
    }

    public function create(Request $request) {
        $recipe = new Recipe();
        $recipe->fill($request->all());
        $recipe->save();
        return $recipe;
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
