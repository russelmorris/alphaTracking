var prospects = null;
$('#alert-success').hide();
$('#alert-danger').hide();
$('#alert-success-return').hide();
$('#alert-danger-return').hide();
$('#prospect').change(function () {
    prospects = this.files[0];
    if (prospects.name) {
        $('#upload-prospects').text('Upload ' + prospects.name).removeAttr('disabled');
    }
});

$('#upload-prospects').click(function () {
    var fd = new FormData();
    fd.append('file', prospects); // since this is your file input
    fd.append('csnamerf', $.cookie('csrfcookiename')); // since this is your file input
    fd.append('ic_date', $('.import_date').val());
    $.ajax({
        url: "import_prospect",
        type: "post",
        processData: false, // important
        contentType: false, // important
        data: fd,
        success: function (data) {
            if (data == 1) {
                // $('#upload-prospects').text('Upload').attr('disabled', 'disabled');
                $('#alert-success').show();
                setTimeout(function () {
                    $('#alert-success').hide();
                }, 1500);
                setTimeout(function () {
                    $('#prospectModal').modal('hide');
                }, 1500);

            }
        },
        error: function (data) {
            if (data.status == 400) {
                $('#alert-danger').show();
                setTimeout(function () {
                    $('#alert-danger').hide();
                }, 1500);
            }


        }
    });
});
/*
$('.upload-prospects').click(function () {
    var fd = new FormData();
    fd.append('file', prospects); // since this is your file input
    fd.append('csnamerf', $.cookie('csrfcookiename')); // since this is your file input
    fd.append('ic_date', $('.import_date').val());
    $.ajax({
        url: "import_prospect",
        type: "post",
        processData: false, // important
        contentType: false, // important
        data: fd,
        success: function (data) {
            if (data == 1) {
                $('.upload-prospects').addClass('hidden');
                // $('#prospect').parent().toggleClass('hidden');
                $('#alert').toggleClass('hidden');
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
});
*/

$('#returns').change(function () {
    var fd = new FormData();
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