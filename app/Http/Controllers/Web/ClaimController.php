<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClaimController extends Controller
{
    public function index(): View
    {
        $claims = Claim::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('claims.index', compact('claims'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // max 2MB
        ]);

        $claim = Claim::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        // Proses upload file
        if ($request->hasFile('attachment')) {
            $claim->addMediaFromRequest('attachment')->toMediaCollection('attachments');
        }

        return redirect()->route('claims.index')->with('success', 'Pengajuan klaim berhasil dikirim.');
    }
}