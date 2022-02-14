@extends('layouts.layout')
@section('title', 'Відомості')
@section('body_classes','hold-transition sidebar-mini')

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
                                <h1>Відомості</h1>
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
                                        The body of the card
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-12">
                                <div class="card card-info collapsed-card mb-1">
                                    <div class="card-header">
                                        {{--<div class="card-title">--}}
                                            <div class="row justify-content-between">
                                                <div class="col-xl-2 border-right text-center">
                                                    12.01.2022
                                                </div>
                                                <div class="col-xl-2 border-right text-center">
                                                        АС Луцьк
                                                </div>
                                                <div class="col-xl-3 col-sm-5 border-right text-center">
                                                    Луцьк - Володимир-Волинський ч/з Гать
                                                </div>
                                                <div class="col-xl-1 col-sm-2 border-right text-center">
                                                    15-00
                                                </div>
                                                <div class="col-xl-1 col-sm-2 border-right text-center">
                                                    #123456
                                                </div>
                                                <div class="col-sm-2 text-center">
                                                    99125,35
                                                </div>
                                                <div class="card-tools col-md-1 text-right">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                        {{--</div>--}}


                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        The body of the card
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <div class="card card-info collapsed-card mb-1">
                                    <div class="card-header">
                                        <div class="row justify-content-between">
                                            <div class="col-xl-2 border-right text-center">
                                                12.01.2022
                                            </div>
                                            <div class="col-xl-2 border-right text-center">
                                                АС Луцьк
                                            </div>
                                            <div class="col-xl-3 col-sm-5 border-right text-center">
                                                Луцьк - Володимир-Волинський ч/з Гать
                                            </div>
                                            <div class="col-xl-1 col-sm-2 border-right text-center">
                                                15-00
                                            </div>
                                            <div class="col-xl-1 col-sm-2 border-right text-center">
                                                #123456
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                99125,35
                                            </div>
                                            <div class="card-tools col-md-1 text-right">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        The body of the card
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </div>
                            <!-- /.col -->
                        </div>
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
    <!-- AdminLTE for demo purposes -->
    {{--<script src="{{ asset('dist/js/demo.js') }}"></script>--}}
    {{--<script src="{{ asset('dist/js/url.min.js') }}"></script>--}}
    <script>
        jQuery(function ($) {

        })
    </script>
@endsection
