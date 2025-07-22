<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $query = Member::query();

        if (request()->has('search') && request()->search != '') {
            $query->where('name', 'like', '%' . request()->search . '%')
                  ->orWhere('email', 'like', '%' . request()->search . '%');
        }

        $members = $query->get();

        return view('member.daftar', [
            'title' => 'Daftar Member',
            'members' => $members,
        ]);
    }

    public function create()
    {
        return view('member.add', ['title' => 'Tambah Member']);
    }

    public function store(Request $request)
    {
        // dd($request->input('no_telp'));
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'no_telp' => 'required|string|max:20|unique:members,no_telp',
            'email'   => 'required|email|unique:members,email',
            'status'  => 'required|in:active,inactive',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ], [
            'no_telp.unique' => 'Nomor telepon sudah digunakan oleh member lain.',
            'email.unique'   => 'Email sudah digunakan oleh member lain.',
        ]);

        Member::create([
            'name'    => $validated['name'],
            'no_telp' => $validated['no_telp'],
            'email'   => $validated['email'],
            'status'  => $validated['status'],
            'discount_percentage' => $request->discount_percentage ?? 0
        ]);

        return redirect()->route('member.create')->with('success', 'Member berhasil ditambahkan!');
    }

    public function show(Member $member)
    {
        //
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'))->with('title', 'Edit Member');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'no_telp' => 'required|string|max:20|unique:members,no_telp,' . $id,
            'email'   => 'required|email|unique:members,email,' . $id,
            'status'  => 'required|in:active,inactive',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ], [
            'no_telp.unique' => 'Nomor telepon sudah digunakan oleh member lain.',
            'email.unique'   => 'Email sudah digunakan oleh member lain.',
        ]);

        $member = Member::findOrFail($id);
        $member->update([
            'name'    => $validated['name'],
            'no_telp' => $validated['no_telp'],
            'email'   => $validated['email'],
            'status' => $validated['status'],
            'discount_percentage' => $request->discount_percentage ?? 0
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus!');
    }
    public function toggleStatus($id)
    {
        $member = Member::findOrFail($id);
        $member->status = $member->status === 'active' ? 'inactive' : 'active';
        $member->save();

        return back()->with('success', 'Status member diperbarui!');
    }

}
