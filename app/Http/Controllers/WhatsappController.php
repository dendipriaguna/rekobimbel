<?php

namespace App\Http\Controllers;

use App\Services\FonnteService;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function __construct(protected FonnteService $fonnte)
    {
    }

    public function index()
    {
        return view('whatsapp.send');
    }

    public function send(Request $request)
    {
        $request->validate([
            'target' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        $result = $this->fonnte->send(
            $request->target,
            $request->message
        );

        if ($result['status'] ?? false) {
            return back()->with('success', 'Pesan berhasil terkirim!');
        }

        return back()->with('error', 'Gagal kirim: ' . ($result['reason'] ?? 'Unknown error'));
    }
}