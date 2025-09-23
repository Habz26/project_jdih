@extends('layouts.layoutMaster')

@section('content')
    <div class="container">
        <h2>Edit Dokumen</h2>
        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pdf_file">Ganti File PDF (Opsional)</label>
                        <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                    </div>

                    <div class="mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control"
                            value="{{ old('judul', $document->judul) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_dokumen">Tipe Dokumen</label>
                        <select name="tipe_dokumen" id="tipe_dokumen" class="form-control">
                            <option value="Peraturan" {{ $document->tipe_dokumen == 'Peraturan' ? 'selected' : '' }}>
                                Peraturan</option>
                            <option value="Keputusan" {{ $document->tipe_dokumen == 'Keputusan' ? 'selected' : '' }}>
                                Keputusan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bidang_hukum">Bidang Hukum</label>
                        <select name="bidang_hukum" id="bidang_hukum" class="form-control">
                            <option value="Pidana" {{ $document->bidang_hukum == 'Pidana' ? 'selected' : '' }}>Pidana
                            </option>
                            <option value="Perdata" {{ $document->bidang_hukum == 'Perdata' ? 'selected' : '' }}>Perdata
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            @for ($i = date('Y'); $i >= 1945; $i--)
                                <option value="{{ $i }}" {{ $document->tahun == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="berlaku" {{ $document->status == 'berlaku' ? 'selected' : '' }}>Berlaku</option>
                            <option value="tidak berlaku" {{ $document->status == 'tidak berlaku' ? 'selected' : '' }}>
                                Tidak Berlaku</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="teu_badan">TEU Badan</label>
                        <input type="text" name="teu_badan" id="teu_badan" class="form-control"
                            value="{{ old('teu_badan', $document->teu_badan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="tempat_penetapan">Tempat Penetapan</label>
                        <input type="text" name="tempat_penetapan" id="tempat_penetapan" class="form-control"
                            value="{{ old('tempat_penetapan', $document->tempat_penetapan) }}">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_penetapan">Tanggal Penetapan</label>
                        <input type="date" name="tanggal_penetapan" id="tanggal_penetapan" class="form-control"
                            value="{{ old('tanggal_penetapan', $document->tanggal_penetapan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pengundangan">Tanggal Pengundangan</label>
                        <input type="date" name="tanggal_pengundangan" id="tanggal_pengundangan" class="form-control"
                            value="{{ old('tanggal_pengundangan', $document->tanggal_pengundangan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="sumber">Sumber</label>
                        <input type="text" name="sumber" id="sumber" class="form-control"
                            value="{{ old('sumber', $document->sumber) }}">
                    </div>

                    <div class="mb-3">
                        <label for="subjek">Subjek</label>
                        <input type="text" name="subjek" id="subjek" class="form-control"
                            value="{{ old('subjek', $document->subjek) }}">
                    </div>

                    <div class="mb-3">
                        <label for="bahasa">Bahasa</label>
                        <input type="text" name="bahasa" id="bahasa" class="form-control"
                            value="{{ old('bahasa', $document->bahasa) }}">
                    </div>

                    <div class="mb-3">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control"
                            value="{{ old('lokasi', $document->lokasi) }}">
                    </div>

                    <div class="mb-3">
                        <label for="urusan_pemerintahan">Urusan Pemerintahan</label>
                        <input type="text" name="urusan_pemerintahan" id="urusan_pemerintahan" class="form-control"
                            value="{{ old('urusan_pemerintahan', $document->urusan_pemerintahan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="penandatanganan">Penandatanganan</label>
                        <input type="text" name="penandatanganan" id="penandatanganan" class="form-control"
                            value="{{ old('penandatanganan', $document->penandatanganan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="pemrakarsa">Pemrakarsa</label>
                        <input type="text" name="pemrakarsa" id="pemrakarsa" class="form-control"
                            value="{{ old('pemrakarsa', $document->pemrakarsa) }}">
                    </div>

                    <div class="mb-3">
                        <label for="qrcode">QR Code</label>
                        <input type="text" name="qrcode" id="qrcode" class="form-control"
                            value="{{ old('qrcode', $document->qrcode) }}">
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
