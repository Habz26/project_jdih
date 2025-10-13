@extends('layouts.layoutMaster')

@section('title', 'Edit Dokumen')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/tagify/tagify.scss', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss', 'resources/assets/vendor/libs/typeahead-js/typeahead.scss'])
@endsection


@section('page-script')
    <script>
        $(document).ready(function() {
            $('.keterangan-select').select2({
                placeholder: 'Cari judul dokumen...',
                ajax: {
                    url: "{{ route('ajax.judul') }}", // route ambil data judul
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
                                    id: item.id, // simpan ID dokumen
                                    text: item.text // tampilkan Judul dokumen
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            function toggleKeteranganFields() {
                var status = $('#status').val(); // ambil nilai status (0/1/2)

                if (status === '2') {
                    // Berlaku → hide
                    $('#keterangan_dokumen').closest('.mb-3').hide();
                    $('#keterangan').closest('.mb-3').hide();
                } else {
                    // Tidak Berlaku atau Berlaku Sebagian → show
                    $('#keterangan_dokumen').closest('.mb-3').show();
                    $('#keterangan').closest('.mb-3').show();
                }
            }

            // Panggil pertama kali saat halaman load
            toggleKeteranganFields();

            // Jalankan ulang setiap kali status berubah
            $('#status').on('change', function() {
                toggleKeteranganFields();
            });
        });

        // Toggle Periode Berlaku jika jenis_dokumen = 5
        function togglePeriodeBerlaku() {
            let jenis = $('#jenis_dokumen').val();
            if (jenis === '5') { // Perizinan
                $('#periode_berlaku_wrapper').show();
                $('#periode_berlaku').prop('required', true);
            } else {
                $('#periode_berlaku_wrapper').hide();
                $('#periode_berlaku').prop('required', false);
            }
        }

        // Jalankan saat halaman load
        togglePeriodeBerlaku();

        // Event saat jenis_dokumen berubah
        $('#jenis_dokumen').on('change', togglePeriodeBerlaku);
    </script>
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
                        <label for="tipe_dokumen">Tipe Dokumen</label>
                        <select name="tipe_dokumen" id="tipe_dokumen" class="form-control">
                            <option value="Peraturan Perundang-Undangan"
                                {{ old('tipe_dokumen', $document->tipe_dokumen) == 'Peraturan Perundang-Undangan' ? 'selected' : '' }}>
                                Peraturan Perundang-Undangan</option>
                            <option value="Lainnya"
                                {{ old('tipe_dokumen', $document->tipe_dokumen) == 'Lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bidang_hukum">Bidang Hukum</label>
                        <select name="bidang_hukum" id="bidang_hukum" class="form-control">
                            <option value="Pidana"
                                {{ old('bidang_hukum', $document->bidang_hukum) == 'Pidana' ? 'selected' : '' }}>Pidana
                            </option>
                            <option value="Perdata"
                                {{ old('bidang_hukum', $document->bidang_hukum) == 'Perdata' ? 'selected' : '' }}>Perdata
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_hukum">Jenis Hukum</label>
                        <select name="jenis_hukum" id="jenis_hukum" class="form-control">
                            <option value="Undang-Undang"
                                {{ old('jenis_hukum', $document->jenis_hukum) == 'Undang-Undang' ? 'selected' : '' }}>
                                Undang-Undang</option>
                            <option value="Peraturan-Pemerintah"
                                {{ old('jenis_hukum', $document->jenis_hukum) == 'Peraturan-Pemerintah' ? 'selected' : '' }}>
                                Peraturan-Pemerintah</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_dokumen">Jenis Dokumen</label>
                        <select name="jenis_dokumen" id="jenis_dokumen" class="form-control">
                            <option value="1"
                                {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Peraturan Gubernur' ? 'selected' : '' }}>
                                Peraturan Gubernur</option>
                            <option value="2"
                                {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Keputusan Gubernur' ? 'selected' : '' }}>
                                Keputusan Gubernur</option>
                            <option value="3"
                                {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Peraturan Direktur' ? 'selected' : '' }}>
                                Peraturan Direktur</option>
                            <option value="4"
                                {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Keputusan Direktur' ? 'selected' : '' }}>
                                Keputusan Direktur</option>
                            <option value="5"
                                {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Perizinan' ? 'selected' : '' }}>
                                Perizinan</option>
                            <option value="6"
                                {{ old('jenis_dokumen', $document->jenis_dokumen) == 'SOP' ? 'selected' : '' }}>SOP
                            </option>
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
                                <option value="{{ $i }}"
                                    {{ (int) old('tahun', $document->tahun) === $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control"
                            value="{{ old('judul', $document->judul) }}" required>
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

                    <div class="mb-3" id="periode_berlaku_wrapper" style="display: none;">
                        <label for="periode_berlaku">Periode Berlaku</label>
                        <select name="periode_berlaku" id="periode_berlaku" class="form-control">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}"
                                    {{ old('periode_berlaku', $document->periode_berlaku ?? '') == $i ? 'selected' : '' }}>
                                    {{ $i }} Tahun
                                </option>
                            @endfor
                        </select>
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

                    <div class="mb-3" id="keterangan_dokumen_wrapper">
                        <label for="keterangan_dokumen" class="form-label">Keterangan Status</label>
                        <input type="text" name="keterangan_dokumen" id="keterangan_dokumen" class="form-control"
                            value="{{ old('keterangan_dokumen', $document->keterangan_dokumen ?? '') }}">
                    </div>


                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Dokumen Perubahan</label>
                        <select name="keterangan_id" id="keterangan" class="form-control select2">
                            <option value="">-- Pilih Dokumen --</option>
                            @foreach ($documents as $doc)
                                <option value="{{ $doc->id }}"
                                    {{ old('keterangan_id', $document->keterangan_id ?? '') == $doc->id ? 'selected' : '' }}>
                                    {{ $doc->judul }} ({{ $doc->tahun }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    </form>
    </div>
@endsection
