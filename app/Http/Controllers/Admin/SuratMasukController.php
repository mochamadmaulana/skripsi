<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisposisiSuratMasuk;
use App\Models\FileSuratMasuk;
use App\Models\Jabatan;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','disposisi_surat_masuk')->orderBy('id','DESC')->get();
        return view('admin.surat-masuk.index',compact('surat_masuk'));
    }

    public function create()
    {
        $nomor_terakhir = SuratMasuk::max('nomor_agenda') == null ? 0 : SuratMasuk::max('nomor_agenda');
        $increment = intval($nomor_terakhir)+1;
        $nomor_agenda = str_repeat(0,(4-strlen($increment))).$increment;
        $jabatans = Jabatan::all();
        return view('admin.surat-masuk.tambah', compact('nomor_agenda','jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nomor_surat" => ["required"],
            "nama_surat" => ["required"],
            "nama_pengirim" => ["required"],
            "tanggal_surat" => ["required"],
            "disposisi_surat" => ["required"],
            "tanggal_diterima" => ["required"],
            "files" => ['required'],
            "files.*" => ['required', 'mimes:jpg,jpeg,png,pdf,docx,docs,xlsx,csv,ppt,pptx,heic', 'max:4096'],
        ]);

        $last_nomor_agenda = SuratMasuk::max('nomor_agenda') == null ? 0 : SuratMasuk::max('nomor_agenda');
        $increment = intval($last_nomor_agenda)+1;
        $nomor_agenda = strval(str_repeat(0,(4-strlen($increment))).$increment);

        $root_cloud_storage = collect(Storage::disk('google')->listContents('/',false));
        $folder = $root_cloud_storage->where('type','dir')->where('filename','Surat Masuk')->first();

        try {
            DB::beginTransaction();
            $surat_masuk = SuratMasuk::create([
                "nomor_agenda" => $nomor_agenda,
                "nomor_surat" => $request->nomor_surat,
                "nama_surat" => $request->nama_surat,
                "nama_pengirim" => $request->nama_pengirim,
                "tanggal_surat" => $request->tanggal_surat,
                "tanggal_diterima" => $request->tanggal_diterima,
                "perihal" => $request->perihal,
            ]);
            if($request->disposisi_surat){
                $disposisi_surats = $request->disposisi_surat;
                foreach($disposisi_surats as $disposisi_surat){
                    DisposisiSuratMasuk::create([
                        'surat_masuk_id' => $surat_masuk->id,
                        'jabatan_id' => $disposisi_surat,
                    ]);
                }
            }
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $ext = strtolower($file->getClientOriginalExtension());
                    $nama_file = 'SM-'.date('ymd').$surat_masuk->nomor_agenda.'-'.Str:: random(10).'.'.$ext;
                    $data = $file->storeAs($folder['path'], $nama_file, "google");
                    if($data){
                        FileSuratMasuk::create([
                            'surat_masuk_id' => $surat_masuk->id,
                            'folder' => 'Surat Masuk',
                            'nama_file' => $nama_file,
                            'extention' => $ext,
                            'uri' => Storage::disk('google')->url($data),
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.surat-masuk.index')->with("success", "Data surat masuk berhasil ditambahkan");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.surat-masuk.index')->with("error", "Data surat masuk gagal ditambahkan");
        }
    }

    public function show($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','disposisi_surat_masuk')->whereId($id)->first();
        return view('admin.surat-masuk.detail', compact('surat_masuk'));
    }

    public function edit($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk')->whereId($id)->orderBy('id','DESC')->first();
        $jabatans = Jabatan::all();
        return view('admin.surat-masuk.edit', compact('surat_masuk','jabatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "nomor_surat" => ["required"],
            "nama_surat" => ["required"],
            "nama_pengirim" => ["required"],
            "tanggal_surat" => ["required"],
            "tanggal_diterima" => ["required"],
        ]);
        SuratMasuk::whereId($id)->update([
            "nomor_surat" => $request->nomor_surat,
            "nama_surat" => $request->nama_surat,
            "nama_pengirim" => $request->nama_pengirim,
            "tanggal_surat" => $request->tanggal_surat,
            "tanggal_diterima" => $request->tanggal_diterima,
            "perihal" => $request->perihal,
        ]);
        if($request->disposisi_surat){
            $disposisi_surats = $request->disposisi_surat;
            foreach ($disposisi_surats as  $disposisi_surat) {
                if(! DisposisiSuratMasuk::where('surat_masuk_id',$id)->where('jabatan_id',$disposisi_surat)->first()){
                    DisposisiSuratMasuk::create([
                        'surat_masuk_id' => $id,
                        'jabatan_id' => $disposisi_surat,
                    ]);
                }
            }
        }
        return redirect()->route('admin.surat-masuk.index')->with("success", "Data surat masuk berhasil diedit");
    }

    public function destroy($id)
    {
        $surat_masuk = SuratMasuk::whereId($id)->first();
        $file_surat_masuk = FileSuratMasuk::where('surat_masuk_id',$id)->get();
        $disposisi_surat_masuk = DisposisiSuratMasuk::where('surat_masuk_id',$id)->get();
        $folder_db = $file_surat_masuk->first();
        $content_cloud_storage = collect(Storage::disk('google')->listContents('/',false));

        $meta_folder = $content_cloud_storage->where('type','dir')->where('filename',$folder_db->folder)->first();

        if(! $meta_folder){
            return back()->with('error', 'Folder tidak ditemukan pada cloud storage!');
        }

        $get_files_in_meta_folder = collect(Storage::disk('google')->listContents($meta_folder['path'],false));
        foreach ($file_surat_masuk as $key => $val) {
            $del_file_storage = Storage::disk('google')->delete($get_files_in_meta_folder->where('type','file')->where('name',$val->nama_file)->first()['path']);
            if($del_file_storage){
                FileSuratMasuk::where('surat_masuk_id',$id)->first()->delete();
            }
        }
        foreach ($disposisi_surat_masuk as  $key => $asm) {
            DisposisiSuratMasuk::where('surat_masuk_id',$id)->first()->delete();
        }
        $del_surat_masuk_local_db = $surat_masuk->delete();
        if($del_surat_masuk_local_db){
            return back()->with('success',$surat_masuk->nama_surat.' berhasil dihapus');
        }
    }

    public function delete_file($id)
    {
        $file_surat_masuk = FileSuratMasuk::whereId($id)->first();
        $content_cloud_storage = collect(Storage::disk('google')->listContents('/',false));

        $meta_folder = $content_cloud_storage->where('type','dir')->where('filename',$file_surat_masuk->folder)->first();

        if(! $meta_folder){
            return back()->with('error', 'Folder tidak ditemukan pada cloud storage!');
        }

        $files_cloud = collect(Storage::disk('google')->listContents($meta_folder['path'],false));
        $cloud_file = $files_cloud->where('type','file')
            ->where('name', $file_surat_masuk->nama_file)
            ->first();

        $del_file_cloud = Storage::disk('google')->delete($cloud_file['path']);
        $del_file_local_db = $file_surat_masuk->delete();

        if($del_file_local_db && $del_file_cloud){
            return back()->with('success','File surat masuk '.$file_surat_masuk->nama_file.' berhasil dihapus');
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
            return redirect()->route('admin.surat-masuk.edit',$id)->withErrors($validator)->withInput();
        }

        $data_surat_masuk = SuratMasuk::whereId($id)->first();
        $folder_db = FileSuratMasuk::where('surat_masuk_id',$id)->first();

        $root_cloud_storage = collect(Storage::disk('google')->listContents('/',false));
        $meta_folder = $root_cloud_storage->where('type','dir')->where('filename',$folder_db->folder)->first();

        if(! $meta_folder){
            return back()->with('error', 'Folder tidak ditemukan pada cloud storage!');
        }

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $nama_file = 'SM-'.date('ymd').$data_surat_masuk->nomor_agenda.'-'.Str::random(10).'.'.$ext;
                $data = $file->storeAs($meta_folder['path'], $nama_file, "google");
                if($data){
                    FileSuratMasuk::create([
                        'surat_masuk_id' => $data_surat_masuk->id,
                        'folder' => $folder_db->folder,
                        'nama_file' => $nama_file,
                        'extention' => $ext,
                        'uri' => Storage::disk('google')->url($data),
                    ]);
                }
            }
        }
        return back()->with('success', 'File surat masuk berhasil ditambahkan');
    }

    public function delete_disposisi($suratmasuk,$disposisisurat)
    {
        $disposisi_surat_masuk = DisposisiSuratMasuk::with('jabatan')->where('surat_masuk_id',$suratmasuk)->where('jabatan_id',$disposisisurat)->first();
        if($disposisi_surat_masuk){
            $disposisi_surat_masuk->delete();
            return back()->with('success','Disposisi surat berhasil dihapus!');
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }
}
