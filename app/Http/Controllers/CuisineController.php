<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;

class CuisineController extends Controller
{
    public function index()
    {
        return view('cuisines.index', [
            'cuisines' => Cuisine::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return view('cuisines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cuisines,name',
        ]);

        Cuisine::create($validated);

        return redirect()
            ->route('cuisines.index')
            ->with('success', 'Rodzaj kuchni dodany');
    }

    public function edit(Cuisine $cuisine)
    {
        return view('cuisines.edit', compact('cuisine'));
    }

    public function update(Request $request, Cuisine $cuisine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cuisines,name,' . $cuisine->id,
        ]);

        $cuisine->update($validated);

        return redirect()
            ->route('cuisines.index')
            ->with('success', 'Rodzaj kuchni zaktualizowany');
    }

    public function destroy(Cuisine $cuisine)
    {
        $cuisine->delete();


        return view('cuisines.create');


        return redirect()
            ->route('cuisines.index')
            ->with('success', 'Rodzaj kuchni usunięty');
    }
}
