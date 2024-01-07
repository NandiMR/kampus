<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Matkul;
use Auth;
use Illuminate\Support\Str; // Import Str

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Your index logic goes here
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Your create logic goes here
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|unique:matkul|max:191',
        ]);

        Matkul::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        if (Auth::user()->isDosen()) {
            return redirect()->route('module')->with('success', 'Directory berhasil dibuat.');
        }
        return redirect()->route('module.index')->with('success', 'Directory berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Your show logic goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Matkul  $matkul
     * @return \Illuminate\Http\Response
     */
    public function edit(Matkul $matkul)
    {
        return view('admin.module._edit-dir', compact('matkul'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Matkul  $matkul
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matkul $matkul)
    {
        // Check if the name is different before running validation
        if ($matkul->name !== $request->name) {
            $validate = $request->validate([
                'name' => 'required|string|unique:matkul|max:191',
            ]);
        }

        // Update name and URL slug
        $matkul->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        if (Auth::user()->isDosen()) {
            return redirect()->route('module')->with('success', 'Directory berhasil diupdate.');
        }
        return redirect()->route('module.index')->with('success', 'Directory berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matkul = Matkul::find($id);
        $module = $matkul->module->count();
        if ($module > 0) {
            if (Auth::user()->isDosen()) {
                return redirect()->route('module')->with('error','Directory tidak dapat dihapus, masih terdapat modul dalam directory ini.');
            }
            return redirect()->route('module.index')->with('error','Directory tidak dapat dihapus, masih terdapat modul dalam directory ini.');
        }
        $matkul->delete();
        if (Auth::user()->isDosen()) {
            return redirect()->route('module')->with('success', 'Directory terhapus.');
        }
        return redirect()->route('module.index')->with('success', 'Directory terhapus.');
    }
}
