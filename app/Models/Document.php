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
        'teu_badan',
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
        'qrcode',
    ];
}
