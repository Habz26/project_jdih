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
    protected $description = 'Send document reminders (dry-run to log)';

    public function handle()
    {
        $today = Carbon::now('Asia/Jakarta');
        // Ambil dokumen yang sudah diverifikasi
        $documents = Document::where('status_verifikasi', 2)
            ->whereBetween('tanggal_penetapan', [$today->copy()->subMonths(6), $today->copy()->subMonth()])
            ->get();

        foreach ($documents as $document) {
            // Hitung selisih bulan (absolute)
            $monthsLeft = Carbon::parse($document->tanggal_penetapan)->diffInMonths($today, false); // tetap hitung selisih bulan

            $monthsLeft = (int) round($monthsLeft); // pastikan bulat

            // Ambil teks human-readable, misal "3 bulan lagi" atau "1 bulan lagi"
            if ($monthsLeft < 0) {
                $monthsText = abs($monthsLeft) . ' bulan yang lalu';
            } elseif ($monthsLeft > 0) {
                $monthsText = $monthsLeft . ' bulan lagi';
            } else {
                $monthsText = 'bulan ini';
            }

            Mail::to('test@example.com')->send(new DocumentReminderMail($document, $monthsText));
            $this->info("Logged reminder for '{$document->judul}' ({$monthsText})");
        }

        $this->info('Dry-run reminders completed. Check storage/logs/laravel.log for email content.');
    }
}
