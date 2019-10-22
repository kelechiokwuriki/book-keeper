@extends('adminlte::page')

@section('content_header')
    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="#" class="active"><i class="glyphicon glyphicon-dashboard"></i>Home</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                            <h3>{{ $booksCount }}</h3>
                        <p>Books available</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book"></i>
                    </div>
                    <a href="/books" class="small-box-footer">View all books <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $userReservationCount }}</h3>
                        <p>Books reserved</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-folder"></i>
                    </div>
                    <a href="/reservations" class="small-box-footer">View your reservations <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>2</h3>
                        <p>Books recommended</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-contacts"></i>
                    </div>
                    <a href="/recommendations" class="small-box-footer">View your recommendations <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- Calendar -->
        <div class="box box-solid bg-green-gradient">
            <div class="box-header">
                <i class="fa fa-calendar"></i>

                <h3 class="box-title">Calendar</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bars"></i></button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="#">Add new event</a></li>
                            <li><a href="#">Clear events</a></li>
                            <li class="divider"></li>
                            <li><a href="#">View calendar</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Progress bars -->
                        <div class="clearfix">
                            <span class="pull-left">Task #1</span>
                            <small class="pull-right">90%</small>
                        </div>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 90%;"></div>
                        </div>

                        <div class="clearfix">
                            <span class="pull-left">Task #2</span>
                            <small class="pull-right">70%</small>
                        </div>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 70%;"></div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <div class="clearfix">
                            <span class="pull-left">Task #3</span>
                            <small class="pull-right">60%</small>
                        </div>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 60%;"></div>
                        </div>

                        <div class="clearfix">
                            <span class="pull-left">Task #4</span>
                            <small class="pull-right">40%</small>
                        </div>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 40%;"></div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    </section>
@endsection