<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    public function create()
    {
        return view('landlord.post');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rent' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $landlord = Auth::user();

        $apartment = new Apartment();
        $apartment->landlord_id = $landlord->id;
        $apartment->title = $request->title;
        $apartment->location = $request->location;
        $apartment->rent = $request->rent;
        $apartment->description = $request->description;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/apartments', $imageName);
            $apartment->image = $imageName;
        }

        $apartment->save();

        return redirect()->route('landlord.profile')->with('success', 'Apartment added successfully!');
    }
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('landlord.apartments.show', compact('apartment'));
    }

    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('landlord.apartments.edit', compact('apartment'));
    }

    public function update(Request $request, $id)
    {
        $apartment = Apartment::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rent' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $apartment->update($request->only(['title', 'location', 'rent', 'description']));
        if ($request->hasFile('image')) {
            if ($apartment->image && Storage::disk('public')->exists('apartments/' . $apartment->image)) {
                Storage::disk('public')->delete('apartments/' . $apartment->image);
            }
            $path = $request->file('image')->store('apartments', 'public');
            $apartment->image = basename($path);
        }
        $apartment->save();

        return redirect()->back()->with('success', 'Apartment updated successfully!');
    }


    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);

        if ($apartment->image && Storage::exists('public/apartments/' . $apartment->image)) {
            Storage::delete('public/apartments/' . $apartment->image);
        }

        $apartment->delete();

        return redirect()->back()->with('success', 'Apartment deleted successfully!');
    }
}
