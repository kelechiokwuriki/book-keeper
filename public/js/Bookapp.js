//this function fetches book data when view is clicked
$(document).ready(function(){
    //script to view a book when modal is clicked
    $('.viewBook').click(function (e) {
        //disable the modal button befpre data loads
        $('#bookReserveModal').attr("disabled", "disabled");

        e.preventDefault();

        var bookId = $(this).attr("id");
        $.ajax({
            url: "/books/" + bookId,
            type: "GET",
            success:function (data) {
                if(data != null){
                    console.log(data);
                    $('#bookTitle').html(data.title);
                    $('#bookAuthor').html(data.author);
                    $('#bookVersion').html(data.version);
                    $('#bookAvailable').html(data.available);
                    $('#bookReserveModal').removeAttr("disabled");
                    $('#bookId').attr("value", data.id);
                    $('#viewBookModal').modal("show");
                }
            },
            error:function () {
                //display errpr on body
            }
        })
    });

    // $('#bookReserveModal').click(function (e) {
    //     e.preventDefault();
    //
    //     var id = $("#testId").attr("value");
    //     $.ajax({
    //         url: "reservationAjax" + id,
    //         type: "POST",
    //         success:function (data) {
    //             if(data != null) {
    //                 console.log(data);
    //             }
    //         }
    //     })
    //
    // });

    $('.viewReservation').click(function (e) {
        console.log("clicked");
        e.preventDefault();
        var bookId = $(this).attr("id");
        $.ajax({
            url: "/reservations/" + bookId,
            type: "GET",
            success:function (data) {
                if(data != null){
                   $('#bookName').html(data[0].bookTitleNew);
                   $('#reservedBy').html(data[0].reservedBy);
                   $('#checkedOutDate').html(data[0].checked_out_at);
                    $('#viewReservationModal').modal("show");
                }
            }
        })
    });
});
