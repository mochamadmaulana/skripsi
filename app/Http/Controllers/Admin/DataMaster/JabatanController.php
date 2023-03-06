<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::orderBy('id','DESC')->get();
        return view('admin.data-master.jabatan.index', compact('jabatan'));
    }

    public function create()
    {
        return view('admin.data-master.jabatan.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required','max:50','unique:jabatans,nama']
        ]);
        $jabatan = Jabatan::create(["nama" => $request->nama]);
        return redirect()->route('admin.data-master.jabatan.index')->with('success',$jabatan->nama.' berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::whereId($id)->first();
        return view('admin.data-master.jabatan.edit',compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required','max:50','unique:jabatans,nama']
        ]);
        $jabatan = Jabatan::whereId($id)->first();
        Jabatan::whereId($id)->update(["nama" => $request->nama]);
        return redirect()->route('admin.data-master.jabatan.index')->with('success',$jabatan->nama.' berhasil diedit menjadi '.$request->nama);
    }

    public function destroy($id)
    {
        if ($id) {
            $jabatan = Jabatan::whereId($id)->first();
            $delete = Jabatan::whereId($id)->delete();
            if ($delete) {
                return back()->with('success',$jabatan->nama.' berhasil dihapus!');
            }else{
                return back()->with('error',$jabatan->nama.' gagal dihapus!');
            }
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }
}
