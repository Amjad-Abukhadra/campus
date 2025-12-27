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
    // 1️⃣ Validate request
    $request->validate([
        'title' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'rent' => 'required|numeric',
        'description' => 'required|string',
        'image' => 'required|image|max:2048', // image MUST be uploaded
    ]);

    // 2️⃣ Get authenticated landlord
    $landlord = Auth::user();

    // 3️⃣ Create apartment
    $apartment = new Apartment();
    $apartment->landlord_id = $landlord->id;
    $apartment->title = $request->title;
    $apartment->location = $request->location;
    $apartment->rent = $request->rent;
    $apartment->description = $request->description;

    // 4️⃣ Store image (safe & guaranteed)
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

        // store in storage/app/public/apartments
        $request->file('image')->storeAs('apartments', $imageName, 'public');

        // save filename in DB
        $apartment->image = $imageName;
    }

    // 5️⃣ Save apartment
    $apartment->save();

    // 6️⃣ Redirect
    return redirect()
        ->route('landlord.profile')
        ->with('success', 'Apartment added successfully!');
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
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($apartment->image && Storage::disk('public')->exists('apartments/' . $apartment->image)) {
                Storage::disk('public')->delete('apartments/' . $apartment->image);
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('apartments', $imageName, 'public');
            $apartment->image = $imageName;
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
