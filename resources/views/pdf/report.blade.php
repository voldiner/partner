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
        .table-list{
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }

    </style>
</head>
<body>
<h2>{{ $report->station->name }}</h2>
<h2>Відомість № {{ $report-> }}</h2>
<h2>продажу квитків на рейс № {{ $report-> }}</h2>
<h3>{{ $report-> }}</h3>
<p>час відправлення {{  }}</p>
<p>Дата {{ $report-> }}</p>
<p>Перевізник: {{ $report->user->full_name }}</p>




<p>Обрано {{ $countReports }} відомостей згідно умов пошуку:</p>
<p>
    @if($stationsSelected || $numberReport || $sum_report || $dateStart || $dateFinish)

        @if($dateStart && $dateFinish)
            <span>Період: {{ $dateStart->format('d.m.Y') }} по {{ $dateFinish->format('d.m.Y') }}</span>
        @endif
        @if($stationsSelected)
            @foreach($stationsSelected as $stationSelected)
                <span>{{ $stationSelected->name }}</span>
            @endforeach
        @endif
        @if($numberReport)
            <span>номер: {{ $numberReport }}</span>
        @endif
        @if($sum_report)
            <span>сума: {{ $sum_report }}</span>
        @endif
    @endif
</p>

<div>
    <table border="1" cellspacing="0" class="table-list">
        <thead>
        <tr>
            <th>#</th>
            <th>Дата</th>
            <th>Автостанція</th>
            <th>Номер відомості</th>
            <th class="suma">Сума</th>
            <th class="suma">Страховий збір</th>
            <th class="suma">Багаж</th>
            <th class="suma">Сума без страх збору</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_tariff = 0;
            $total_insurance = 0;
            $total_baggage = 0;
        @endphp
        @foreach($reports as $report)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $report->date_flight->format('d-m-Y') }}</td>
                <td>{{ $report->station->name }}</td>
                <td>{{ $report->num_report }}</td>
                <td>{{ $report->sum_tariff }}</td>
                <td>{{ $report->sum_insurance }}</td>
                <td>{{ $report->sum_baggage }}</td>
                <td>{{ $report->sum_tariff - $report->sum_insurance }}</td>
            </tr>
            @php
                $total_tariff += $report->sum_tariff ;
                $total_insurance += $report->sum_insurance;
                $total_baggage += $report->sum_baggage;
            @endphp
        @endforeach
        <tr>
            <td colspan="4">Всього:</td>
            <td>{{ $total_tariff }}</td>
            <td>{{ $total_insurance }}</td>
            <td>{{ $total_baggage }}</td>
            <td>{{ $total_tariff - $total_insurance }}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>