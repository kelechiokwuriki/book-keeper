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
                        @if (session('success'))

                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                        @endif
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
                                <th>Recommend</th>
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
                                    <td>{{$book->available}}</td>
                                    <td><button id="viewBookModalButton" data-target="#viewBookModal" data-toggle="modal"
                                                class="btn btn-info viewBook" value="{{$book->id}}" role="button">View</button></td>
                                    @if($book->available === 'available')
                                        <td><form method="POST" action="/reservations">
                                                {{csrf_field()}}
                                                <input type="hidden" name="bookId" value="{{$book->id}}">
                                                <button type="submit" class="btn btn-success" role="button">Reserve book</button>
                                            </form></td>
                                        <td>
                                            <form method="POST" action="/recommend">
                                                {{csrf_field()}}
                                                <input type="hidden" name="bookId" value="{{$book->id}}">
                                                <button type="submit" class="btn btn-primary" role="button">Recommend book</button>
                                            </form>
                                        </td>
                                    @else
                                        <td><button id="viewReservationModalButton" value="{{$book->id}}" data-target="#viewReservationModal" data-toggle="modal"
                                                    class="btn btn-warning" role="button">View reservation</button></td>
                                        <td><button id="{{$book->id}}" class="btn btn-block btn-default disabled">n/a</button></td>
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

        <!--Book modal-->
        <div class="modal fade" id="viewBookModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title">Book details</h2>
                    </div>
                    <div class="modal-body">
                        <p>Title : <strong id="bookTitle"></strong></p>
                        <p>Author : <strong id="bookAuthor"></strong></p>
                        <p>Version : <strong id="bookVersion"></strong></p>
                        <p>Available : <strong id="bookAvailable"></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            <form method="POST" action="/reservations">
                                {{csrf_field()}}
                                @foreach($books as $book)
                                    <input type="hidden" name="bookId" value="{{$book->id}}">
                                    <button type="submit" id="bookReserveModal" class="btn btn-success bookReserveModal" role="button">Reserve book</button>
                                @endforeach
                            </form>
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
                        <h2 class="modal-title">Reservation details</h2>
                    </div>
                    <div class="modal-body">
                        <p>Book :<strong id="bookName"></strong></p>
                        <p>Reserved by :<strong id="reservedBy"></strong></p>
                        <p>Checked out date : <strong id="checkedOutDate"></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left " data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.end reservation modal -->
    </section>

@endsection
