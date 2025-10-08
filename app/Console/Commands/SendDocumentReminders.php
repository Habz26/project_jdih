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
        $today = Carbon::now();

        $documents = Document::all(); // bisa filter sesuai kebutuhan
        foreach ($documents as $document) {

            $date = Carbon::parse($document->tanggal_penetapan);
            $monthsLeft = $today->diffInMonths($date, false);

            // Kirim email cuma kalau sisa bulan 6 → 1
            $monthsLeft = $today->diffInMinutes($date, false);

$monthsLeft = $today->diffInMonths($date, false); // negatif kalau sudah lewat

// Kirim email kalau sisa bulan -6 s/d -1
if ($monthsLeft <= -1 && $monthsLeft >= -6) {
    Mail::to('test@example.com')->send(new DocumentReminderMail($document, abs($monthsLeft)));
    $this->info("Logged reminder for '{$document->judul}' (terlewat " . abs($monthsLeft) . " bulan)");
}



        }

        $this->info('Dry-run reminders completed. Check storage/logs/laravel.log for email content.');
    }
}
