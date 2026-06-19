<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order Receipt</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .customer, .items, .totals {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .product-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .variant-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>OM ALI STORE</h2>
    <p>Order #{{ $order->order_code }}</p>
</div>

{{-- ================= CUSTOMER INFO ================= --}}
<div class="customer">
    <h3>Customer Info</h3>

    <p><b>Name:</b> {{ $order->customer_name }}</p>
    <p><b>Email:</b> {{ $order->customer_email ?? '-' }}</p>
    <p><b>Phone 1:</b> {{ $order->customer_phone1 }}</p>
    <p><b>Phone 2:</b> {{ $order->customer_phone2 ?? '-' }}</p>
    <p><b>Address:</b> {{ $order->address }}</p>
    <p><b>Governorate:</b> {{ $order->governorate->name ?? '-' }}</p>
</div>

{{-- ================= IMAGE FUNCTION ================= --}}
@php
    function imageToBase64($path)
    {
        if (!$path) return null;

        $fullPath = public_path('storage/' . $path);

        if (!file_exists($fullPath)) {
            return null;
        }

        $type = pathinfo($fullPath, PATHINFO_EXTENSION);
        $data = file_get_contents($fullPath);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
@endphp

{{-- ================= ITEMS ================= --}}
<div class="items">
    <h3>Order Items</h3>

    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>
        @foreach($order->items as $item)

            @php
                $variant = $item->variant;

                $image = $variant && $variant->image
                    ? imageToBase64($variant->image)
                    : imageToBase64($item->product->image);
            @endphp

            <tr>

                <td style="text-align:left;">

                    <div class="product-box">

                        @if($image)
                            <img src="{{ $image }}" class="product-img">
                        @endif

                        <div>

                            <div><b>{{ $item->product->name }}</b></div>

                            @if($variant)
                                <div>
                                    <span class="variant-color"
                                          style="background: {{ $variant->color_code }}"></span>
                                    {{ $variant->color_name }}
                                </div>
                            @endif

                        </div>

                    </div>

                </td>

                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} EGP</td>
                <td>{{ number_format($item->total, 2) }} EGP</td>

            </tr>

        @endforeach
        </tbody>
    </table>
</div>

{{-- ================= TOTALS ================= --}}
<div class="totals">

    <p><b>Subtotal:</b> {{ number_format($order->items->sum('total'), 2) }} EGP</p>

    <p><b>Shipping:</b> {{ number_format($order->shipping_cost, 2) }} EGP</p>

    <h3>
        Total: {{ number_format($order->total_price, 2) }} EGP
    </h3>

</div>

<div class="footer">
    Thank you for shopping with OM ALI ❤
</div>

</body>
</html>