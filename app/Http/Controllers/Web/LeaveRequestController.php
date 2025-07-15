<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveRequestController extends Controller
{
    public function index(): View
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Kita pakai paginate biar rapi
            
        return view('leaves.index', compact('leaveRequests'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
}