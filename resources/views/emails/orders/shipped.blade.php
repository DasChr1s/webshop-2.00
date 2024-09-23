@component('mail::message')
# Bestellung Bestätigt

Danke für Ihre Bestellung!

**Bestell-ID:** {{ $order->id }}
**Name:** {{ $order->name }}
**Gesamtpreis:** {{ $order->total_price }}

@component('mail::table')
| Produkt       | Menge  | Preis   |
| ------------- | ------ | ------- |
@foreach ($order->orderItems as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | {{ $item->price }} |
@endforeach
@endcomponent

Danke,<br>
Ihr Cat n Nap
@endcomponent
