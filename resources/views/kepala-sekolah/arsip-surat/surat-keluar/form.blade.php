<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <form action="{{ route('kepala-sekolah.arsip-surat.surat-keluar.search') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal</label> <span class="text-danger">*</span>
                        <select name="pilih_tanggal" class="form-control @error('pilih_tanggal') is-invalid @enderror">
                            <option>-Pilih-</option>
                            <option value="Tanggal Surat" @if(request()->get('pilih_tanggal') == 'Tanggal Surat') selected @endif>Tanggal Surat</option>
                            <option value="Tanggal Keluar" @if(request()->get('pilih_tanggal') == 'Tanggal Keluar') selected @endif>Tanggal Keluar</option>
                        </select>
                        @error('pilih_tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal Awal</label> <span class="text-danger">*</span>
                        <input type="date" name="tanggal_awal" value="{{ request()->get('tanggal_awal') }}" class="form-control @error('tanggal_awal') is-invalid @enderror">
                        @error('tanggal_awal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal Akhir</label> <span class="text-danger">*</span>
                        <input type="date" name="tanggal_akhir" value="{{ request()->get('tanggal_akhir') }}" class="form-control @error('tanggal_akhir') is-invalid @enderror">
                        @error('tanggal_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary mr-1"><i class="fas fa-search mr-1"></i> Seacrh</button>
            <a href="{{ route('kepala-sekolah.arsip-surat.surat-keluar.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-sync mr-1"></i> Refresh</a>
        </form>
    </div>
</div>
