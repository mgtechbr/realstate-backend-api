<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function index()
    {
        return City::all();
    }

    public function show($id)
    {
        $property = City::findOrFail($id);
        return response()->json($property);
    }

    public function store(Request $request)
    {
		$request->validate([
			'name' => 'required|string|max:255'
		]);
		
		$city = City::create([
			'name' => $request->name,
		]);
		
		if ($request->filled('additional')) {
			$city->amenities()->createMany(array_map(function($amenity) {
				return ['name' => $amenity];
			}, $request->additional));
		}
		
		return response()->json($city, 201);		
    }

    public function update(Request $request, $id)
    {
        $request->validate([
			'name' => 'required|string|max:255'
		]);

        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json($city);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(null, 204);
    }
}
