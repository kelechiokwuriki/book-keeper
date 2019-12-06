$(document).ready(function(){

    // $('.alert').alert();
    //script to view a book when modal is clicked
    $("#viewBookModalButton").click(function (e) {
        //disable the modal button before data loads

        e.preventDefault();

        $('#bookReserveModal').attr("disabled", "disabled");

        const bookId = $(this).attr("value");

        $.ajax({
            url: "/books/" + bookId,
            type: "GET",
            success:function (data) {
                if(data != null){
                    $('#bookTitle').html(data.title);
                    $('#bookAuthor').html(data.author);
                    $('#bookVersion').html(data.version);
                    $('#bookAvailable').html(data.available);
                    $('#bookId').attr("value", data.id);
                    $('#viewBookModal').modal("show");
                    $('#bookReserveModal').removeAttr("disabled");
                }
            },
            error:function () {
                //display errpr on body
            }
        })
    });

    $('#viewReservationModalButton').click(function (e) {
        e.preventDefault();

        const bookId = $(this).attr("value");

        $.ajax({
            url: "/reservations/" + bookId,
            type: "GET",
            success:function (data) {
                // console.log(data[0]);
                if(data != null){
                   $('#bookName').html(data[0]);
                   $('#reservedBy').html(data[1]);
                   $('#checkedOutDate').html(data[2]);
                    $('#viewReservationModal').modal("show");
                }
            }
        })
    });
});
