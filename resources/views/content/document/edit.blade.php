@extends('layouts.layoutMaster')

@section('title', 'Selects and tags - Forms')

<!-- Vendor Styles -->
@section('vendor-style')
  @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/tagify/tagify.scss', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss', 'resources/assets/vendor/libs/typeahead-js/typeahead.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/typeahead-js/typeahead.js', 'resources/assets/vendor/libs/bloodhound/bloodhound.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
  @vite(['resources/assets/js/forms-selects.js', 'resources/assets/js/forms-tagify.js', 'resources/assets/js/forms-typeahead.js'])
@endsection

@section('content')

@section('content')
    <div class="container">
        <h2>Edit Dokumen</h2>
        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @section('scripts')
<script>
  $(document).ready(function() {
    $('#jenis_dokumen').select2({
      placeholder: "Pilih Jenis Dokumen",
      allowClear: true,
      width: '100%'
    });
  });
</script>
@endsection

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
    <label for="jenis_dokumen">Jenis Dokumen</label>
    <select name="jenis_dokumen" id="jenis_dokumen" class="form-control">
        <option value="Peraturan Gubernur" {{ $document->jenis_dokumen == 'Peraturan Gubernur' ? 'selected' : '' }}>Peraturan Gubernur</option>
        <option value="Keputusan Gubernur" {{ $document->jenis_dokumen == 'Keputusan Gubernur' ? 'selected' : '' }}>Keputusan Gubernur</option>
        <option value="Peraturan Direktur" {{ $document->jenis_dokumen == 'Peraturan Direktur' ? 'selected' : '' }}>Peraturan Direktur</option>
        <option value="Keputusan Direktur" {{ $document->jenis_dokumen == 'Keputusan Direktur' ? 'selected' : '' }}>Keputusan Direktur</option>
        <option value="Perizinan" {{ $document->jenis_dokumen == 'Perizinan' ? 'selected' : '' }}>Perizinan</option>
        <option value="SOP" {{ $document->jenis_dokumen == 'SOP' ? 'selected' : '' }}>SOP</option>
    </select>
</div>


                    <div class="mb-3">
                        <label for="singkatan">Singkatan</label>
                        <input type="text" name="singkatan" id="singkatan" class="form-control"
                            value="{{ old('singkatan', $document->singkatan) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nomor">Nomor</label>
                        <input type="text" name="nomor" id="nomor" class="form-control"
                            value="{{ old('nomor', $document->nomor) }}" required>
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
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
