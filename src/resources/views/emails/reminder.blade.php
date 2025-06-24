@component('mail::message')
# 本日のご予約リマインダー

{{ $reservation->user->name }} 様

以下の内容でご予約いただいています：

- 店舗名：{{ $reservation->shop->name }}
- ご来店日時：{{ \Carbon\Carbon::parse($reservation->reserved_date . ' ' . $reservation->reserved_time)->format('Y-m-d H:i') }}
- ご予約人数：{{ $reservation->number_of_people }}名

ご来店をお待ちしております！

@endcomponent