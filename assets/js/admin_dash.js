$('#prospect').change(function () {
    let fd = new FormData();
    fd.append('file', $(this)[0].files[0]); // since this is your file input
    fd.append('csnamerf', $.cookie('csrfcookiename')); // since this is your file input
    fd.append('ic_date', $('.import_date').val());
    $.ajax({
        url: "import_prospect",
        type: "post",
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data: fd,
        success: function (data) {
            if(data === 1)
                $('#myModal').modal('toggle');
        },
        error: function (data) {

        }
    });
});

$('#returns').change(function () {
    let fd = new FormData();
    fd.append('file', $(this)[0].files[0]); // since this is your file input
    fd.append('csnamerf', $.cookie('csrfcookiename')); // since this is your file input

    $.ajax({
        url: "import_returns",
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