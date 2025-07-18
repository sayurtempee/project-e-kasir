<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Svg\Tag\Rect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();

        $search = $request->input('search');
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();

        $title = 'Daftar Admin';
        return view('admin.daftar', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Admin';
        return view('admin.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:admin,kasir',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validateData['password'] = bcrypt($request->password);

        // Set status otomatis jadi 'tidak aktif' untuk admin maupun kasir baru
        $validateData['status'] = 'tidak aktif';

        if ($request->hasFile('photo')) {
            $validateData['photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        User::create($validateData);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        $title = 'Edit Admin';
        return view('admin.edit', compact('admin', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'role' => 'in:admin,kasir',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $dataUpdate = [];

        if ($request->hasFile('photo')) {
            if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                Storage::disk('public')->delete($admin->photo);
            }

            $dataUpdate['photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        if (!empty($dataUpdate)) {
            $admin->update($dataUpdate);
        }

        return redirect()->route('admin.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        // Jika target adalah admin, hanya boleh hapus diri sendiri
        if ($admin->role === 'admin' && auth()->id() !== $admin->id) {
            return redirect()->route('admin.index')->with('error', 'Anda hanya dapat menghapus akun admin Anda sendiri.');
        }

        // Jika target adalah kasir, boleh dihapus oleh siapa saja (admin)
        $admin->delete();

        // Jika menghapus diri sendiri, logout
        if (auth()->id() === $admin->id) {
            return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus');
        }

        return redirect()->route('login')->with('success', 'Akun anda berhasil dihapus');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hapus_foto' => 'nullable|boolean',
        ]);

        $user->name = $request->name;

        // Hapus foto jika checkbox dicentang
        if ($request->filled('hapus_foto') && $request->hapus_foto) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = null;
        }

        // Upload foto baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $file = $request->file('photo');
            $path = $file->store('profile-photos', 'public');
            $user->photo = $path;
        }

        $message = 'Profil berhasil diperbarui!';
        if ($request->has('hapus_foto')) {
            $message .= ' Foto profil telah dihapus.';
        }

        $user->save();

        $redirectTo = $request->input('redirect_to', route('dashboard'));
        return redirect($redirectTo)->with('success', 'Profile berhasil diperbarui!');
    }
}
