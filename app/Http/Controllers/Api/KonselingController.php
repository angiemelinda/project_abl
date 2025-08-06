<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KonselingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $konselings = Konseling::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua permintaan konseling.',
            'data' => $konselings
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'topik_konseling' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $konseling = Konseling::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Permintaan konseling berhasil dibuat.',
            'data' => $konseling
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $konseling = Konseling::find($id);

        if (!$konseling) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail permintaan konseling.',
            'data' => $konseling
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $konseling = Konseling::find($id);

        if (!$konseling) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'string|max:255',
            'email' => 'email|max:255',
            'nomor_telepon' => 'string|max:15',
            'topik_konseling' => 'string|max:255',
            'deskripsi' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $konseling->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Permintaan konseling berhasil diperbarui.',
            'data' => $konseling
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $konseling = Konseling::find($id);

        if (!$konseling) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $konseling->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan konseling berhasil dihapus.'
        ], 200);
    }
}
