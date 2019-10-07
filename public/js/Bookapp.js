//this function fetches book data when view is clicked
$(document).ready(function(){
    //script to view a book when modal is clicked
    $('.viewBook').click(function (e) {
        e.preventDefault();
        var bookId = $(this).attr("id");
        $.ajax({
            url: "/books/" + bookId,
            type: "GET",
            success:function (data) {
                if(data != null){
                    $('#bookModalTitle').html(data.title);
                    $('#bookTitle').html(data.title);
                    $('#bookAuthor').html(data.author);
                    $('#bookVersion').html(data.version);
                    $('#bookAvailable').html(data.available);
                    $('#viewBookModal').modal("show");
                }

            }
        })
    });
});
