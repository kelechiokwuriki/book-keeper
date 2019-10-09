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
                                    <td><button id="{{$book->id}}" data-target="#viewBookModal" data-toggle="modal"  data-title="{{$book->title}}"
                                                class="btn btn-info viewBook" role="button">View</button></td>
                                    @if($book->available)
                                        <td><form method="POST" action="/reservations/">
                                                {{csrf_field()}}
                                                <input type="hidden" name="bookId" value="{{$book->id}}" placeholder="Device Name">
                                                <button type="submit" class="btn btn-success" role="button">Reserve book</button>
                                            </form></td>
                                    @else
                                        <td><form method="GET" action="/reservations/">
                                                {{csrf_field()}}
                                                <input type="hidden" name="bookId" value="{{$book->id}}" placeholder="Device Name">
                                                <button type="submit" class="btn btn-warning" role="button">View reservation</button>
                                            </form></td>
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
    </section>

@endsection
