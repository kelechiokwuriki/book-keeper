@extends('adminlte::page')

@section('content_header')
    <section class="content-header">
        <h1>Books</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="/books" class="active"><i class="fa fa-book"></i>Books</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Books</h3>
                    </div>
                    <div class="box-body">
                        <table id="bookTable" class="table table-bordered table-striped text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Version</th>
                                <th>Available</th>
                                <th>View</th>
                                <th>Reservation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $tableNoCounter = 0; ?>
                            @foreach($books as $book)
                                <?php $tableNoCounter++?>
                                <tr>
                                    <td>{{$tableNoCounter}}</td>
                                    <td>{{$book->title}}</td>
                                    <td>{{$book->author}}</td>
                                    <td>{{$book->version}}</td>
                                    @if($book->available)
                                        <td>Available</td>
                                    @else
                                        <td>Not available</td>
                                    @endif
                                    <td><button id="{{$book->id}}" data-target="#viewBookModal" data-toggle="modal"
                                                class="btn btn-info viewBook" role="button">View</button></td>
                                    @if($book->available)
                                        <td><form method="POST" action="/reservations">
                                                {{csrf_field()}}
                                                <input type="hidden" name="bookId" value="{{$book->id}}">
                                                <button type="submit" class="btn btn-success" role="button">Reserve book</button>
                                            </form></td>
                                    @else
                                        <td><button id="{{$book->id}}" data-target="#viewReservationModal" data-toggle="modal"
                                                    class="btn btn-warning viewReservation" role="button">View reservation</button></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewBookModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Book details</h5>
                    </div>
                    <div class="modal-body">
                        <p>Book title : <strong id="bookTitle"></strong></p>
                        <p>Book author : <strong id="bookAuthor"></strong></p>
                        <p>Book version : <strong id="bookVersion"></strong></p>
                        <p>Book available : <strong id="bookAvailable"></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Reserve book</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.end book modal -->

        <!--reservation modal-->
        <div class="modal fade" id="viewReservationModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Reservation details</h5>
                    </div>
                    <div class="modal-body">
                        <p>Book :<strong id="bookName"></strong></p>
                        <p>Reserved by :<strong id="reservedBy"></strong></p>
                        <p>Checked out date : <strong id="checkedOutDate"></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Reserve book</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.end reservation modal -->
    </section>

@endsection
