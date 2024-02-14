<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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

        return response()->json([
            'rows' => $dados,
            'page' => $page,
            'per_page' => $perPage,
            'total' => Tag::count(),
        ]);
    }

    public function create(Request $request)
    {

        $dados = $request->validate([
            'name' => 'required',
            'description' => 'string',
            'active' => 'boolean',
        ]);
        $tag = Tag::create($dados);
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

    public function delete($id)
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
