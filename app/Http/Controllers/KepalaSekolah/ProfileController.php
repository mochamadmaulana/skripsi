<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::orderBy('id','DESC')->get();
        return view('kepala-sekolah.profile.index',compact('jabatan'));
    }

    public function update_password(Request $request)
    {
        $this->validate($request, [
            'password_baru' => 'min:5',
            'konfirmasi_password' => 'required_with:password_baru|same:password_baru|min:5'
        ]);
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password_baru)
        ]);
        return redirect()->route('kepala-sekolah.profile.index')->with('success','Password berhasil diedit!');
    }

    public function update_profile(Request $request)
    {
        $pengguna = User::all();

        if($request->all()){
            $data = [];
            if($request->nama){
                $data['nama'] = $request->nama;
            }
            if($request->username){
                foreach($pengguna as $p){
                    if($request->username !== $p->username){
                        $data['username'] = strtolower($request->username);
                    }else{
                        return redirect()->route('user.profile.index')->with('error','Username telah digunakan!');
                    }
                }
            }
            if($request->email){
                foreach($pengguna as $p){
                    if($request->email !== $p->email){
                        $data['email'] = strtolower($request->email);
                    }else{
                        return redirect()->route('user.profile.index')->with('error','Email telah digunakan!');
                    }
                }
            }
            User::whereId(auth()->user()->id)->update($data);
            return redirect()->route('user.profile.index')->with('success','Profile berhasil diedit!');
        }
    }

    public function update_avatar(Request $request)
    {
        if($request->file('avatar')){
            $avatar = $request->file('avatar');
            $extention = $avatar->getClientOriginalExtension();
            $nama_avatar = 'avatar-' . auth()->user()->username . '-' . Str:: random(10) . '.' . $extention;
            if(auth()->user()->avatar !== 'default.jpg'){
                File::delete('avatar/'.auth()->user()->avatar);
            }
            $avatar->move(public_path('avatar'), $nama_avatar);
            User::whereId(auth()->user()->id)->update([
                'avatar' => $nama_avatar
            ]);
            return redirect()->route('kepala-sekolah.profile.index')->with('success','Avatar berhasil diedit!');
        }else{
            return redirect()->route('kepala-sekolah.profile.index')->with('error','Avatar gagal diedit!');
        }
    }
}
