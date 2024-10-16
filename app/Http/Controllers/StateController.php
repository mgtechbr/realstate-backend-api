<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
	public function index()
    {
        return State::all();
    }

    public function show($id)
    {
        $states = State::findOrFail($id);
        return response()->json($states);
    }

    public function store(Request $request)
    {
		$request->validate([
			'name' => 'required|string|max:255'
		]);
		
		$states = State::create([
			'name' => $request->name,
		]);
		
		if ($request->filled('additional')) {
			$states->amenities()->createMany(array_map(function($amenity) {
				return ['name' => $amenity];
			}, $request->additional));
		}
		
		return response()->json($states, 201);		
    }

    public function update(Request $request, $id)
    {
        $request->validate([
			'name' => 'required|string|max:255'
		]);

        $states = State::findOrFail($id);
        $states->update($request->all());

        return response()->json($states);
    }

    public function destroy($id)
    {
        $states = State::findOrFail($id);
        $states->delete();

        return response()->json(null, 204);
    }
}
