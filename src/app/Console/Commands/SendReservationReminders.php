<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminder;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'reminder:send';
    protected $description = '当日予約者にリマインダーメールを送信';

    public function handle()
    {
        $today = Carbon::today();

        // 今日の予約を取得
        $reservations = Reservation::with('user', 'shop')->whereDate('reserved_date', $today)->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)->send(new ReservationReminder($reservation));
        }

        $this->info('当日予約のユーザーにメール送信が完了しました。');
    }
}