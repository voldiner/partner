@extends('admin.layouts.layout')
@section('title', 'Чат')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('body_classes','hold-transition sidebar-mini')
@section('my_styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .direct-chat-messages {
            height: 300px !important;
            overflow-x: hidden !important;
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

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Чат</h1>
                        </div>
                        {{--<div class="col-sm-6">--}}
                        {{--<ol class="breadcrumb float-sm-right">--}}
                        {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                        {{--<li class="breadcrumb-item active">Blank Page</li>--}}
                        {{--</ol>--}}
                        {{--</div>--}}
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('partials.status_message')
                    @include('partials.validation_messages')
                    <div class="row">
                        <div class="col-12">
                            <div id="alert-valid" class="alert alert-danger alert-dismissible no-display-alert">
                                {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
                                <h5><i class="icon fas fa-ban"></i> <span>Помилка!</span></h5>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card direct-chat direct-chat-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h3 class="card-title">Чат з <b>Яцишин М.М.</b></h3>

                                    <div class="card-tools">
                                        <span data-toggle="tooltip" title="3 New Messages"
                                              class="badge badge-primary">3</span>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Conversations are loaded here -->
                                    <div class="direct-chat-messages">
                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                                <span class="direct-chat-timestamp float-left ml-2">23 Jan 2:00 pm</span>
                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <div class="direct-chat-text ml-0 mr-5">
                                                Is this template really for free? That's unbelievable!
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <!-- Message to the right -->
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-timestamp float-right ml-2">23 Jan 2:05 pm</span>
                                                <span class="direct-chat-name float-right">Sarah Bullock</span>

                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <div class="direct-chat-text ml-5 mr-0">
                                                You better believe it!
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                                <span class="direct-chat-timestamp float-left ml-2">23 Jan 5:37 pm</span>
                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <div class="direct-chat-text ml-0 mr-5">
                                                Working with AdminLTE on a great new app! Wanna join?
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                        <!-- Message to the right -->
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-timestamp float-right ml-2">23 Jan 6:10 pm</span>
                                                <span class="direct-chat-name float-right">Sarah Bullock</span>

                                            </div>
                                            <!-- /.direct-chat-infos -->
                                            <div class="direct-chat-text ml-5 mr-0">
                                                I would love to. Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit. Ab accusantium adipisci dolore facere fuga inventore neque nihil,
                                                nisi quas reiciendis sed sequi sit ut voluptatem!
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->

                                    </div>
                                    <!--/.direct-chat-messages-->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <form action="#" method="post">
                                        <div class="input-group">
                                            <input type="text" name="message" id="message" placeholder="Type Message ..."
                                                   class="form-control">
                                            <span class="input-group-append">
                                                <button type="button" id="btn-submit"
                                                        class="btn btn-primary">Відправити</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-footer-->
                            </div>

                        </div>
                    </div>

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
    <script>
        jQuery(function ($) {

            //Initialize Select2 Elements
            $('.select2').select2();

            // ------ робимо ajax запит на створення повідомлення
            $('#btn-submit').click(function (e) {
                @if(session()->missing('atpName'))
                alert('Помилка! Не обрано перевізника');
                return;
                @endif
                if ($('#message').val().length == 0){
                 return;
                }
                e.preventDefault();
                var data = {
                    "message": $('#message').val(),
                    "administrator_id": {{ auth()->user()->id }},
                    "user_id": {{ session('atpId') }}
                };
                console.log(data);
                $.ajax({
                    url: "{{ route('manager.chat.create') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        $('#alert-valid').addClass('no-display-alert');
                       console.log('response');
                       console.log(data);









                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var http_kod = jqXHR.status;
                        // ---- розшифровуємо тільки помилки що повертає скрипт --- //
                        var title = 'Невідома помилка -> http kod ' + http_kod;
                        var content = '';
                        if (jqXHR.getResponseHeader('partner') === 'errorPartner') {
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

                        $('#alert-valid p').html(content);
                        $('#alert-valid h5 span').html(title);
                        $('#alert-valid').removeClass('no-display-alert');
                    }
                });


            });


        });

    </script>
@endsection