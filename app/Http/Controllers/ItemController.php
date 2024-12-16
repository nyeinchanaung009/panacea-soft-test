<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index(){
        if(request('row')){
            $row = request('row');
        }else{
            $row = 10;
        }

        $items = Item::with('category')->latest()->paginate((int) $row)->withQueryString();
        return Inertia::render('Dashboard',[
            'items' => $items,
            'row' => $row
        ]);
    }

    public function create(){
        $categories = Category::all();

        return Inertia::render('Create',[
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'condition' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'owner' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        try{
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('items', 'public');
            }

            $item = Item::create([
                'name' => request('name'),
                'description' => request('description'),
                'address' => request('address') ?? null,
                'owner' => request('owner'),
                'phone' => request('phone') ?? null,
                'type' => request('type'),
                'condition' =>  request('condition'),
                'image' => $imagePath,
                'price' => request('price'),
                'category_id' => request('category_id'),
                'is_publish' => request('is_publish') ?? false,
            ]);
            return redirect()->route('dashboard')->with('success', 'Item successfully created.');
        }catch(Exception $e){
            return back();
        }
        


        // return redirect('/');
    }

    public function makePublish(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer|exists:items,id',
        ]);
    
        $item = Item::findOrFail($validated['id']);
        $item->is_publish = !$item->is_publish;
        $item->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Item published successfully!',
        ]);
    }

    public function destroy(Item $item){
        $item->delete();
        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully.'
        ]);
    }
}
