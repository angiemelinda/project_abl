<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index()
    {
        return response()->json(Konseling::all());
    }

    public function show($id)
    {
        $konseling = Konseling::findOrFail($id);
        return response()->json($konseling);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'konselor_id' => 'required|exists:users,id',
            'jadwal' => 'required|date',
            'topik' => 'required|string',
            'status' => 'required|string',
        ]);

        $konseling = Konseling::create($validated);

        return response()->json($konseling, 201);
    }
}
