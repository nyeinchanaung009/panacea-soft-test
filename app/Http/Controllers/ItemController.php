<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'condition' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'owner' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
        ]);

        try{
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('items', 'public');
            }

            Item::create([
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
            return redirect()->route('dashboard')->with('message',['type' => 'success','text' => 'Item successfully created.']);
        }catch(Exception $e){
            return back()->with('message',['type' => 'error','text' => 'Item create unsuccessful.']);
        }
    }

    public function edit(Item $item){
        $categories = Category::all();
        return Inertia::render('Edit',[
            'item' => $item,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request,Item $item){
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'condition' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'owner' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
        ]);

        try{

            $item->name = request('name');
            $item->category_id = request('category_id');
            $item->price = request('price');
            $item->description = request('description');
            $item->condition = request('condition');
            $item->type = request('type');
            $item->owner = request('owner');
            $item->phone = request('phone');
            $item->address = request('address');

            if ($request->hasFile('image')) {
                if ($item->image){
                    $filePath = storage_path('app/public/' . $item->image);
                    unlink($filePath);
                }
                $item->image = $request->file('image')->store('items', 'public');
            }

            $item->save();

            return redirect()->route('dashboard')->with('message',['type' => 'success','text' => 'Item successfully updated.']);
        }catch(Exception $e){
            return back()->with('message',['type' => 'error','text' => 'Item update unsuccessful.']);
        }
    }

    public function makePublish($id){
    
        $item = Item::findOrFail($id);
        $item->is_publish = !$item->is_publish;
        $item->save();
    
        return back()->with('message',['type' => 'success','text' => 'Publish successful.']);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Item published successfully!',
        // ]);
    }

    public function destroy($id){
        $item = Item::findOrFail($id);
        $item->delete();
        if ($item->image) {
            $filePath = storage_path('app/public/' . $item->image);
            unlink($filePath);
        }
        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully.'
        ]);
    }
}
