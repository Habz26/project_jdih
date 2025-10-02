@extends('layouts.layoutMaster')

@section('title', 'Tambah Dokumen')

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
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk Keterangan
            $('.keterangan-select').select2({
                placeholder: 'Cari judul dokumen...',
                ajax: {
                    url: "{{ route('ajax.judul') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            });

            // Toggle keterangan sesuai status
            function toggleKeterangan() {
                let status = $('#status').val();
                if (status === '2') { // Berlaku
                    $('.keterangan-status-wrapper, .keterangan-wrapper').hide();
                    $('#keterangan_dokumen').prop('required', false);
                    $('#keterangan').prop('required', false);
                } else {
                    $('.keterangan-status-wrapper, .keterangan-wrapper').show();
                    $('#keterangan_dokumen').prop('required', true);
                    $('#keterangan').prop('required', true);
                }
            }

            // Event saat status berubah
            $('#status').on('change', toggleKeterangan);

            // Jalankan sekali saat halaman load
            toggleKeterangan();
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <h2>Tambah Dokumen</h2>
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pdf_file">Upload File PDF</label>
                        <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_dokumen">Tipe Dokumen</label>
                        <select name="tipe_dokumen" id="tipe_dokumen" class="form-control">
                            <option value="Peraturan Perundang-Undangan">Peraturan Perundang-Undangan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bidang_hukum">Bidang Hukum</label>
                        <select name="bidang_hukum" id="bidang_hukum" class="form-control">
                            <option value="Pidana">Pidana</option>
                            <option value="Perdata">Perdata</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_hukum">Jenis Hukum</label>
                        <select name="jenis_hukum" id="jenis_hukum" class="form-control">
                            <option value="Undang-Undang">Undang-Undang</option>
                            <option value="Peraturan-Pemerintah">Peraturan-Pemerintah</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_dokumen">Jenis Dokumen</label>
                        <select name="jenis_dokumen" id="jenis_dokumen" class="form-control">
                            <option value="1">Peraturan Gubernur</option>
                            <option value="2">Keputusan Gubernur</option>
                            <option value="3">Peraturan Direktur</option>
                            <option value="4">Keputusan Direktur</option>
                            <option value="5">Perizinan</option>
                            <option value="6">SOP</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="singkatan">Singkatan</label>
                        <input type="text" name="singkatan" id="singkatan" class="form-control"
                            value="{{ old('singkatan') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nomor">Nomor</label>
                        <input type="text" name="nomor" id="nomor" class="form-control" value="{{ old('nomor') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            @for ($i = date('Y'); $i >= 1945; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="tempat_penetapan">Tempat Penetapan</label>
                        <input type="text" name="tempat_penetapan" id="tempat_penetapan" class="form-control"
                            value="{{ old('tempat_penetapan') }}">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_penetapan">Tanggal Penetapan</label>
                        <input type="date" name="tanggal_penetapan" id="tanggal_penetapan" class="form-control"
                            value="{{ old('tanggal_penetapan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pengundangan">Tanggal Pengundangan</label>
                        <input type="date" name="tanggal_pengundangan" id="tanggal_pengundangan" class="form-control"
                            value="{{ old('tanggal_pengundangan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="sumber">Sumber</label>
                        <input type="text" name="sumber" id="sumber" class="form-control"
                            value="{{ old('sumber') }}">
                    </div>

                    <div class="mb-3">
                        <label for="subjek">Subjek</label>
                        <input type="text" name="subjek" id="subjek" class="form-control"
                            value="{{ old('subjek') }}">
                    </div>

                    <div class="mb-3">
                        <label for="bahasa">Bahasa</label>
                        <input type="text" name="bahasa" id="bahasa" class="form-control"
                            value="{{ old('bahasa') }}">
                    </div>

                    <div class="mb-3">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control"
                            value="{{ old('lokasi') }}">
                    </div>

                    <div class="mb-3">
                        <label for="urusan_pemerintahan">Urusan Pemerintahan</label>
                        <input type="text" name="urusan_pemerintahan" id="urusan_pemerintahan" class="form-control"
                            value="{{ old('urusan_pemerintahan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="penandatanganan">Penandatanganan</label>
                        <input type="text" name="penandatanganan" id="penandatanganan" class="form-control"
                            value="{{ old('penandatanganan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="pemrakarsa">Pemrakarsa</label>
                        <input type="text" name="pemrakarsa" id="pemrakarsa" class="form-control"
                            value="{{ old('pemrakarsa') }}">
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="2" {{ old('status', $document->status ?? '') == '2' ? 'selected' : '' }}>
                                Berlaku</option>
                            <option value="0" {{ old('status', $document->status ?? '') == '0' ? 'selected' : '' }}>
                                Tidak Berlaku</option>
                            <option value="1" {{ old('status', $document->status ?? '') == '1' ? 'selected' : '' }}>
                                Berlaku Sebagian</option>
                        </select>
                    </div>

                    <div class="keterangan-status-wrapper mb-3">
                        <label for="keterangan_dokumen">Keterangan Status</label>
                        <input type="text" name="keterangan_dokumen" id="keterangan_dokumen" class="form-control"
                            value="{{ old('keterangan_dokumen') }}">
                    </div>

                    <div class="keterangan-wrapper mb-3">
                        <label for="keterangan" class="form-label">Keterangan (ambil dari Judul)</label>
                        <select name="keterangan" id="keterangan" class="form-control keterangan-select"
                            required></select>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
@endsection
