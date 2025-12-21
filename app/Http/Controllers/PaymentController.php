<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Show payment page (demo PayPal redirect)
    public function initiate(Application $application)
    {
        // Verify student owns this application and it's accepted
        if ($application->std_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        if ($application->status !== 'accepted') {
            return redirect()->back()->with('error', 'Application must be accepted before payment.');
        }

        if ($application->isPaid()) {
            return redirect()->back()->with('error', 'Already paid for this application.');
        }

        // Set payment amount to apartment rent
        $amount = $application->apartment->rent;

        return view('student.payment.initiate', compact('application', 'amount'));
    }

    // Execute payment (demo - simulates PayPal success)
    public function execute(Application $application)
    {
        if ($application->isPaid()) {
            return redirect()->route('student.applications')->with('error', 'Already paid.');
        }

        // Simulate PayPal payment
        $mockPaymentId = 'DEMO-' . strtoupper(uniqid());

        // Update application with payment info
        $application->update([
            'payment_status' => 'paid',
            'payment_id' => $mockPaymentId,
            'payment_amount' => $application->apartment->rent,
            'paid_at' => now(),
            'cancellation_deadline' => now()->addDays(7),
        ]);

        return redirect()->route('student.payment.success', $application->id);
    }

    // Success page
    public function success($applicationId)
    {
        $application = Application::with('apartment')->findOrFail($applicationId);

        if ($application->std_id !== Auth::id()) {
            return redirect()->route('student.applications')->with('error', 'Unauthorized access.');
        }

        return view('student.payment.success', compact('application'));
    }

    // Cancel payment (refund within 7 days)
    public function cancel(Application $application)
    {
        if ($application->std_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        if (!$application->canCancel()) {
            return redirect()->back()->with('error', 'Cannot cancel. Either not paid or cancellation period expired.');
        }

        // Simulate refund
        $application->update([
            'payment_status' => 'refunded',
        ]);

        return redirect()->route('student.applications')->with('success', 'Payment cancelled and refunded successfully!');
    }
}
