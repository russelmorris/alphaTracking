$('#pros').change(function () {
    var fd = new FormData();
    fd.append('file', $(this)[0].files[0]); // since this is your file input
    fd.append('csnamerf', $.cookie('csrfcookiename')); // since this is your file input

    $.ajax({
        url: "import_prospect",
        type: "post",
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data: fd,
        done: function (data) {
            console.log(data)
        },
        error: function (data) {

        }
    });
});