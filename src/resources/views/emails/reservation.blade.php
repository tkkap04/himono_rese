<!DOCTYPE html>
<html>
    <head>
        <title>下記内容で予約が完了しました。</title>
    </head>
    <body>
        <p>■店名：{{ $reservation->shop->name }}</p>
        <p>■予約人数：{{ $reservation->number_of_people }}人</p>
        <p>■予約時間：{{ \Carbon\Carbon::parse($reservation->date)->format('m月d日') }} {{ $reservation->time }}</p>
        <p>■QRコード：添付のQRコードをお店に提示してください。</p>
        <img src="{{ $message->embed($qrCodePath) }}" style="width:66%; max-width:300px;" alt="QRコード">
    </body>
</html>
