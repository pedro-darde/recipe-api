<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function getTags() {
        $tags = Tag::all();

        return response()->json($tags->map(function($tag) {
            return [
                'value' => $tag->id,
                'label' => $tag->description
            ];
        }));
    }
}
