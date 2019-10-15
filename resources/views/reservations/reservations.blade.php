@extends('adminlte::page')

@section('content_header')
    <section class="content-header">
        <h1>Reservations</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="/books" class="active"><i class="fa fa-folder-open"></i>Reservations</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Reservations</h3>
                    </div>
                    <div class="box-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <table id="reservationsTable" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book</th>
                                    <th>Checked out date</th>
                                    <th>Checked in date</th>
                                    <th>Check In</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $tableNoCounter = 0; ?>
                            @foreach($newReservationObject as $reservation)
                                    <?php $tableNoCounter++?>
                                    <tr>
                                        <td>{{$tableNoCounter}}</td>
                                        <td>{{$reservation->bookTitleNew}}</td>
                                        <td>{{$reservation->checked_out_at}}</td>
                                        @if($reservation->checked_in_at === null)
                                            <td><small>Awaiting</small></td>
                                        @else
                                            <td>{{$reservation->checked_in_at}}</td>
                                        @endif
                                        <td>

                                            <!--TODO update the reservation table with a checked in data
                                            if user has checked book in, show delete reservation
                                            else show check book in
                                            -->
                                            <form method="POST" action="/reservations/{{$reservation->id}}">
                                                {{csrf_field()}}
                                                {{ method_field('PATCH') }}
                                                <input type="hidden" name="reservationId" value="{{$reservation->id}}">
                                                <button type="submit" class="btn btn-warning" role="button">Check book in</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" action="/reservations/{{$reservation->id}}">
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="reservationId" value="{{$reservation->id}}">
                                                <button type="submit" class="btn btn-warning" role="button">Delete reservation</button>
                                            </form>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection