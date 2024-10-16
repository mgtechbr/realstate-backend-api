<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
		return Category::all();
	}

	public function show($id)
    {
        $Category = Category::findOrFail($id);
        return response()->json($Category);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $Category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($Category, 201);
    }

    public function update(Request $request, $id)
    {
        // Validar e atualizar propriedade
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $Category = Category::findOrFail($id);
        $Category->update($request->all());

        return response()->json($Category);
    }

    public function destroy($id)
    {
        // Deletar propriedade
        $Category = Category::findOrFail($id);
        $Category->delete();

        return response()->json(null, 204);
    }
}
