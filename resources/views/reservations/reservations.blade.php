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
                        <table id="reservationsTable" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book</th>
                                    <th>Checked out date</th>
                                    <th>Checked in date</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $tableNoCounter = 0; ?>
                            @foreach($newReservationObject as $reservation)
                                    <?php $tableNoCounter++?>
                                    <tr>
                                        <td>{{$tableNoCounter}}</td>
                                        <td>{{$reservation->bookTitlesNew}}</td>
                                        <td>{{$reservation->checked_out_at}}</td>
                                        @if($reservation->checked_in_at === null)
                                            <td><small>Awaiting</small></td>
                                        @else
                                            <td>{{$reservation->checked_in_at}}</td>
                                        @endif
                                        <td><form method="DELETE" action="/reservations/{{$reservation->id}}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="bookId" value="{{$reservation->id}}" placeholder="Device Name">
                                                <button type="submit" class="btn btn-warning" role="button">Delete reservation</button>
                                            </form></td>
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