@extends('admin.layouts.layout')
@section('title', 'Акти виконаних робіт')
@section('body_classes','hold-transition sidebar-mini')
@section('my_styles')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .total{
            background-color: rgba(0,0,0,.05);
            font-weight: bold;
        }
        #ajax{
            background-color: #fff;
            background-image: url("{{ asset('dist/img/preloader.gif') }}");
            background-position: center top;
            background-repeat: no-repeat;
            opacity: 0.8;
            border: 1px solid gray;
            border-radius: 10px;
            display: none;
            left: 50%;
            top: 50%;
            padding: 80px 10px 10px;
            position: fixed;
            text-align: center;
            /*width: 200px;*/
            vertical-align: bottom;
            z-index: 100;
        }
        #ajax span{
            font-size: 1.3rem;
            color: green;
        }
        .display-alert{
            display: block;
        }
        .no-display-alert{
            display: none;
        }
    </style>
@endsection
@section('content')
    <!-- Site wrapper -->
    <div class="wrapper">
    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- ajax -->
            <div id="ajax"></div>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Акти виконаних робіт</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Blank Page</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('partials.status_message')
                    @include('partials.validation_messages')
                    {{--<div class="row">--}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-gray">
                                <div class="card-header">
                                    <h3 class="card-title">Знайти відомості</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="display: block;">
                                    <form action="{{ route('manager.invoices.index') }}" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <!-- multiple -->
                                                <div class="form-group">
                                                    <label>Місяць</label>
                                                    <select id="category" name="months[]" class="select2" multiple="multiple"
                                                            data-placeholder="Виберіть місяць"
                                                            style="width: 100%;">
                                                            @foreach($monthsFromSelect as $key => $month)
                                                                @if(array_key_exists($key, $monthsSelected))
                                                                    <option value="{{ $key }}" selected>{{ $month }}</option>
                                                                @else
                                                                    <option value="{{ $key }}">{{ $month }}</option>
                                                                @endif
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-sm-3">
                                                <div class="form-group">
                                                    <label>Рік </label>
                                                    <input type="text" class="form-control @error('year') is-invalid @enderror" value="{{ old('year',$year) }}"id="year" name="year" placeholder="Рік документу">
                                                    @error('year')
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 col-6">
                                                <button id="btn-submit" class="btn btn-block btn-primary" type="submit">
                                                    Пошук
                                                </button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @if($monthsSelected || $year )
                                <div class="card card-gray rounded-pill">
                                    <div class="card-header rounded-pill">
                                        <p class="card-title">
                                            <a class="btn btn-danger btn-sm" href="{{ route('manager.invoices.index') }}">
                                                <i class="fas fa-trash">
                                                </i>
                                                Скасувати
                                            </a>
                                            <span class="mr-2 ml-2">Обрано {{ $countInvoices }} документів:</span>
                                            @if($monthsSelected)
                                                @foreach($monthsSelected as $month)
                                                    <span class="badge badge-warning mt-1" style="font-size: 100%;">{{ $month }}</span>
                                                @endforeach
                                            @endif
                                            @if($year)
                                                <span class="badge badge-warning mt-1" style="font-size: 100%;">рік: {{ $year }}</span>
                                            @endif
                                        </p>

                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- /.card-body -->
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-12">
                            @forelse ($invoices as $invoice)
                                <div class="card card-info collapsed-card mb-1">
                                    <div class="card-header">
                                        <div class="row justify-content-start">
                                            <div class="col-auto text-xl-left">
                                                <span style="margin-right: 15px;">{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}.</span>
                                                Акт виконаних робіт
                                            </div>
                                            <div class="col-auto text-left">
                                                # {{ $invoice->number }}
                                            </div>
                                            <div class="col-md-auto text-left">
                                                від {{ $invoice->date_invoice->format('d.m.Y') }}
                                            </div>
                                            <div class="col-auto text-left">
                                                на суму
                                            </div>
                                            <div class="col-auto">
                                                 {{ number_format($invoice->sum_for_transfer, 2, '.', ' ') }}
                                            </div>
                                            <div class="col-auto">
                                                <b>{{ $invoice->user->full_name }}</b>
                                            </div>

                                            <div class="card-tools col text-right">
                                                 <span class="icheck-primary">
                                                    <input type="checkbox" value="{{ $invoice->id }}" id="check{{ $loop->iteration }}" class="check-send">
                                                    <label for="check{{ $loop->iteration }}" class="mt-1"></label>
                                                 </span>
                                                <span class="badge badge-warning mt-1" style="font-size: 100%;">1</span>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        <div class="row">
                                            <div class="col-12">
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
                                            </div>
                                        </div>
                                        @if($invoice->products->count())
                                           @php
                                                    $total = [0 , 0, 0, 0];
                                           @endphp
                                           <div class="row">
                                               <div class="col-12">
                                                        <table class="table table-sm">
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
                                                    </div>
                                           </div>
                                        @endif
                                        <div class="row">
                                             <div class="col-6">
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
                                                        Залишок на кінець місяця за даними {{ $invoice->user->full_name }}  ______________________
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

                                                </div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col-md-4">
                                                    <p class="mb-1"> {{ $invoice->user->full_name }}</p>
                                                    @isset($invoice->user->address)
                                                        <p class="mb-1">{{ $invoice->user->address }}</p>
                                                    @endisset
                                                    @exist($invoice->user->identifier)
                                                        <p class="mb-1">Ідентифікаційний код {{ $invoice->user->identifier }}</p>
                                                    @endexist
                                                    @exist($invoice->user->certificate)
                                                        <p class="mb-1">Номер свідоцтва {{ $invoice->user->certificate }}</p>
                                                    @endexist
                                                    @exist($invoice->user->certificate_tax)
                                                        <p class="mb-1">Індивідуальний податковий номер  {{ $invoice->user->certificate_tax }}</p>
                                                    @endexist
                                                    @exist($invoice->user->edrpou)
                                                        <p class="mb-1">ЄДРПОУ {{ $invoice->user->edrpou }}</p>
                                                    @endexist
                                                    @exist($invoice->user->telephone)
                                                        <p class="mb-1">тел. {{ $invoice->user->telephone }}</p>
                                                    @endexist
                                                    <p>
                                                        Підпис ______________ {{ $invoice->user->surname }}
                                                    </p>
                                                    <p>
                                                        <a class="btn btn-success" id="pdf-list" href="{{ route('manager.invoices.show', $invoice->id) }}">
                                                            <i class="fas fa-download">
                                                            </i>
                                                            Друк PDF
                                                        </a>
                                                    </p>
                                                </div>
                                            <div class="col-md-4">
                                                <p class="mb-1">
                                                        Приватне акціонерне товариство "Волинське обласне підприємство
                                                        автобусних станцій"
                                                </p>
                                                <p class="mb-1"> м.Луцьк, вул. Львівська, 148</p>
                                                <p class="mb-1"> код ЄДРПОУ 03113130</p>
                                                <p class="mb-1"> ІПН 031131303172, свідоцтво № 100337934</p>
                                                <p class="mb-1"> р/р UA63033980000026009300331234, Волинське ОУ АТ "Ощадбанк"</p>
                                                <p>
                                                    Заст. гол.бухгалтера ______________ Боярська Н.В.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @empty
                                <p>Документів не знайдено...</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 mt-2">
                            {{ $invoices->links() }}
                        </div>
                        <div class="col-md-3 mt-2 text-md-right">
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                            </button>
                            <a class="btn btn-primary" id="send-invoices" href="#">
                                <i class="fas fa-download"></i>
                                Відправити
                            </a>
                        </div>
                    </div>

                    <!-- /.col -->
                {{--</div>--}}
                <!-- /.row -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        @include('partials.footer')
    </div>
@endsection
@section('my_script')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- date-range-picker -->
    {{--<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>--}}
    <!-- Tempusdominus Bootstrap 4 -->
    {{--<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>--}}
    <!-- AdminLTE for demo purposes -->
    {{--<script src="{{ asset('dist/js/demo.js') }}"></script>--}}
    {{--<script src="{{ asset('dist/js/url.min.js') }}"></script>--}}
    <script>
        jQuery(function ($) {
            //Initialize Select2 Elements
            $('.select2').select2();

            //Enable check and uncheck all functionality
            $('.checkbox-toggle').click(function () {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $('.card-tools input[type=\'checkbox\']').prop('checked', false);
                    $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square');
                } else {
                    //Check all checkboxes
                    $('.card-tools input[type=\'checkbox\']').prop('checked', true);
                    $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square');
                }
                $(this).data('clicks', !clicks);
            });

            // відправка документів на сервіс ВЧАСНО
            $('#send-invoices').click(function (e) {
                e.preventDefault();
                var checkBoxes = $('input:checked');
                if (checkBoxes.length > 0){
                    $('#ajax').html('<div class="progress-group"> Відправка документів <b>0/' + checkBoxes.length + '</b><div class="progress progress-sm"><div class="progress-bar bg-primary" style="width: 0%"></div></div></div>').fadeIn(500, function () {
                        for (var x=0; x < checkBoxes.length; x++){
                            sleep(1);


                        }
                    });
                }
            });


            $('#ajax').html('<div class="progress-group"> Відправка документів <b>160/200</b><div class="progress progress-sm"><div class="progress-bar bg-primary" style="width: 30%"></div></div></div>').fadeIn(500, function () {

                var data = {
                    "category": $('#category').val(),
                    "data-range": $('#reservation').val(),
                    "ac-name": $('#mega-ac').val(),
                    "folder": $('#folder').val(),
                    "r-input": $('.radioPrimary:checked').data("radio")
                };
                //console.log(data);
                var cookie_value = JSON.stringify(data);

                $.ajax({
                    url: "{{ route('manager.invoices.send') }}",
                    type: "POST",
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        $('#alert-valid').addClass('no-display-alert');
                        $.cookie('parameters', cookie_value, {expires: 30});
                        // ----- будуємо графік ---------------------
                        var areaChartData = {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: data.label,
                                    backgroundColor: data.backgroundColor,
                                    borderColor: data.borderColor,
                                    pointRadius: data.pointRadius,
                                    pointColor: data.pointColor,
                                    pointStrokeColor: data.pointStrokeColor,
                                    pointHighlightFill: data.pointHighlightFill,
                                    pointHighlightStroke: data.pointHighlightStroke,
                                    data: data.data
                                },
                            ]
                        };
                        //-------------
                        //- BAR CHART -
                        //-------------
                        var barChartCanvas = $('#barChart').get(0).getContext('2d');
                        var barChartData = jQuery.extend(true, {}, areaChartData);

                        var barChartOptions = {
                            responsive: true,
                            maintainAspectRatio: false,
                            datasetFill: false
                        };

                        var barChart = new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                        });

                        $('#ajax').find('span').text('Побудовано!');
                        $('#ajax').delay(300).fadeOut(300);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var http_kod = jqXHR.status;
                        // ---- розшифровуємо тільки помилки що повертає скрипт --- //
                        var title = 'Невідома помилка -> http kod ' + http_kod;
                        var content = '';
                        if (jqXHR.getResponseHeader('megalog') === 'errorMegalog') {
                            if (typeof $.parseJSON(jqXHR.responseText).error !== 'undefined') {
                                var title = $.parseJSON(jqXHR.responseText).error + ' http kod ' + http_kod;
                            }
                            if (typeof $.parseJSON(jqXHR.responseText).message !== 'undefined') {
                                let massages = $.parseJSON(jqXHR.responseText).message;
                                for (let i = 0; i < massages.length; i++) {
                                    content += massages[i] + '<br>';
                                }
                            }
                        }
                        $('#ajax').find('span').text('Помилка!');
                        $('#ajax').delay(300).fadeOut(300);
                        $('#alert-valid p').html(content);
                        $('#alert-valid h5 span').html(title);
                        $('#alert-valid').removeClass('no-display-alert');
                    }
                })
            });




        })
    </script>
@endsection