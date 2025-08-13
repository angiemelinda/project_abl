<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class KonselingController extends Controller
{
    public function index()
    {
        // Untuk API
        return response()->json(Konseling::with(['user', 'konselor'])->get());
    }
    
    public function list()
    {
        // Untuk Web
        $query = DB::table('konseling')
            ->leftJoin('users as pengaju', 'konseling.user_id', '=', 'pengaju.id')
            ->leftJoin('users as konselor', 'konseling.konselor_id', '=', 'konselor.id')
            ->select(
                'konseling.id',
                'pengaju.name as nama_pengaju',
                'konselor.name as nama_konselor',
                'konseling.nama_lengkap',
                'konseling.jadwal',
                'konseling.topik',
                'konseling.status',
                'konseling.user_id'
            );
            
        // Filter berdasarkan user yang login
        if (Auth::check()) {
            $user = Auth::user();
            
            // Jika user adalah admin atau konselor, tampilkan semua data
            if ($user->role_id == 1) {
                // Admin dapat melihat semua data
            } elseif ($user->role_id == 2) {
                // Konselor hanya dapat melihat data yang ditanganinya
                $query->where('konseling.konselor_id', $user->id);
            } else {
                // User biasa hanya dapat melihat data miliknya sendiri
                $query->where('konseling.user_id', $user->id);
            }
        }
        
        $konselings = $query->orderBy('konseling.jadwal', 'asc')->get();
            
        return view('konseling_list', compact('konselings'));
    }

    public function show($id)
    {
        $konseling = Konseling::with(['user', 'konselor'])->findOrFail($id);
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Hanya admin, konselor yang menangani, atau pemilik konseling yang bisa melihat detail
        if ($user->role_id != 1 && $user->id != $konseling->konselor_id && $user->id != $konseling->user_id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        
        return response()->json($konseling);
    }

    public function store(Request $request)
    {
        // Untuk API
        if ($request->wantsJson()) {
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

        // Untuk Web Form
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);
        
        // Log data yang diterima
        \Log::info('Data konseling yang diterima:', $validated);

        // Cari konselor secara acak
        $konselor = User::where('role_id', 2)->inRandomOrder()->first();
        \Log::info('Konselor yang dipilih:', ['konselor_id' => $konselor ? $konselor->id : null]);
        
        if (!$konselor) {
            return redirect()->back()->with('error', 'Tidak ada konselor yang tersedia saat ini.');
        }

        try {
            // Cari user berdasarkan email jika sudah terdaftar
            $user = User::where('email', $validated['email'])->first();
            
            // Jika tidak ada user, buat user baru
            if (!$user) {
                Log::warning('User dengan email ' . $validated['email'] . ' tidak ditemukan, membuat user baru');

                // Cari role 'user' dari database
                $userRole = \App\Models\Role::where('name', 'user')->first();
                
                if (!$userRole) {
                    // Jika role 'user' tidak ditemukan, jalankan seeder
                    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\RoleSeeder']);
                    $userRole = \App\Models\Role::where('name', 'user')->first();
                    
                    if (!$userRole) {
                        Log::error('Tidak dapat menemukan role user setelah menjalankan seeder');
                        return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan hubungi administrator.');
                    }
                }
                
                // Buat user baru
                $user = User::create([
                    'name' => $validated['nama_lengkap'],
                    'email' => $validated['email'],
                    'password' => Hash::make('password123'), // Password default
                    'role_id' => $userRole->id,
                ]);
                
                Log::info('User baru dibuat', ['id' => $user->id, 'email' => $user->email]);
            }
            
            $userId = $user->id;
            
            // Pastikan konselor tersedia
            if (!$konselor) {
                Log::warning('Tidak ada konselor tersedia, mencoba membuat konselor default');
                
                // Cari role 'konselor' dari database
                $konselorRole = \App\Models\Role::where('name', 'konselor')->first();
                
                if ($konselorRole) {
                    // Cek apakah ada user dengan role konselor
                    $existingKonselor = User::where('role_id', $konselorRole->id)->first();
                    
                    if (!$existingKonselor) {
                        // Buat konselor default
                        $existingKonselor = User::create([
                            'name' => 'Konselor Default',
                            'email' => 'konselor@example.com',
                            'password' => Hash::make('password123'),
                            'role_id' => $konselorRole->id,
                        ]);
                        
                        Log::info('Konselor default dibuat', ['id' => $existingKonselor->id]);
                    }
                    
                    $konselorId = $existingKonselor->id;
                } else {
                    Log::error('Role konselor tidak ditemukan');
                    $konselorId = $userId; // Fallback ke user ID yang sama jika tidak ada role konselor
                }
            } else {
                $konselorId = $konselor->id;
            }
            
            // Buat entri konseling baru menggunakan create
            $konselingData = [
                'user_id' => $userId,
                'konselor_id' => $konselorId,
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'nomor_telepon' => $validated['nomor_telepon'],
                'topik' => $validated['topik'],
                'deskripsi' => $validated['deskripsi'],
                'jadwal' => now()->addDays(3), // Default jadwal 3 hari dari sekarang
                'status' => 'menunggu'
            ];
            
            // Log data sebelum menyimpan
            Log::info('Mencoba menyimpan data konseling:', $konselingData);
            
            try {
                $konseling = Konseling::create($konselingData);
                Log::info('Konseling berhasil disimpan', ['id' => $konseling->id]);
            } catch (\Exception $innerException) {
                Log::error('Error saat create konseling: ' . $innerException->getMessage(), [
                    'exception' => $innerException->getMessage(),
                    'trace' => $innerException->getTraceAsString(),
                    'data' => $konselingData
                ]);
                throw $innerException;
            }
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menyimpan konseling: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('konseling.list')->with('success', 'Pengajuan konseling berhasil dikirim!');
    }
    
    public function create()
    {
        return view('konseling-create');
    }
    
    public function manage(Request $request)
    {
        // Cek apakah user adalah admin atau konselor
        if (!Auth::check() || (Auth::user()->role_id != 1 && Auth::user()->role_id != 2)) {
            return redirect()->route('home');
        }
        
        $query = DB::table('konseling')
            ->leftJoin('users as pengaju', 'konseling.user_id', '=', 'pengaju.id')
            ->leftJoin('users as konselor', 'konseling.konselor_id', '=', 'konselor.id')
            ->select(
                'konseling.id',
                'pengaju.name as nama_pengaju',
                'konselor.name as nama_konselor',
                'konseling.nama_lengkap',
                'konseling.jadwal',
                'konseling.topik',
                'konseling.status'
            );
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('konseling.status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('konseling.jadwal', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('konseling.jadwal', '<=', $request->date_to);
        }
        
        // Jika user adalah konselor, hanya tampilkan konseling yang ditangani oleh konselor tersebut
        if (Auth::user()->role_id == 2) {
            $query->where('konseling.konselor_id', Auth::user()->id);
        }
        
        $konselings = $query->orderBy('konseling.jadwal', 'asc')->get();
        
        return view('konseling.manage', compact('konselings'));
    }
    
    public function edit($id)
    {
        $konseling = Konseling::findOrFail($id);
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login untuk melakukan tindakan ini.');
        }
        
        // Hanya admin, konselor yang menangani, atau pemilik konseling yang bisa mengedit
        if ($user->role_id != 1 && $user->id != $konseling->konselor_id && $user->id != $konseling->user_id) {
            return redirect()->route('konseling.list')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit jadwal konseling ini.');
        }
        
        $konselors = User::where('role_id', 2)->get();
        return view('konseling.edit', compact('konseling', 'konselors'));
    }
    
    public function update(Request $request, $id)
    {
        $konseling = Konseling::findOrFail($id);
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login untuk melakukan tindakan ini.');
        }
        
        // Hanya admin, konselor yang menangani, atau pemilik konseling yang bisa mengupdate
        if ($user->role_id != 1 && $user->id != $konseling->konselor_id && $user->id != $konseling->user_id) {
            return redirect()->route('konseling.list')
                ->with('error', 'Anda tidak memiliki izin untuk mengubah jadwal konseling ini.');
        }
        
        $validated = $request->validate([
            'konselor_id' => 'required|exists:users,id',
            'jadwal' => 'required|date',
            'topik' => 'required|string|max:255',
            'status' => 'required|string',
            'catatan' => 'nullable|string',
        ]);
        
        try {
            $konseling->update($validated);
            return redirect()->route('konseling.list')
                ->with('success', 'Jadwal konseling berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('konseling.edit', $id)
                ->with('error', 'Gagal memperbarui jadwal konseling: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        // Cek apakah user adalah admin, konselor, atau pemilik konseling
        $konseling = Konseling::findOrFail($id);
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login untuk melakukan tindakan ini.');
        }
        
        // Hanya admin, konselor yang menangani, atau pemilik konseling yang bisa menghapus
        if ($user->role_id != 1 && $user->id != $konseling->konselor_id && $user->id != $konseling->user_id) {
            return redirect()->route('konseling.list')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus jadwal konseling ini.');
        }
        
        try {
            $konseling->delete();
            return redirect()->route('konseling.manage')
                ->with('success', 'Jadwal konseling berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('konseling.manage')
                ->with('error', 'Gagal menghapus jadwal konseling: ' . $e->getMessage());
        }
    }
}
