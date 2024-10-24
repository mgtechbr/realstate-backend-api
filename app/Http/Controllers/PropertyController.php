<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('images')->get()->map(function ($property) {
            $property->image_url = $property->image ? url("storage/{$property->image}") : null;
            $property->additional_images = $property->images instanceof \Illuminate\Database\Eloquent\Collection
                ? $property->images->map(function ($img) {
                    return url("storage/{$img->image_path}");
                })->toArray()
                : [];

            return $property;
        });

        return response()->json($properties);
    }

    public function show($id)
    {
        $property = Property::with('images')->findOrFail($id);
    
        $property->image_url = $property->image ? url("storage/{$property->image}") : null;
    
        $property->additional_images = $property->images instanceof \Illuminate\Database\Eloquent\Collection
            ? $property->images->map(function ($img) {
                return url("storage/{$img->image_path}");
            })->toArray()
            : [];
    
        return response()->json($property);
    }
    
    public function store(Request $request)
    {
        $this->validateProperty($request);
        $property = Property::create($request->except('image'));

        // Gerando a URL da imagem principal
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/' . $property->id . '/principal', 'public');
            $property->update(['image' => $imagePath]);
            $imageUrl = Storage::url($imagePath);
        }

        // Armazenando e gerando URLs das imagens adicionais
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images/' . $property->id, 'public');
                $property->images()->create(['image_path' => $imagePath]);
            }
        }

        return response()->json([
            "message" => "Property created",
            "image_url" => $imageUrl ?? null,
        ], 201);
    }

    public function update(Request $request, $id)
	{
		$property = Property::with('images')->findOrFail($id);
		$this->validateUpdateProperty($request);

		if ($request->hasFile('image')) {
			if ($property->image) {
				Storage::disk('public')->delete($property->image);
			}
			$imagePath = $request->file('image')->store('images/' . $property->id . '/principal', 'public');
			$property->image = $imagePath;
		}

		if ($request->hasFile('images')) {
			foreach ($property->images as $img) {
				Storage::disk('public')->delete($img->image_path);
				$img->delete();
			}

			foreach ($request->file('images') as $image) {
				$imagePath = $image->store('images/' . $property->id, 'public');
				$property->images()->create(['image_path' => $imagePath]);
			}
		}

		$property->update($request->except('image', 'images'));

		return response()->json([
			'message' => 'Property updated',
			'property' => $property->load('images')
		]);
	}
    

    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }

        foreach ($property->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        $property->delete();

        return response()->json(null, 204);
    }

    public function validateProperty($request)
    {
        $request->validate([
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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }

    public function validateUpdateProperty($request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'location' => 'string|max:255',
            'price' => 'numeric|min:0',
            'description' => 'string',
            'bathroom' => 'integer|min:0',
            'bedroom' => 'integer|min:0',
            'area' => 'numeric|min:0',
            'type' => 'string|in:casa,apartamento,terreno',
            'additional' => 'nullable|array',
            'additional.*' => 'string|max:50',
            'city_id' => 'integer|exists:cities,id',
            'state_id' => 'integer|exists:states,id',
            'district_id' => 'integer|exists:districts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
}
