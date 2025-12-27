<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Cuisine;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = ['name', 'city', 'created_at'];

        $sort = in_array($request->get('sort'), $allowedSorts)
            ? $request->get('sort')
            : 'created_at';

        $direction = $request->get('direction') === 'desc'
            ? 'desc'
            : 'asc';

        $allCuisines = Cuisine::orderBy('name')->get();

        $restaurants = Restaurant::with('cuisines', 'reviews')
            ->when($request->cuisines, function ($query, $cuisines) {
                $query->whereHas('cuisines', function ($q) use ($cuisines) {
                    $q->whereIn('cuisines.id', $cuisines);
                });
            })
            ->when($request->rating_from || $request->rating_to, function ($query) use ($request) {
                $query->withAvg('reviews', 'rating')
                    ->having('reviews_avg_rating', '>=', $request->rating_from ?? 1)
                    ->having('reviews_avg_rating', '<=', $request->rating_to ?? 5);
            })
            ->orderBy($sort, $direction)->paginate(10);

        return view('restaurants.index', compact('restaurants', 'allCuisines', 'sort', 'direction'));
    }

    public function userIndex(Request $request)
    {
        $restaurants = auth()->user()
            ->restaurants()
            ->with('cuisines')
            ->latest()
            ->get();
        return view('restaurants.indexUser', compact('restaurants'));
    }


    public function show(Restaurant $restaurant)
    {
        $restaurant->load('reviews.user');

        $userReview = null;
        if (auth()->check()) {
            $userReview = $restaurant->reviews()
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('restaurants.show', compact('restaurant', 'userReview'));
    }

    public function create()
    {
        $cuisines = Cuisine::all();

        return view('restaurants.create', compact('cuisines'));
    }

    public function store(StoreRestaurantRequest $request)
    {
        // $data = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'address' => 'required|string|max:255',
        //     'latitude' => 'nullable|numeric',
        //     'longitude' => 'nullable|numeric',
        //     'image' => 'nullable|image',
        //     'cuisines' => 'array',
        // ]);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('restaurants', 'public');
        }

        $data['user_id'] = auth()->id();
        $restaurant = auth()->user()->restaurants()->create($data);
        $restaurant->cuisines()->sync($request->cuisines ?? []);

        return redirect()->route('restaurants.userIndex');
    }

    public function edit(Restaurant $restaurant)
    {
        $cuisines = Cuisine::all();

        return view('restaurants.edit', compact('restaurant', 'cuisines'));
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('restaurants', 'public');
        }

        $restaurant->update($data);
        $restaurant->cuisines()->sync($request->cuisines ?? []);

        return redirect()->route('restaurants.userIndex');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('restaurants.userIndex');
    }

    public function report()
    {
        $restaurants = Restaurant::with('reviews')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->get();

        return view('restaurants.report', compact('restaurants'));
    }
}
