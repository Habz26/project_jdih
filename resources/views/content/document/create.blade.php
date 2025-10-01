@extends('layouts.layoutMaster')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: "Pilih opsi",
      allowClear: true,
      width: '100%'
    });
  });
</script>



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
                        <option value="Peraturan Perundang-Undangan">Peraturan Perundang-Undangan</option>
                        <option value="Lainnya">Lainnya</option>
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
                        <option value="Peraturan Gubernur">Peraturan Gubernur</option>
                         <option value="Keputusan Gubernur">Keputusan Gubernur</option> <!-- ✅ baru -->
                        <option value="Keputusan Direktur">Keputusan Direktur</option>
                          <option value="Peraturan Direktur">Peraturan Direktur</option> <!-- ✅ baru -->
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

                <!-- Keterangan (ganti QR Code) -->
            <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <select id="collapsible-state" class="select2 form-select" data-allow-clear="true">
                      <option value="">Select</option>
                      <option value="AL">Alabama</option>
                      <option value="AK">Alaska</option>
                      <option value="AZ">Arizona</option>
                      <option value="AR">Arkansas</option>
                      <option value="CA">California</option>
                      <option value="CO">Colorado</option>
                      <option value="CT">Connecticut</option>
                      <option value="DE">Delaware</option>
                      <option value="DC">District Of Columbia</option>
                      <option value="FL">Florida</option>
                      <option value="GA">Georgia</option>
                      <option value="HI">Hawaii</option>
                      <option value="ID">Idaho</option>
                      <option value="IL">Illinois</option>
                      <option value="IN">Indiana</option>
                      <option value="IA">Iowa</option>
                      <option value="KS">Kansas</option>
                      <option value="KY">Kentucky</option>
                      <option value="LA">Louisiana</option>
                      <option value="ME">Maine</option>
                      <option value="MD">Maryland</option>
                      <option value="MA">Massachusetts</option>
                      <option value="MI">Michigan</option>
                      <option value="MN">Minnesota</option>
                      <option value="MS">Mississippi</option>
                      <option value="MO">Missouri</option>
                      <option value="MT">Montana</option>
                      <option value="NE">Nebraska</option>
                      <option value="NV">Nevada</option>
                      <option value="NH">New Hampshire</option>
                      <option value="NJ">New Jersey</option>
                      <option value="NM">New Mexico</option>
                      <option value="NY">New York</option>
                      <option value="NC">North Carolina</option>
                      <option value="ND">North Dakota</option>
                      <option value="OH">Ohio</option>
                      <option value="OK">Oklahoma</option>
                      <option value="OR">Oregon</option>
                      <option value="PA">Pennsylvania</option>
                      <option value="RI">Rhode Island</option>
                      <option value="SC">South Carolina</option>
                      <option value="SD">South Dakota</option>
                      <option value="TN">Tennessee</option>
                      <option value="TX">Texas</option>
                      <option value="UT">Utah</option>
                      <option value="VT">Vermont</option>
                      <option value="VA">Virginia</option>
                      <option value="WA">Washington</option>
                      <option value="WV">West Virginia</option>
                      <option value="WI">Wisconsin</option>
                      <option value="WY">Wyoming</option>
                    </select>
                    <label for="collapsible-state">State</label>
</div>          


            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
