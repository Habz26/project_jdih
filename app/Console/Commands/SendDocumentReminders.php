<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentReminderMail;
use App\Models\Document;
use Carbon\Carbon;

class SendDocumentReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send document reminders (6 months before period expires)';

    public function handle()
    {
        $today = Carbon::now('Asia/Jakarta');

        // Ambil dokumen Perizinan yang diverifikasi
        $documents = Document::where('jenis_dokumen', 5)->where('status_verifikasi', 2)->get();

        foreach ($documents as $document) {
            // Pastikan ada periode_berlaku
            if (!$document->periode_berlaku) {
                continue;
            }
            // Hitung tanggal expired dokumen
            $expiredAt = Carbon::parse($document->tanggal_penetapan)->addYears($document->periode_berlaku);

            // Hitung tanggal reminder: 6 bulan sebelum expired
            $reminderAt = $expiredAt->copy()->subMonths(6);

            // Cek apakah reminder harus dikirim hari ini
            if ($today->isSameDay($reminderAt)) {
                // Hitung sisa bulan sampai expired
                $monthsLeft = $today->diffInMonths($expiredAt, false);
                $monthsLeft = (int) round($monthsLeft);

                // Buat teks human-readable
                if ($monthsLeft < 0) {
                    $monthsText = 'sudah expired ' . abs($monthsLeft) . ' bulan yang lalu';
                } elseif ($monthsLeft > 0) {
                    $monthsText = 'akan expired ' . $monthsLeft . ' bulan lagi';
                } else {
                    $monthsText = 'akan expired bulan ini';
                }

                Mail::to('test@example.com')->send(new DocumentReminderMail($document, $monthsText));
                $this->info("Reminder sent for '{$document->judul}' ({$monthsText})");
            }
        }

        $this->info('Reminders check completed.');
    }
}
