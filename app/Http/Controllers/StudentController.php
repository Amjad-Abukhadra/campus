<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Application;
use App\Models\Roommate;
use App\Models\RoommatePost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function profile()
    {
        $student = Auth::user();
        return view('student.profile', compact('student'));
    }
    public function updateProfile(Request $request)
    {
        $student = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($student->image && Storage::disk('public')->exists('students/' . $student->image)) {
                Storage::disk('public')->delete('students/' . $student->image);
            }
            $path = $request->file('image')->store('students', 'public');
            $student->image = basename($path);
        }
        $student->name = $request->name;
        $student->phone_number = $request->phone_number;
        $student->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    public function apartments()
    {
        $student = Auth::user();

        $acceptedApartmentIds = $student->applications()
            ->where('status', 'accepted')
            ->pluck('apartment_id')
            ->toArray();

        $apartments = Apartment::with('landlord')
            ->whereNotIn('id', $acceptedApartmentIds)
            ->get();

        $applicationsStatus = $student->applications()
            ->whereIn('status', ['pending', 'rejected'])
            ->pluck('status', 'apartment_id')
            ->toArray();

        return view('student.apartments', [
            'apartments' => $apartments,
            'applications' => $applicationsStatus,
        ]);
    }



    public function applyApartment(Apartment $apartment)
    {
        $student = Auth::user();
        if ($student->applications()->where('apartment_id', $apartment->id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied for this apartment.');
        }
        Application::create([
            'std_id' => $student->id,
            'apartment_id' => $apartment->id,
            'status' => 'pending',
        ]);
        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
    public function applications()
    {
        $applications = Application::with('apartment')
            ->where('std_id', Auth::id())
            ->get();

        return view('student.applications', compact('applications'));
    }
    public function viewLandlord($id)
    {
        $landlord = User::findOrFail($id);

        // apartments by this landlord
        $apartments = Apartment::where('landlord_id', $id)->get();

        return view('student.landlord-profile', compact('landlord', 'apartments'));
    }

    
}
