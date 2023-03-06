<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AksesSuratKeluar;
use App\Models\FileSuratKeluar;
use App\Models\Jabatan;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','akses_surat_keluar')->orderBy('id','DESC')->get();
        return view('admin.surat-keluar.index',compact('surat_keluar'));
    }

    public function create()
    {
        $nomor_terakhir = SuratKeluar::max('nomor_agenda') == null ? 0 : SuratKeluar::max('nomor_agenda');
        $increment = intval($nomor_terakhir)+1;
        $nomor_agenda = str_repeat(0,(4-strlen($increment))).$increment;
        $jabatans = Jabatan::all();
        return view('admin.surat-keluar.tambah', compact('nomor_agenda','jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nomor_surat" => ["required"],
            "nama_surat" => ["required"],
            "ditujukan_kepada" => ["required"],
            "tanggal_surat" => ["required"],
            "akses_surat" => ["required"],
            "tanggal_keluar" => ["required"],
            "files" => ['required'],
            "files.*" => ['required', 'mimes:jpg,jpeg,png,pdf,docx,docs,xlsx,csv,ppt,pptx,heic', 'max:4096'],
        ]);

        $last_nomor_agenda = SuratKeluar::max('nomor_agenda') == null ? 0 : SuratKeluar::max('nomor_agenda');
        $increment = intval($last_nomor_agenda)+1;
        $nomor_agenda = strval(str_repeat(0,(4-strlen($increment))).$increment);

        $root_cloud_storage = collect(Storage::disk('google')->listContents('/',false));
        $folder = $root_cloud_storage->where('type','dir')->where('filename','Surat Keluar')->first();
        try {
            DB::beginTransaction();
            $surat_keluar = SuratKeluar::create([
                "nomor_agenda" => $nomor_agenda,
                "nomor_surat" => $request->nomor_surat,
                "nama_surat" => $request->nama_surat,
                "ditujukan_kepada" => $request->ditujukan_kepada,
                "tanggal_surat" => $request->tanggal_surat,
                "tanggal_keluar" => $request->tanggal_keluar,
                "status_approve" => 'Prosess',
                "perihal" => $request->perihal,
            ]);
            if($request->akses_surat){
                $akses_surats = $request->akses_surat;
                foreach($akses_surats as $akses_surat){
                    AksesSuratKeluar::create([
                        'surat_keluar_id' => $surat_keluar->id,
                        'jabatan_id' => $akses_surat,
                    ]);
                }
            }
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $ext = strtolower($file->getClientOriginalExtension());
                    $nama_file = 'SK-'.date('ymd').$surat_keluar->nomor_agenda.'-'.Str::random(10).'.'.$ext;
                    $data = $file->storeAs($folder['path'], $nama_file, "google");
                    FileSuratKeluar::create([
                        'surat_keluar_id' => $surat_keluar->id,
                        'folder' => 'Surat Keluar',
                        'nama_file' => $nama_file,
                        'extention' => $ext,
                        'uri' => Storage::disk('google')->url($data),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.surat-keluar.index')->with("success", "Data surat keluar berhasil ditambahkan!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.surat-keluar.index')->with("error", "Data surat keluar gagal ditambahkan!");
        }
    }

    public function show($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','akses_surat_keluar')->whereId($id)->first();
        return view('admin.surat-keluar.detail', compact('surat_keluar'));
    }

    public function edit($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar')->whereId($id)->first();
        $jabatans = Jabatan::all();
        return view('admin.surat-keluar.edit', compact('surat_keluar','jabatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "nomor_surat" => ["required"],
            "nama_surat" => ["required"],
            "ditujukan_kepada" => ["required"],
            "tanggal_surat" => ["required"],
            "tanggal_keluar" => ["required"],
        ]);

        try {
            DB::beginTransaction();
            SuratKeluar::whereId($id)->update([
                "nomor_surat" => $request->nomor_surat,
                "nama_surat" => $request->nama_surat,
                "ditujukan_kepada" => $request->ditujukan_kepada,
                "tanggal_surat" => $request->tanggal_surat,
                "tanggal_keluar" => $request->tanggal_keluar,
                "perihal" => $request->perihal,
            ]);
            if($request->akses_surat){
                $akses_surats = $request->akses_surat;
                foreach ($akses_surats as  $akses_surat) {
                    if(! AksesSuratKeluar::where('surat_keluar_id',$id)->where('jabatan_id',$akses_surat)->first()){
                        AksesSuratKeluar::create([
                            'surat_keluar_id' => $id,
                            'jabatan_id' => $akses_surat,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.surat-keluar.index')->with("success", "Data surat keluar berhasil diedit!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.surat-keluar.index')->with("error", "Data surat keluar gagal diedit!");
        }
    }

    public function destroy($id)
    {
        $surat_keluar = SuratKeluar::whereId($id)->first();
        $file_surat_keluar = FileSuratKeluar::where('surat_keluar_id',$id)->get();
        $akses_surat_keluar = AksesSuratKeluar::where('surat_keluar_id',$id)->get();
        $folder_db = $file_surat_keluar->first();
        $content_cloud_storage = collect(Storage::disk('google')->listContents('/',false));

        $meta_folder = $content_cloud_storage->where('type','dir')->where('filename',$folder_db->folder)->first();

        if(! $meta_folder){
            return back()->with('error', 'Folder tidak ditemukan pada cloud storage!');
        }
        $get_files_in_meta_folder = collect(Storage::disk('google')->listContents($meta_folder['path'],false));
        foreach ($file_surat_keluar as $key => $val) {
            $del_file_storage = Storage::disk('google')->delete($get_files_in_meta_folder->where('type','file')->where('name',$val->nama_file)->first()['path']);
            if($del_file_storage){
                FileSuratKeluar::where('surat_keluar_id',$id)->first()->delete();
            }
        }
        foreach ($akses_surat_keluar as $ask) {
            AksesSuratKeluar::where('surat_keluar_id',$id)->first()->delete();
        }
        $del_surat_keluar_local_db = $surat_keluar->delete();
        if($del_surat_keluar_local_db){
            return back()->with('success',$surat_keluar->nama_surat.' berhasil dihapus');
        }
        return back()->with('error',$surat_keluar->nama_surat.' berhasil dihapus');
    }

    public function delete_file($id)
    {
        $file_surat_keluar = FileSuratKeluar::whereId($id)->first();
        $content_cloud_storage = collect(Storage::disk('google')->listContents('/',false));

        $meta_folder = $content_cloud_storage->where('type','dir')->where('filename',$file_surat_keluar->folder)->first();

        if(! $meta_folder){
            return back()->with('error', 'Folder tidak ditemukan pada cloud storage!');
        }

        $surat_keluar = collect(Storage::disk('google')->listContents($meta_folder['path'],false));
        $cloud_file = $surat_keluar->where('type','file')
            ->where('name', $file_surat_keluar->nama_file)
            ->first();

        $del_file_cloud = Storage::disk('google')->delete($cloud_file['path']);
        $del_file_local_db = $file_surat_keluar->delete();

        if($del_file_local_db && $del_file_cloud){
            return back()->with('success','File surat keluar '.$file_surat_keluar->nama_file.' berhasil dihapus!');
        }
    }

    public function add_file(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "files" => ['required'],
            "files.*" => ['required', 'mimes:jpg,jpeg,png,pdf,docx,docs,xlsx,csv,ppt,pptx,heic', 'max:4096'],
        ]);

        if ($validator->fails()) {
            Session::flash('error','File surat gagal ditambahkan!');
            return redirect()->route('admin.surat-keluar.edit',$id)->withErrors($validator)->withInput();
        }

        $data_surat_keluar = SuratKeluar::whereId($id)->first();

        $root_cloud_storage = collect(Storage::disk('google')->listContents('/',false));
        $folder = $root_cloud_storage->where('type','dir')->where('filename','Surat Keluar')->first();

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $nama_file = 'SK-'.date('ymd').$data_surat_keluar->nomor_agenda.'-'.Str::random(10).'.'.$ext;
                $data = $file->storeAs($folder['path'], $nama_file, "google");
                FileSuratKeluar::create([
                    'surat_keluar_id' => $data_surat_keluar->id,
                    'folder' => 'Surat Keluar',
                    'nama_file' => $nama_file,
                    'extention' => $ext,
                    'uri' => Storage::disk('google')->url($data),
                ]);
            }
        }
        return back()->with('success', 'File surat keluar berhasil ditambahkan!');
    }

    public function delete_akses($suratkeluar,$aksessurat)
    {
        $akses_surat_keluar = AksesSuratKeluar::with('jabatan')->where('surat_keluar_id',$suratkeluar)->where('jabatan_id',$aksessurat)->first();
        if($akses_surat_keluar){
            $akses_surat_keluar->delete();
            return back()->with('success','Akses surat berhasil dihapus!');
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }
}
