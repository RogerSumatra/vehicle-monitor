<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Approval::where('approver_id', auth()->id())->with('booking.vehicle')->get();
        return view('approvals.index', compact('approvals'));
    }

    public function update(Request $request, Approval $approval)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $approval->update(['status' => $request->status]);

        // Update booking status if all approvals are completed
        $pendingApprovals = $approval->booking->approvals->where('status', 'pending');
        if ($pendingApprovals->isEmpty()) {
            $approval->booking->update(['status' => $approval->status]);
        }

        return redirect()->route('approvals.index')->with('success', 'Approval updated successfully!');
    }
}
