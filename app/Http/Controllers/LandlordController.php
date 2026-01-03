<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LandlordController extends Controller
{
    public function createPost()
    {
        return view('landlord.post');
    }
    public function dashboard()
    {
        $landlord = Auth::user();

        $apartments = $landlord->apartments()->with('applications')->get();

        $totalApartments = $apartments->count();
        $rentedApartments = $apartments->filter(fn($a) => $a->applications()->where('status', 'accepted')->exists())->count();
        $availableApartments = $totalApartments - $rentedApartments;
        $totalRent = $apartments->sum(fn($a) => $a->applications()->where('status', 'accepted')->exists() ? $a->rent : 0);

        return view('landlord.dashboard', compact(
            'apartments',
            'totalApartments',
            'rentedApartments',
            'availableApartments',
            'totalRent'
        ));
    }

    public function applications()
    {
        $landlord = Auth::user();

        $apartments = $landlord->apartments()->pluck('id');

        $applications = Application::whereIn('apartment_id', $apartments)
            ->with(['student', 'apartment'])
            ->get();

        return view('landlord.applications', compact('applications'));
    }
    public function updateApplication(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }


    public function profile()
    {
        $landlord = auth()->user();
        $landlord->load('apartments');

        return view('landlord.profile', compact('landlord'));
    }
    public function updateProfile(Request $request)
    {
        $landlord = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'image' => 'nullable|image|max:2048',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
        ]);

        // Update name and phone
        $landlord->name = $request->name;
        $landlord->phone_number = $request->phone_number;
        $landlord->gender = $request->gender;
        $landlord->date_of_birth = $request->date_of_birth;

        // If a new image is uploaded
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image (optional)
            if ($landlord->image && Storage::disk('public')->exists('landlord/' . $landlord->image)) {
                Storage::disk('public')->delete('landlord/' . $landlord->image);
            }

            // Store new image in "storage/app/public/landlord/"
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->store('landlord', $imageName, 'public');
            $landlord->image = $imageName;
        }

        $landlord->save();

        return back()->with('success', 'Profile updated successfully!');
    }
    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'rent' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $landlord = Auth::user();

        $apartment = new Apartment();
        $apartment->landlord_id = $landlord->id;
        $apartment->title = $request->title;
        $apartment->location = $request->location;
        $apartment->latitude = $request->latitude;
        $apartment->longitude = $request->longitude;
        $apartment->rent = $request->rent;
        $apartment->description = $request->description;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($apartment->image && Storage::disk('public')->exists('apartments/' . $apartment->image)) {
                Storage::disk('public')->delete('apartments/' . $apartment->image);
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('apartments', $imageName, 'public');

            $apartment->image = $imageName;
        }


        $apartment->save();

        return redirect()->route('profile')->with('success', 'Apartment added successfully!');
    }
    public function verificationForm()
    {
        $verificationRequest = \App\Models\VerificationRequest::where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('landlord.verify', compact('verificationRequest'));
    }

    public function submitVerification(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'national_id_number' => 'nullable|string|max:255',
        ]);

        $path = $request->file('document')->store('verification_documents', 'public');

        \App\Models\VerificationRequest::create([
            'user_id' => Auth::id(),
            'document_path' => $path,
            'national_id_number' => $request->national_id_number,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Verification request submitted. We will review it shortly.');
    }
}
