<?php

namespace App\Http\Controllers;

use App\Http\Helpers\JsonResponseHelper;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function all(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 0);

        $dados = Tag::query()
            ->forPage($page, $perPage)
            ->get();

        return JsonResponseHelper::successWithPagination($dados, Tag::class);
    }

    public function create(Request $request)
    {

        $dados = $request->validate([
            'name' => 'required',
            'description' => 'string',
            'active' => 'boolean',
        ]);
        $tag = Tag::query()->create($dados);
        return response()->json($tag);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $dados = $request->validate([
            'name' => 'required',
            'description' => 'string',
            'active' => 'boolean',
        ]);
        $tag->fill($dados);
        $tag->save();
        return response()->json($tag);
    }

    public function delete($id): JsonResponse
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return response()->json(['message' => 'Tag deleted']);
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json($tag);
    }
}
