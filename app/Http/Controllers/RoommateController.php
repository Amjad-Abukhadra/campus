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
    public function index()
    {
        $posts = RoommatePost::with(['student', 'apartment', 'roommates'])
            ->where('is_open', true)
            ->latest()
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

        RoommatePost::create([
            'std_id' => $student->id,
            'apartment_id' => $accepted->apartment_id,
            'title' => $request->title,
            'description' => $request->description,
            'cleanliness_level' => $request->cleanliness,
            'smoking' => $request->smoking ?? 0,
            'max_roommates' => $request->max_roommates ?? 1,
        ]);

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
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'cleanliness_level' => $request->cleanliness,
            'smoking' => $request->smoking ?? 0,
            'max_roommates' => $request->max_roommates,
        ]);

        return back()->with('success', 'Post updated successfully.');
    }
    public function myApplications() {
        $applications = Roommate::where('std_id',Auth::id())->latest()->get();
        return view('student.roommates.my_applications', compact('applications'));
    }
}
