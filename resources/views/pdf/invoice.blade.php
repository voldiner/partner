<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>report list</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }
        .suma {
            width: 80px;

        }
        .table-list {
            text-align: center;
        }
        .bigFont{
            font-size: 150%;
            font-weight: bold;
        }
        .smallFont{
            font-size: 80%;
        }
        .page-break {
            page-break-after: always;
        }
        .total{
            background-color: rgba(0,0,0,.05);
            font-weight: bold;
        }
        .pidpisLeft{
            float: left;
            width: 40%;
        }
        .pidpisRight{
            float: right;
            width: 40%;
        }
    </style>
</head>
<body>

<p style="font-size: 120%;"><b> А К Т № {{ $invoice->number }} від {{ $invoice->date_invoice->format('d.m.Y') }}</b></p>
<p>м. Луцьк</p>
<p>
    приймання-здачі виконаних робіт та звірки взаємних розрахунків станом на 1-е {{ $invoice->month_status  }}
    {{ $invoice->year_status }} року.
</p>
<p>
    Ми, що нижче підписалися, з однієї сторони ПрАТ "ВОПАС" та {{ $invoice->user->full_name }} з другої
    провели звірку взаємних розрахунків. При цьому встановлено наступне:
</p>
<p>
    Згідно реєстрів за {{ $monthsFromSelect[$invoice->month ] }} {{ $invoice->year }} року за пасажирські
    перевезення автобусами Вашого автопідприємства по відомостях касової продажі за даними ПрАТ "ВОПАС":
</p>
<p style="font-size: 120%">
    <b> Залишок на початок місяця: {{ number_format($invoice->balance_begin, 2, '.', ' ')  }}</b>
</p>

@if($invoice->products->count())
    @php
        $total = [0 , 0, 0, 0];
    @endphp
    <table border="1" cellspacing="0">
        <thead>
        <tr style="background-color: rgba(0,0,0,.05);">
            <th>Автостанція</th>
            <th>Сума реалізації</th>
            <th>Сума багаж</th>
            <th>Сума страховий збір</th>
            <th>Всього</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $invoice->products as $product)
            <tr>
                <td>{{ $product->station->name}}</td>
                <td>{{ number_format($product->sum_tariff, 2, '.', ' ') }}</td>
                <td>{{ $product->sum_baggage }}</td>
                <td>{{ number_format($product->sum_insurance, 2, '.', ' ') }}</td>
                <td>{{ number_format($product->sum_tariff + $product->sum_baggage - $product->sum_insurance, 2, '.', ' ') }}</td>
            </tr>
            @php
                $total[0] += $product->sum_tariff;
                $total[1] += $product->sum_baggage;
                $total[2] += $product->sum_insurance;
                $total[3] += $product->sum_tariff + $product->sum_baggage - $product->sum_insurance;
            @endphp
        @endforeach
        <tr class="total">
            <td>Разом:</td>
            <td>{{ number_format($total[0], 2, '.', ' ') }}</td>
            <td>{{ number_format($total[1], 2, '.', ' ') }}</td>
            <td>{{ number_format($total[2], 2, '.', ' ') }}</td>
            <td>{{ number_format($total[3], 2, '.', ' ') }}</td>
        </tr>
        </tbody>
    </table>
@endif
<table class="table table-sm">
    <tbody>
    @if($invoice->calculation_for_billing > 0)
        <tr>
            <td>Відрахування від виручки:</td>
            <td>{{ number_format($invoice->calculation_for_billing, 2, '.', ' ') }}</td>
        </tr>
    @endif
    @if($invoice->calculation_for_baggage > 0)
        <tr>
            <td>Відрахування від багажу:</td>
            <td>{{ number_format($invoice->calculation_for_baggage, 2, '.', ' ') }}</td>
        </tr>
    @endif
    @if($invoice->retention_for_collection > 0)
        <tr>
            <td>Утримано за інкасацію:</td>
            <td>{{ number_format($invoice->retention_for_collection, 2, '.', ' ') }}</td>
        </tr>
    @endif
    @if($invoice->sum_for_transfer  > 0)
        <tr class="total">
            <td>Сума до перерахування:</td>
            <td>{{ number_format($invoice->sum_for_transfer , 2, '.', ' ') }}</td>
        </tr>
    @endif
    @foreach($invoice->retentions as $retention)
        <tr>
            <td>{{ $retention->name }}:</td>
            <td>{{ number_format($retention->sum, 2, '.', ' ') }}</td>
        </tr>
    @endforeach
    @if($invoice->sum_month_transfer  > 0)
        <tr>
            <td>Перераховано за місяць:</td>
            <td>{{ number_format($invoice->sum_month_transfer , 2, '.', ' ') }}</td>
        </tr>
    @endif
    @if($invoice->get_cash  > 0)
        <tr>
            <td>Отримано з каси готівки:</td>
            <td>{{ number_format($invoice->get_cash , 2, '.', ' ') }}</td>
        </tr>
    @endif
    <tr class="total">
        <td>Залишок на кінець місяця:</td>
        <td>{{ number_format($invoice->balance_end , 2, '.', ' ') }}</td>
    </tr>
    </tbody>
</table>
<p>
    Залишок на кінець місяця за даними {{ $invoice->user->full_name }} ______________________
</p>
<p>
    Таким чином в результаті звірки взаєморозрахунків встановлено кінцеве сальдо
    @if($invoice->balance_for_who == 1)
        на користь ПрАТ "ВОПАС"
    @elseif($invoice->balance_for_who == 2)
        на користь {{ $invoice->user->full_name }}
    @endif
    в сумі {{ $invoice->getBalanceEnd() }}
</p>
<p>
    Цей акт складений в двох примірниках, кожен з яких має однакову силу.
</p>
<p>В чому і підписали акт: </p>

<div class="pidpisLeft">
    <p> {{ $invoice->user->full_name }}</p>
    @isset($invoice->user->address)
        <p class="mb-1">{{ $invoice->user->address }}</p>
    @endisset
    @exist($invoice->user->identifier)
    <p>Ідентифікаційний код {{ $invoice->user->identifier }}</p>
    @endexist
    @exist($invoice->user->certificate)
    <p>Номер свідоцтва {{ $invoice->user->certificate }}</p>
    @endexist
    @exist($invoice->user->certificate_tax)
    <p>Індивідуальний податковий номер {{ $invoice->user->certificate_tax }}</p>
    @endexist
    @exist($invoice->user->edrpou)
    <p>ЄДРПОУ {{ $invoice->user->edrpou }}</p>
    @endexist
    @exist($invoice->user->telephone)
    <p>тел. {{ $invoice->user->telephone }}</p>
    @endexist
    <p>
        Підпис ______________ {{ $invoice->user->surname }}
    </p>
</div>

<div class="pidpisRight">
    <p>
        Приватне акціонерне товариство "Волинське обласне підприємство
        автобусних станцій"
    </p>
    <p> м.Луцьк, вул. Львівська, 148</p>
    <p> код ЄДРПОУ 03113130</p>
    <p> ІПН 031131303172, свідоцтво № 100337934</p>
    <p> р/р UA63033980000026009300331234, Волинське ОУ АТ "Ощадбанк"</p>
    <p>
        Заст. гол.бухгалтера ______________ Боярська Н.В.
    </p>
</div>

</body>
</html>