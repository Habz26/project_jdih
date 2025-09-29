@extends('layouts.layoutMaster')

@section('content')
<div class="container">
    <h2>Upload Dokumen PDF</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">

                <!-- File PDF -->
                <div class="mb-3">
                    <label for="pdf_file">File PDF</label>
                    <input type="file" name="pdf_file" id="pdf_file" class="form-control" required>
                </div>

                <!-- Tipe Dokumen -->
                <div class="mb-3">
                    <label for="tipe_dokumen">Tipe Dokumen</label>
                    <select name="tipe_dokumen" id="tipe_dokumen" class="form-control">
                        {{-- nanti ambil dari DB --}}
                        <option value="Peraturan">Peraturan</option>
                        <option value="Keputusan">Keputusan</option>
                    </select>
                </div>

                <!-- Bidang Hukum -->
                <div class="mb-3">
                    <label for="bidang_hukum">Bidang Hukum</label>
                    <select name="bidang_hukum" id="bidang_hukum" class="form-control">
                        {{-- ambil dari DB --}}
                        <option value="Pidana">Pidana</option>
                        <option value="Perdata">Perdata</option>
                    </select>
                </div>

                <!-- Jenis Hukum -->
                <div class="mb-3">
                    <label for="jenis_hukum">Jenis Hukum</label>
                    <select name="jenis_hukum" id="jenis_hukum" class="form-control">
                        {{-- ambil dari DB --}}
                        <option value="UU">Undang-Undang</option>
                        <option value="PP">Peraturan Pemerintah</option>
                    </select>
                </div>

                <!-- Jenis Dokumen -->
                <div class="mb-3">
                    <label for="jenis_dokumen">Jenis Dokumen</label>
                    <select name="jenis_dokumen" id="jenis_dokumen" class="form-control">
                        {{-- ambil dari DB --}}
                        <option value="Keputusan Direktur">Keputusan Direktur</option>
                        <option value="Peraturan Gubernur">Peraturan Gubernur</option>
                        <option value="Perizinan">Perizinan</option>
                        <option value="SOP">SOP</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="singkatan">Singkatan</label>
                    <input type="text" name="singkatan" id="singkatan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="nomor">Nomor</label>
                    <input type="text" name="nomor" id="nomor" class="form-control" required>
                </div>

                <!-- Tahun -->
                <div class="mb-3">
                    <label for="tahun">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        @for ($i = date('Y'); $i >= 1945; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Judul -->
                <div class="mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" required>
                </div>

                <!-- TEU Badan -->
                <div class="mb-3">
                    <label for="teu_badan">TEU Badan</label>
                    <input type="text" name="teu_badan" id="teu_badan" class="form-control">
                </div>

                <!-- Tempat Penetapan -->
                <div class="mb-3">
                    <label for="tempat_penetapan">Tempat Penetapan</label>
                    <input type="text" name="tempat_penetapan" id="tempat_penetapan" class="form-control">
                </div>

            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">

                <!-- Tanggal Penetapan -->
                <div class="mb-3">
                    <label for="tanggal_penetapan">Tanggal Penetapan</label>
                    <input type="date" name="tanggal_penetapan" id="tanggal_penetapan" class="form-control">
                </div>

                <!-- Tanggal Pengundangan -->
                <div class="mb-3">
                    <label for="tanggal_pengundangan">Tanggal Pengundangan</label>
                    <input type="date" name="tanggal_pengundangan" id="tanggal_pengundangan" class="form-control">
                </div>

                <!-- Sumber -->
                <div class="mb-3">
                    <label for="sumber">Sumber</label>
                    <input type="text" name="sumber" id="sumber" class="form-control">
                </div>

                <!-- Subjek -->
                <div class="mb-3">
                    <label for="subjek">Subjek</label>
                    <input type="text" name="subjek" id="subjek" class="form-control">
                </div>

                <!-- Bahasa -->
                <div class="mb-3">
                    <label for="bahasa">Bahasa</label>
                    <input type="text" name="bahasa" id="bahasa" class="form-control" value="Indonesia">
                </div>

                <!-- Lokasi -->
                <div class="mb-3">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control">
                </div>

                <!-- Urusan Pemerintahan -->
                <div class="mb-3">
                    <label for="urusan_pemerintahan">Urusan Pemerintahan</label>
                    <input type="text" name="urusan_pemerintahan" id="urusan_pemerintahan" class="form-control">
                </div>

                <!-- Penandatanganan -->
                <div class="mb-3">
                    <label for="penandatanganan">Penandatanganan</label>
                    <input type="text" name="penandatanganan" id="penandatanganan" class="form-control">
                </div>

                <!-- Pemrakarsa -->
                <div class="mb-3">
                    <label for="pemrakarsa">Pemrakarsa</label>
                    <input type="text" name="pemrakarsa" id="pemrakarsa" class="form-control">
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="berlaku">Berlaku</option>
                        <option value="tidak berlaku">Tidak Berlaku</option>
                    </select>
                </div>

                <!-- QR Code -->
                <div class="mb-3">
                    <label for="qrcode">QR Code</label>
                    <input type="text" name="qrcode" id="qrcode" class="form-control">
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
