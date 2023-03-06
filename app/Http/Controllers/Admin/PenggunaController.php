<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::with('jabatan')->orderBy('id','DESC')->get();
        return view('admin.pengguna.index',compact('pengguna'));
    }
    public function create()
    {
        $jabatan = Jabatan::orderBy('id','DESC')->get();
        return view('admin.pengguna.tambah',compact('jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama" => ["required", "max:200"],
            "username" => ["required", "max:25", "unique:users"],
            "email" => ["required", "unique:users"],
            "jabatan" => ["required"],
            "role" => ["required"],
        ]);
        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'jabatan_id' => $request->jabatan,
            'aktif' => 1,
            'role' => $request->role,
            'password' => Hash::make('password'),
        ];
        if($request->file('avatar')){
            $avatar = $request->file('avatar');
            $extention = $avatar->getClientOriginalExtension();
            $nama_avatar = 'avatar-' . $request->username . '-' . Str:: random(10) . '.' . $extention;
            $avatar->storeAs('public/avatar', $nama_avatar);
            $data['avatar'] = $nama_avatar;
        }else{
            $data['avatar'] = 'default.jpg';
        }
        $create = User::create($data);
        if($create){
            return redirect()->route('admin.pengguna.index')->with('success','Pengguna berhasil ditambahkan');
        }else{
            return redirect()->route('admin.pengguna.index')->with('error','Pengguna gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $pengguna = User::whereId($id)->first();
        $jabatan = Jabatan::orderBy('id','DESC')->get();
        return view('admin.pengguna.edit',compact('pengguna','jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "nama" => ["required", "max:200"],
            "username" => ["required", "max:25"],
            "email" => ["required"],
            "jabatan" => ["required"],
            "aktif" => ["required"],
            "role" => ["required"],
        ]);

        $pengguna = User::whereId($id)->first();
        $data = [
            'nama' => $request->nama,
            'jabatan_id' => $request->jabatan,
            'aktif' => $request->aktif,
            'role' => $request->role,
        ];
        if($request->username != $pengguna->username){
            $data['username'] = $request->username;
        }
        if($request->email != $pengguna->email){
            $data['email'] = $request->email;
        }
        if($request->file('avatar')){
            $avatar = $request->file('avatar');
            $extention = $avatar->getClientOriginalExtension();
            $nama_avatar = 'avatar-' . $pengguna->username . '-' . Str:: random(10) . '.' . $extention;
            if($pengguna->avatar !== 'default.jpg'){
                Storage::disk('local')->delete('public/avatar/'.$pengguna->avatar);
            }
            $avatar->storeAs('public/avatar', $nama_avatar);

            $data['avatar'] = $nama_avatar;
        }
        $update = User::whereId($id)->update($data);
        if($update){
            return redirect()->route('admin.pengguna.index')->with('success','Pengguna berhasil diedit');
        }else{
            return redirect()->route('admin.pengguna.index')->with('error','Pengguna gagal diedit');
        }
    }

    public function destroy($id)
    {
        $pengguna = User::whereId($id)->first();
        if($pengguna){
            if($pengguna->avatar !== 'default.jpg'){
                Storage::disk('local')->delete('public/avatar/'.$pengguna->avatar);
            }
            $pengguna->delete();
            return redirect()->route('admin.pengguna.index')->with('success','Pengguna berhasil diapus');
        }else{
            return redirect()->route('admin.pengguna.index')->with('success','Pengguna gagal diapus');
        }
    }
}
