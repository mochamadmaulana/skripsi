@extends('layouts.admin', ['title' => 'Edit Surat Masuk', 'icon' => 'fas fa-envelope-open-text'])

@section('content')
@if ($errors->has('files.*'))
    <div class="alert alert-danger"><span class="mr-2">File extention must be:</span> jpg|jpeg|png|pdf|docx|docs|xlsx|csv|ppt|pptx (4096KB)</div>
@endif

<div class="card mb-4">
    <div class="card-header">
        <a href="{{ route('admin.surat-masuk.index') }}" class="btn btn-sm btn-secondary float-right shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.surat-masuk.update', $surat_masuk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="form-group">
                        <label>Nomor Agenda <span class="text-success font-italic"><sup>Terisi otomatis oleh sistem</sup></span></label>
                        <input type="text" class="form-control" value="{{ $surat_masuk->nomor_agenda }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Pengirim <span class="text-red">*</span></label>
                        <input type="text" name="nama_pengirim" class="form-control @error('nama_pengirim') is-invalid @enderror" value="{{ $surat_masuk->nama_pengirim }}" placeholder="Pengirim">
                        @error('nama_pengirim')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nomor Surat <span class="text-red">*</span></label>
                        <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ $surat_masuk->nomor_surat }}" placeholder="Nomor Surat">
                        @error('nomor_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Disposisi Surat <span class="text-red">*</span></label><br>
                        @foreach ($surat_masuk->disposisi_surat_masuk as $asm)
                        @if (count($surat_masuk->disposisi_surat_masuk) > 1)
                        <span class="badge badge-primary mr-1 mb-2"><a href="{{ url('admin/surat-masuk/'.$surat_masuk->id.'/disposisi-surat/'.$asm->jabatan_id.'/delete') }}" onclick="return confirm('Yakin, untuk menghapus disposisi {{ $asm->jabatan->nama }} ?')" class="badge badge-danger mr-1"><i class="fas fa-times"></i></a> {{ $asm->jabatan->nama }}</span>
                        @else
                        <span class="badge badge-primary mr-1 mb-2">{{ $asm->jabatan->nama }}</span>
                        @endif
                        @endforeach
                        <select name="disposisi_surat[]" class="form-control @error('disposisi_surat') is-invalid @enderror" multiple="multiple" id="selectDisposisiSurat">
                            <option value="">-Pilih-</option>
                            @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}" @if (@old('disposisi_surat') == $jabatan->id) selected @endif>{{ $jabatan->nama }}</option>
                            @endforeach
                        </select>
                        @error('disposisi_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nama Surat <span class="text-red">*</span></label>
                        <input type="text" name="nama_surat" class="form-control @error('nama_surat') is-invalid @enderror" value="{{ $surat_masuk->nama_surat }}" placeholder="Nama Surat">
                        @error('nama_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Surat <span class="text-red">*</span></label>
                        <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ $surat_masuk->tanggal_surat }}">
                        @error('tanggal_surat')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Diterima <span class="text-red">*</span></label>
                        <input type="date" name="tanggal_diterima" class="form-control @error('tanggal_diterima') is-invalid @enderror" value="{{ $surat_masuk->tanggal_diterima }}">
                        @error('tanggal_diterima')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Perihal <span class="text-warning font-italic"><sup>Opsional</sup></span></label>
                        <textarea name="perihal" class="form-control @error('perihal') is-invalid @enderror" cols="5" rows="5" >{{ $surat_masuk->perihal }}</textarea>
                        @error('perihal')
                            <div class="invalid-feedback">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>File Surat <span class="text-danger">*</span></label><br>
                        @foreach($surat_masuk->file_surat_masuk as $fsm)
                            <div class="row">
                                <div class="col-lg">
                                    @if($fsm->extention == 'pdf')
                                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-pdf"></i> {{ $fsm->nama_file }}</a>
                                    @elseif($fsm->extention == 'docx' || $fsm->extention == 'docs')
                                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-word"></i> {{ $fsm->nama_file }}</a>
                                    @elseif($fsm->extention == 'xlsx' || $fsm->extention == 'csv')
                                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-excel"></i> {{ $fsm->nama_file }}</a>
                                    @elseif($fsm->extention == 'ppt' || $fsm->extention == 'pptx')
                                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-powerpoint"></i> {{ $fsm->nama_file }}</a>
                                    @else
                                        <a href="{{ $fsm->uri }}" target="_blank"><i class="fas fa-file-image"></i> {{ $fsm->nama_file }}</a>
                                    @endif
                                    @if(count($surat_masuk->file_surat_masuk) > 1)
                                        <a href="{{ route('admin.delete-file-surat-masuk',$fsm->id) }}" onclick="return confirm('Yakin, untuk menghapus file {{ $fsm->nama_file }} ?')" class="btn btn-xs btn-danger ml-2"><i class="fas fa-trash-alt"></i></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-xs btn-success shadow-sm mt-2" data-toggle="modal" data-target="#tambahFileModal"><i class="fas fa-plus"></i> Tambah File</button>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary shadow-sm mt-3">
                        <i class="fas fa-edit"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.surat-masuk.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Edit Data</li>
@endpush

@push('modal')
<!-- Modal Tambah File-->
<div class="modal fade" id="tambahFileModal" tabindex="-1" aria-labelledby="tambahFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahFileModalLabel">Tambah File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.add-file-surat-masuk',$surat_masuk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>File Surat <span class="text-danger font-italic">* <sup>jpg|jpeg|png|pdf|docx|docs|xlsx|csv|ppt|pptx (4096KB)</sup></span></label><br>
                        <div id="file">
                            <div class="row">
                                <div class="col-lg">
                                    <input type="file" class="is-invalid" name="files[]" multiple>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-sm btn-success add-row float-right"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#selectDisposisiSurat').select2({
            theme: 'bootstrap4',
            placeholder: '-Pilih',
            allowClear: true,
        })

        $('.add-row').on('click', function(){
            var html = '';
            html += '<div class="row mt-3" id="row">';
            html += '<div class="col-lg">';
            html += '<input type="file" name="files[]" multiple>';
            html += '</div>';
            html += '<div class="col-lg-2">';
            html += '<button type="button" class="btn btn-sm btn-danger float-right"><i class="fas fa-times"></i></button>';
            html += '</div>';
            html += '</div>';
            $('#file').append(html);

            $(document).on('click','.btn-danger',function(){
                $(this).closest('#row').remove();
            })
        })
    })
</script>
@endpush
