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

    </style>
</head>
<body>
<h2>{{ $report->station->name }}</h2>
<h2>Відомість № {{ $report->num_report }} від {{ $report->date_flight->format('d.m.Y') }}</h2>
<h2>продажу квитків на рейс № {{ $report->kod_flight }}</h2>
<p> <span class="bigFont">{{ $report->name_flight }}</span> час відправлення <span class="bigFont">{{ $report->time_flight }}</span></p>
<p>Перевізник: <b>{{ $report->user->full_name }}</b></p>

<div>
    <table border="1" cellspacing="0" class="table-list">
        <thead>
        <tr>
            <th style="width: 60px;">Номер місця</th>
            <th>Номер квитка</th>
            <th>Зупинка</th>
            <th class="suma">Вартість квитка</th>
            <th style="width: 100px">Пільга</th>
        </tr>
        </thead>
        <tbody>

        @foreach($report->places as $place)
            <tr>
                <td>{{ $place->number_place }}</td>

                <td>{{ $place->ticket_id }}</td>
                <td>{{ $place->name_stop }}</td>
                <td>{{ $place->sum }}</td>
                @if($place->name_benefit )
                    <td><span class="smallFont">{{ $place->num_certificate }} {{ $place->name_benefit }} {{ $place->name_passenger }}</span></td>
                @else
                    <td></td>
                @endif
            </tr>

        @endforeach
        </tbody>
    </table>
    <p><b><u>Виручка від продажу:</u></b></p>
    <table class="table-list">
        <tbody>
        <tr>
            <td>Квитків</td>
            <td>{{ $total['countAll'] }}</td>
            <td>{{ number_format($total['sumAll'], 2, '.', '') }}</td>
        </tr>
        <tr>
            <td>в тому числі пільгових 50%</td>
            <td>{{ $total['count50'] }}</td>
            <td>{{ number_format($total['sum50'], 2, '.', '') }}</td>
        </tr>
        <tr>
            <td>в тому числі нульових</td>
            <td>{{ $total['count0'] }}</td>
            <td>{{ number_format($total['sum0'], 2, '.', '') }}</td>
        </tr>
        <tr>
            <td>Багажних квитків</td>
            <td></td>
            <td>{{ number_format($report->sum_baggage, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td>Страховий збір</td>
            <td></td>
            <td>{{ number_format($report->sum_insurance, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td colspan="3"><b><u>Продано квитків до:</u></b></td>
        </tr>
        @forelse($counted as $key => $count)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $count}}</td>
                <td></td>
            </tr>
        @empty
        @endforelse
        <tr class="bigFont">
            <td>Всього квитків:</td>
            <td>{{ $total['countAll'] }}</td>
            <td></td>
        </tr>
        <tr class="bigFont">
            <td>Сума:</td>
            <td>{{ number_format($total['sumAll'], 2, '.', '') }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>

</div>

</body>
</html>