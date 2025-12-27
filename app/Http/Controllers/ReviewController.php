<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        // BLOKADA: czy user już ocenił?
        if ($restaurant->reviews()
            ->where('user_id', Auth::id())
            ->exists()
        ) {

            return back()->withErrors(
                'Już wystawiłeś opinię tej restauracji.'
            );
        }

        Review::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurant->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Opinia dodana');
    }

    public function destroy(Restaurant $restaurant, Review $review)
    {
        // Sprawdzenie, czy aktualny użytkownik może usunąć opinię
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('restaurants.show', $restaurant)
            ->with('success', 'Opinia została usunięta.');
    }
}
