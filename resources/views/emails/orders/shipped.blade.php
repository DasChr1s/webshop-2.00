<!DOCTYPE html>
<html>
<head>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc;">
        <h1 style="text-align: center; color: #333;">Bestellung Bestätigt</h1>

        <p>Danke für Ihre Bestellung!</p>

        <p><strong>Bestell-ID:</strong> {{ $order->id }}</p>
        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Gesamtpreis:</strong> {{ $order->total_price }}</p>

        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #f8f8f8;">
                <th style="padding: 10px; border: 1px solid #ccc;">Produkt</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Menge</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Preis</th>
            </tr>
            @foreach ($order->items as $item)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $item->product->name }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $item->price }}</td>
                </tr>
            @endforeach
        </table>

        <p style="text-align: center;">Danke,<br>Ihr Cat n Nap</p>
    </div>
</body>
</html>