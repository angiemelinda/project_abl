<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // API endpoint
        if ($request->wantsJson()) {
            $query = User::with('role'); // Eager load roles to prevent N+1 problem

            if ($request->has('role')) {
                $query->whereHas('role', function ($q) use ($request) {
                    $q->where('name', $request->input('role'));
                });
            }

            $users = $query->get();

            return response()->json($users);
        }
        
        // Web view - hanya admin yang bisa mengakses halaman ini
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya admin yang bisa mengakses halaman ini
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // API endpoint
        if ($request->wantsJson()) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role_id' => 'required|exists:roles,id',
            ]);
            
            $validated['password'] = Hash::make($validated['password']);
            
            $user = User::create($validated);
            
            return response()->json($user, 201);
        }
        
        // Web form
        // Hanya admin yang bisa mengakses halaman ini
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
        
        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json($user);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Hanya admin yang bisa mengakses halaman ini
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $user = User::findOrFail($id);
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // API endpoint
        if ($request->wantsJson()) {
            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
                'role_id' => 'sometimes|required|exists:roles,id',
            ];
            
            // Jika password diisi, validasi password
            if ($request->has('password')) {
                $rules['password'] = 'required|string|min:6';
            }
            
            $validated = $request->validate($rules);
            
            // Jika password diisi, hash password
            if ($request->has('password')) {
                $validated['password'] = Hash::make($validated['password']);
            }
            
            $user->update($validated);
            
            return response()->json($user);
        }
        
        // Web form
        // Hanya admin yang bisa mengakses halaman ini
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ];
        
        // Jika password diisi, validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }
        
        $validated = $request->validate($rules);
        
        // Jika password diisi, hash password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Jika password tidak diisi, hapus dari array validated
            unset($validated['password']);
        }
        
        $user->update($validated);
        
        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hanya admin yang bisa mengakses halaman ini
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $user = User::findOrFail($id);
        
        // Jangan hapus diri sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }
        
        try {
            // Hapus semua konseling yang terkait dengan user ini
            \App\Models\Konseling::where('user_id', $id)->orWhere('konselor_id', $id)->delete();
            
            // Hapus user
            $user->delete();
            
            return redirect()->route('users.index')
                ->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
    
    /**
     * Display a listing of konselors.
     */
    public function konselorIndex()
    {
        // Hanya admin yang bisa mengakses halaman ini
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $konselorRole = Role::where('name', 'konselor')->first();
        $konselors = User::where('role_id', $konselorRole->id)->get();
        
        return view('admin.konselors.index', compact('konselors'));
    }
    
    /**
     * Show the form for editing user profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];
        
        // Jika password diisi, validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }
        
        $validated = $request->validate($rules);
        
        // Jika password diisi, hash password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Jika password tidak diisi, hapus dari array validated
            unset($validated['password']);
        }
        
        $user->update($validated);
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
