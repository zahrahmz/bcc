<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <style type="text/css" media="print">
        @page {
            size: portrait;
            margin: 0px ;
            page-break-after: always;
            page-break-inside: avoid;
        }
        html * {
            font-family: IRANYekanWebFn !important;
        }

    </style>
    <style>
        .container {
            margin: auto !important;
            width: 100% !important;
        }

        body {
            -webkit-print-color-adjust: exact !important;
            margin: 15px !important;
        }

        #table {

            font-family: IRANYekanWeb !important;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 40px;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even){background-color: #f2f2f2;}

        #table tr:hover {background-color: #ddd;}

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        #table > tbody > tr:nth-child(3) > td:nth-child(1){
            border-bottom: none;
            border-right: none;
        }

    </style>
</head>
<body>
<div class="container " style="direction: rtl; margin-top:147px">
    <div class="row shadow-box" style="margin-bottom: 20px !important; padding:5px !important">
        <p style="font-size: 20px;" >سفارشات</p>
        <table id="table">
            <tbody>
            <tr>
                <th style="width: 10px">ردیف</th>
                <th>نام کالا</th>
                <th>سایز</th>
                <th>تعداد</th>
                <th>مبلغ</th>
                <th>مبلغ نهایی</th>
            </tr>
            @foreach($order->orderItems as $index => $eachOrder)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $eachOrder->product_name }}</td>
                    <td>{{ $eachOrder->product_size }}</td>
                    <td>{{ $eachOrder->quantity }}</td>
                    <td class="ttt">{{ number_format($eachOrder->product_price) }}</td>
                    <td>{{ number_format($eachOrder->product_price * $eachOrder->quantity)  }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" rowspan="3"></td>
                <td class="text-bold">جمع مبالغ</td>
                <td>{{ number_format($total->totalPrice) }}</td>
                <td>{{ number_format($total->totalFinalPrice) }}</td>
            </tr>
            <tr>
                <td class="text-bold" colspan="2">هزینه ارسال</td>
                <td colspan="3">{{ number_format($eachOrder->shipment_type_price) }}</td>
            </tr>
            <tr>
                <td class="text-bold" colspan="2">مبلغ پرداختی</td>
                <td colspan="3">{{ $payment->successfulPaymentAmout ?? 0 }}</td>
            </tr>
            </tbody>
        </table>

        <p style="font-size: 20px;">اطلاعات ارسال</p>
        <table id="table">
            <tbody>
            <tr>
                <td style="width: 100px;" class="text-bold">نام گیرنده</td>
                <td colspan="3">{{ $order->name_of_receiver }}</td>
            </tr>
            <tr>
                <td class="text-bold">موبایل</td>
                <td>{{ $order->phone }}</td>
                <td class="text-bold">موبایل 2</td>
                <td>{{ $order->user->mobile }}</td>
            </tr>
            <tr>
                <td class="text-bold">استان</td>
                <td>{{ $order->province }}</td>
                <td class="text-bold">شهر</td>
                <td>{{ $order->city }}</td>
            </tr>
            <tr>
                <td class="text-bold">آدرس</td>
                <td colspan="3">{{ $order->address }}</td>
            </tr>
            <tr>
                <td class="text-bold">نحوه ارسال</td>
                <td>{{ $order->shipment_type_name }}</td>
                <td class="text-bold">زمان ارسال</td>
                <td></td>
            </tr>
            </tbody>
        </table>

        <p style="font-size: 20px;">اطلاعات پرداخت</p>
        <table id="table">
            <tbody>
            <tr>
                <th style="width: 10px">ردیف</th>
                <th>نام درگاه</th>
                <th>شماره پیگیری</th>
                <th>نتیجه پرداخت</th>
                <th>مبلغ</th>
            </tr>
            @foreach($order->payments as $index => $eachPayment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $eachPayment->bank_name }}</td>
                    <td>{{ $eachPayment->sale_reference_id ?? 'ندارد' }}</td>
                    <td>{{ $eachPayment->res_string }}</td>
                    <td>{{ number_format($eachPayment->total_order_price) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>
</div>

</body>
</html>
