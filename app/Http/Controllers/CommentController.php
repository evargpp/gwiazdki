<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Restaurant;
use Illuminate\Http\Request;



class CommentController extends Controller
{
    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $restaurant->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back();
    }
}
