<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        return District::all();
    }

    public function show($id)
    {
        $district = District::findOrFail($id);
        return response()->json($district);
    }

    public function store(Request $request)
    {
		$request->validate([
			'name' => 'required|string|max:255'
		]);
		
		$district = District::create([
			'name' => $request->name,
		]);
		
		if ($request->filled('additional')) {
			$district->amenities()->createMany(array_map(function($amenity) {
				return ['name' => $amenity];
			}, $request->additional));
		}
		
		return response()->json($district, 201);		
    }

    public function update(Request $request, $id)
    {
        $request->validate([
			'name' => 'required|string|max:255'
		]);

        $district = District::findOrFail($id);
        $district->update($request->all());

        return response()->json($district);
    }

    public function destroy($id)
    {
        $district = District::findOrFail($id);
        $district->delete();

        return response()->json(null, 204);
    }
}
