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

        $documents = Document::where('status_verifikasi', 2)
            ->whereBetween('tanggal_penetapan', [$today->copy()->subMonths(6), $today->copy()->subMonth()])
            ->get();

        foreach ($documents as $document) {
            $monthsLeft = $today->diffInMonths(Carbon::parse($document->tanggal_penetapan), false);

            if ($monthsLeft <= -1 && $monthsLeft >= -6) {
                Mail::to('test@example.com')->send(new DocumentReminderMail($document, abs($monthsLeft)));
                $this->info("Logged reminder for '{$document->judul}' (terlewat " . abs($monthsLeft) . ' bulan)');
            }
        }

        $this->info('Dry-run reminders completed. Check storage/logs/laravel.log for email content.');
    }
}
