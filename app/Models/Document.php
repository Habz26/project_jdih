<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'pdf_file',
        'tipe_dokumen',
        'bidang_hukum',
        'jenis_hukum',
        'jenis_dokumen',
        'singkatan',
        'nomor',
        'tahun',
        'judul',
        'tempat_penetapan',
        'tanggal_penetapan',
        'tanggal_pengundangan',
        'sumber',
        'subjek',
        'bahasa',
        'lokasi',
        'urusan_pemerintahan',
        'penandatanganan',
        'pemrakarsa',
        'status',
        'keterangan',
        'keterangan_dokumen',
    ];

    // app/Models/Document.php
    public function jenisDokumenRef()
    {
        return $this->belongsTo(Referensi::class, 'jenis_dokumen', 'id')
                    ->where('jenis', 1); // ganti 2 sesuai kode jenis dokumen di tabel referensi
    }
    public function statusDokumenRef()
    {
        return $this->belongsTo(Referensi::class, 'status', 'id')
                    ->where('jenis', 2); // ganti 3 sesuai kode jenis status di tabel referensi
    }   
}