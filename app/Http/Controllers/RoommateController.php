<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Roommate;
use App\Models\RoommatePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoommateController extends Controller
{
    // SHOW ALL ROOMMATE POSTS
    public function index(Request $request)
    {
        $query = RoommatePost::with(['student', 'apartment', 'roommates'])
            ->where('is_open', true);

        // Filters for Apartment Location and Price
        if ($request->filled('location')) {
            $query->whereHas('apartment', function ($q) use ($request) {
                $q->where('location', 'like', '%' . $request->location . '%');
            });
        }
        if ($request->filled('min_price')) {
            $query->whereHas('apartment', function ($q) use ($request) {
                $q->where('rent', '>=', $request->min_price);
            });
        }
        if ($request->filled('max_price')) {
            $query->whereHas('apartment', function ($q) use ($request) {
                $q->where('rent', '<=', $request->max_price);
            });
        }

        // New Filters: Gender and Date of Birth
        if ($request->filled('gender')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        if ($request->filled('dob')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->whereDate('date_of_birth', $request->dob);
            });
        }

        $posts = $query->latest()
            ->get()
            ->filter(function ($post) {
                return $post->acceptedCount() < $post->max_roommates;
            });

        return view('student.roommates.index', compact('posts'));
    }


    // SHOW CREATE FORM
    public function create()
    {
        $student = Auth::user();

        $accepted = $student->applications()
            ->where('status', 'accepted')
            ->first();

        if (!$accepted) {
            return back()->with('error', 'You must be accepted in an apartment to create a roommate post.');
        }

        return view('student.roommates.create', compact('accepted'));
    }

    // STORE NEW POST
    public function store(Request $request)
    {
        $student = Auth::user();

        $accepted = $student->applications()->where('status', 'accepted')->first();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'max_roommates' => 'required|integer|min:1|max:10',
            'preferences' => 'nullable|array',
            'preferences.*.name' => 'nullable|string|max:255',
            'preferences.*.description' => 'nullable|string|max:255',
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'max_roommates' => 'required|integer|min:1|max:10',
            'preferences' => 'nullable|array',
            'preferences.*.name' => 'nullable|string|max:255',
            'preferences.*.description' => 'nullable|string|max:255',
        ]);

        $post = RoommatePost::create([
            'std_id' => $student->id,
            'apartment_id' => $accepted->apartment_id,
            'title' => $request->title,
            'description' => $request->description,
            'max_roommates' => $request->max_roommates,
        ]);

        if ($request->has('preferences')) {
            foreach ($request->preferences as $pref) {
                if (!empty($pref['name'])) {
                    $post->preferences()->create([
                        'name' => $pref['name'],
                        'description' => $pref['description'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('student.roommates.index')->with('success', 'Roommate post created.');
    }

    // APPLY TO JOIN ROOMMATE POST
    public function apply(RoommatePost $post)
    {
        $student = Auth::id();

        // Prevent the post creator from applying
        if ($post->std_id == $student) {
            return back()->with('error', 'You cannot apply to your own roommate post.');
        }

        // Prevent applying twice
        if (Roommate::where('std_id', $student)->where('post_id', $post->id)->exists()) {
            return back()->with('error', 'You already applied.');
        }

        // Create the application
        Roommate::create([
            'std_id' => $student,
            'post_id' => $post->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Application sent!');
    }


    // MANAGE APPLICATIONS (FOR OWNER)
    public function manage()
    {
        $post = RoommatePost::where('std_id', Auth::id())->first();

        if (!$post) {
            return back()->with('error', 'You have no roommate post.');
        }

        $requests = Roommate::with('student')->where('post_id', $post->id)->get();

        return view('student.roommates.manage', compact('post', 'requests'));
    }

    // UPDATE APPLICATION STATUS
    public function updateStatus(Request $request, Roommate $roommate)
    {
        // Only proceed if the status is being changed to 'accepted'
        if ($request->status === 'accepted') {
            $post = $roommate->post; // Assuming you have a relation: Roommate belongsTo RoommatePost

            // Count how many already accepted
            $acceptedCount = $post->roommates()->where('status', 'accepted')->count();

            if ($acceptedCount >= $post->max_roommates) {
                return back()->with('error', 'Cannot accept more applicants. Max roommates reached.');
            }
        }

        // Update the status
        $roommate->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }

    public function myPosts()
    {
        $posts = RoommatePost::where('std_id', Auth::id())->latest()->get();
        return view('student.roommates.my_posts', compact('posts'));
    }
    public function updatePost(Request $request, RoommatePost $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'max_roommates' => 'required|integer|min:1|max:10',
            'preferences' => 'nullable|array',
            'preferences.*.name' => 'nullable|string|max:255',
            'preferences.*.description' => 'nullable|string|max:255',
        ]);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'max_roommates' => $request->max_roommates,
        ]);

        // Sync preferences: delete old and create new
        $post->preferences()->delete();

        if ($request->has('preferences')) {
            foreach ($request->preferences as $pref) {
                if (!empty($pref['name'])) {
                    $post->preferences()->create([
                        'name' => $pref['name'],
                        'description' => $pref['description'] ?? null,
                    ]);
                }
            }
        }

        return back()->with('success', 'Post updated successfully.');
    }
    public function myApplications()
    {
        $applications = Roommate::where('std_id', Auth::id())->latest()->get();
        return view('student.roommates.my_applications', compact('applications'));
    }
}
