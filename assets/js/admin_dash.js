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
        url: "import-prospect",
        type: "post",
        processData: false, // important
        contentType: false, // important
        data: fd,
        success: function (data, status, xhr) {
            if (data == 1) {
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


        },
    });
});

$('#returns').change(function () {
    var fd = new FormData();
    fd.append('file', $(this)[0].files[0]); // since this is your file input
    fd.append('csnamerf', $.cookie('csrfcookiename')); // since this is your file input

    $.ajax({
        url: "import-returns",
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

$('#query_build').click(function () {
    $body = $("body");
    $body.addClass("loading");
    $.post('/build-portfolio', {
        date: $('.query_ic_date').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        console.log(data);
        alert(data);
        $body.removeClass("loading");

    })
});

if($('.query_ic_date').val() == null){
    $('#query_build').prop('disabled', true)
}


$('#create_googletrends_cvs').click(function () {
    $body = $("body");
    $body.addClass("loading");

    $.get('create-csv-googletrends').done(function (data) {
        console.log(data);
        alert(data);
        $body.removeClass("loading");

    })

})


$('#crate_alexa_cvs').click(function () {
    $body = $("body");
    $body.addClass("loading");

    $.get('create-csv-alexa').done(function (data) {
        console.log(data);
        alert(data);
        $body.removeClass("loading");

    })

})
