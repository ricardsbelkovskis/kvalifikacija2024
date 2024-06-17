<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $companyName = Auth::user()->company_name;
        $items = Item::where('company_name', $companyName)->paginate(10);
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();
        $data['company_name'] = Auth::user()->company_name;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show($id)
    {
        $companyName = Auth::user()->company_name;
        $item = Item::where('id', $id)->where('company_name', $companyName)->firstOrFail();
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $companyName = Auth::user()->company_name;
        $item = Item::where('id', $id)->where('company_name', $companyName)->firstOrFail();
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $companyName = Auth::user()->company_name;
        $item = Item::where('id', $id)->where('company_name', $companyName)->firstOrFail();

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $companyName = Auth::user()->company_name;
        $item = Item::where('id', $id)->where('company_name', $companyName)->firstOrFail();

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}