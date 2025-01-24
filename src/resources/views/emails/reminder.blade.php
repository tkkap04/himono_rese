<!DOCTYPE html>
<html>
    <head>
        <title>予約リマインダー</title>
    </head>
    <body>
        <p>{{ $reservation->user->name }}さん、本日のご予約内容です。</p>
        <p>店舗名: {{ $reservation->shop->name }}</p>
        <p>日時: {{ $reservation->date }} {{ $reservation->time }}</p>
        <p>人数: {{ $reservation->number_of_people }}人</p>
    </body>
</html>
