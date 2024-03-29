<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dosen;
use App\User;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosens = Dosen::orderBy('name', 'ASC')->get();
        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $username = explode('@', $request->email);

        $user = User::create([
            'username' => $username[0],
            'email' => $request->email,
            'password' => bcrypt($username[0]),
        ]);
        $user->attachRole('dosen');
        $this->createDosen($user, $request->name);

        return redirect()->route('dosen.index')->with('success', 'Dosen telah ditambahkan.');
    }

    public function edit($id)
    {
        $dosen = Dosen::find($id);
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            // sesuaikan dengan kolom-kolom lain yang perlu diupdate
        ]);

        $dosen = Dosen::find($id);
        $dosen->update($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->detachRole('dosen');
        $user->delete();
        return redirect()->route('dosen.index')->with('success', 'Data dosen telah dihapus.');
    }

    private function createDosen($user, $name)
    {
        return Dosen::create([
            'user_id' => $user->id,
            'name' => $name,
        ]);
    }
}
