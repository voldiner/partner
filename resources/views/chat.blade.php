@extends('layouts.layout')
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

        .no-display-alert {
            display: none;
        }
    </style>
@endsection
@section('content')
    <!-- Site wrapper -->
    <div class="wrapper">
    @include('partials.navbar')
    @include('partials.sidebar')
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
                        <div class="col-xl-6 col-lg-8 col-md-10">
                            <div class="card direct-chat direct-chat-primary" id="direct-chat">
                                <div class="card-header ui-sortable-handle">
                                    <h5 class="card-title" id="chat-title">
                                            Ваше повідомлення отримають працівники ПрАТ "ВОПАС"
                                    </h5>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Conversations are loaded here -->
                                    <div class="direct-chat-messages" id="direct-chat-messages">
                                    @if($messages)
                                        @foreach($messages as $message)
                                            @if($message->from === $message->administrator_id)
                                                <!-- Message. Default to the left -->
                                                    <div class="direct-chat-msg">
                                                        <div class="direct-chat-infos clearfix">
                                                            <span class="direct-chat-name float-left">{{ $message->administrator->shortName() }}</span>
                                                            <span class="direct-chat-timestamp float-left ml-2">{{ $message->getDateMessage() }}</span>
                                                        </div>
                                                        <!-- /.direct-chat-infos -->
                                                        <div class="direct-chat-text ml-0 mr-5">
                                                            {{ $message->text }}
                                                        </div>
                                                        <!-- /.direct-chat-text -->
                                                    </div>
                                                    <!-- /.direct-chat-msg -->
                                            @endif
                                            @if($message->from === $message->user_id)
                                                <!-- Message to the right -->
                                                    <div class="direct-chat-msg right">
                                                        <div class="direct-chat-infos clearfix">
                                                            <span class="direct-chat-timestamp float-right ml-2">{{ $message->getDateMessage() }}</span>
                                                            <span class="direct-chat-name float-right">{{ $message->user->name }}</span>
                                                        </div>
                                                        <!-- /.direct-chat-infos -->
                                                        <div class="direct-chat-text ml-5 mr-0">
                                                            {{ $message->text }}
                                                        </div>
                                                        <!-- /.direct-chat-text -->
                                                    </div>
                                                    <!-- /.direct-chat-msg -->
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <form id="send-message" action="#" method="post">
                                        <div class="input-group">

                                            <textarea name="message" id="message" rows="2"
                                                      placeholder="Ваше повідомлення ..." maxlength="300"
                                                      style="width: 100%;"></textarea>
                                            <div class="row" style="width: 100%;">
                                                <div class="col p-0">
                                                     <span class="input-group-append mt-2">
                                                         <button type="button" id="btn-submit"
                                                                 class="btn btn-primary ml-auto">Відправити</button>
                                                    </span>
                                                </div>
                                            </div>
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
    <script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
    <script>
        jQuery(function ($) {

            //Initialize Select2 Elements
            //  $('.select2').select2();

            // ---- вибір менеджера
            $('.contacts-list-info').click(function (event) {
                let title = 'Чат з ' + this.children[0].firstChild.data;
                console.log($(this).data('id'));
                $('#chat-title').html(title);
                $('#direct-chat').removeClass('direct-chat-contacts-open');
            });


            // do not send form on key press ENTER
            $('#send-message').keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            // ---- scroll messages to down
            $('#direct-chat-messages').animate({scrollTop: $("#direct-chat-messages")[0].scrollHeight}, 100);
            // --- pusher
            var pusher = new Pusher(
                "{{ env('PUSHER_APP_KEY') }}",
                {
                    cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
                });

            var channel = pusher.subscribe("partner");

            channel.bind("{{ auth()->user()->password_fxp }}", (data) => {
                // Method to be dispatched on trigger.
                console.log(data.date);
                let htmlMessage = '';
                if (data.user_id === data.from) {
                    htmlMessage = createMessageRight(data);
                }
                if (data.administrator_id === data.from) {
                    htmlMessage = createMessageLeft(data);
                }
                if (htmlMessage.length > 0) {
                    $("#direct-chat-messages").append(htmlMessage);
                }
                $('#message').val('');
                $('#direct-chat-messages').animate({scrollTop: $("#direct-chat-messages")[0].scrollHeight}, 1000);

            });

            function createMessageLeft(data) {
                let result = '<div class="direct-chat-msg">';
                result += '<div class="direct-chat-infos clearfix">';
                result += '<span class="direct-chat-name float-left">' + data.administrator_name + '</span>';
                result += '<span class="direct-chat-timestamp float-left ml-2">' + data.date + '</span></div>';
                result += '<div class="direct-chat-text ml-0 mr-5">' + data.message + '</div></div>';

                return result;
            }

            function createMessageRight(data) {
                let result = ' <div class="direct-chat-msg right">';
                result += '<div class="direct-chat-infos clearfix">';
                result += '<span class="direct-chat-timestamp float-right ml-2">' + data.date + '</span>';
                result += '<span class="direct-chat-name float-right">' + data.user_name + '</span></div>';
                result += '<div class="direct-chat-text ml-5 mr-0">' + data.message + '</div></div>';

                return result;
            }

            // ------ робимо ajax запит на створення повідомлення
            $('#btn-submit').click(function (e) {

                if ($('#message').val().length == 0) {
                    return;
                }
                e.preventDefault();
                var data = {
                    "message": $('#message').val(),
                    "administrator_id": 0,
                    "user_id": {{ auth()->user()->id }}
                };
                console.log(data);
                $.ajax({
                    url: "{{ route('chat.create') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        $('#alert-valid').addClass('no-display-alert');
                        //console.log('response');
                        //console.log(data);


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