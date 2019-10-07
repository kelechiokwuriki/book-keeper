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
                        <h3>4</h3>
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
                    <a href="/reservations" class="small-box-footer">View your recommendations <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection