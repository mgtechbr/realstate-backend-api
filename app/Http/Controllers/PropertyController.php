<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
	{
		$properties = Property::with('images')->get()->map(function($property) {
			$property->image_url = $property->image ? Storage::url($property->image) : null;
			$property->additional_images = $property->images->map(function($img) {
				return Storage::url($img->image_path);
			});
			return $property;
		});

		return response()->json($properties);
	}

    public function show($id)
	{
		$property = Property::with('images')->findOrFail($id);
		$imageUrl = $property->image ? Storage::url($property->image) : null;
		$additionalImages = $property->images->map(function($img) {
			return Storage::url($img->image_path);
		});

		return response()->json([
			'property' => $property,
			'image_url' => $imageUrl,
			'additional_images' => $additionalImages,
		]);
	}

    public function store(Request $request)
	{
		$this->validateProperty($request);

		$property = Property::create($request->except('image'));

		$imageUrl = null;

		if ($request->hasFile('image')) {
			$imagePath = $request->file('image')->store('images', 'public');
			$property->update(['image' => $imagePath]);
			$imageUrl = Storage::url($imagePath);
		}

		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $image) {
				$imagePath = $image->store('images/' . $property->id, 'public');
				$property->images()->create(['image_path' => $imagePath]);
			}
		}

		return response()->json([
			'property' => $property,
			'image_url' => $imageUrl,
		], 201);
	}

	public function update(Request $request, $id)
	{
		$property = Property::findOrFail($id);
		$this->validateProperty($request);

		$imageUrl = null;

		if ($request->hasFile('image')) {
			if ($property->image) {
				Storage::disk('public')->delete($property->image);
			}
			$imagePath = $request->file('image')->store('images', 'public');
			$property->update(['image' => $imagePath]);
		}

		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $image) {
				$imagePath = $image->store('images/' . $property->id, 'public');
				$property->images()->create(['image_path' => $imagePath]);
			}
		}

		$property->update($request->except('image', 'images'));

		return response()->json([
			'message' => 'Property updated',
			'property' => $property,
			'image_url' => $imageUrl,
		]);
	}

	public function destroy($id)
	{
		$property = Property::findOrFail($id);

		if ($property->image) {
			Storage::disk('public')->delete($property->image);
		}

		// Delete additional images
		foreach ($property->images as $img) {
			Storage::disk('public')->delete($img->image_path);
		}

		$property->delete();

		return response()->json(null, 204);
	}


	public function validateProperty($property){
		$property->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'bathroom' => 'required|integer|min:0',
            'bedroom' => 'required|integer|min:0',
            'area' => 'required|numeric|min:0',
            'type' => 'required|string|in:casa,apartamento,terreno',
            'additional' => 'nullable|array',
            'additional.*' => 'string|max:50',
            'city_id' => 'required|integer|exists:cities,id',
            'state_id' => 'required|integer|exists:states,id',
            'district_id' => 'required|integer|exists:districts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
	}
}