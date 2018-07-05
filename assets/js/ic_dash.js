$(document).ready(function () {
    let el = $("#dataTables-example").find('tr').each(function () {
        if ($(this).hasClass("row-finished")) {
            return "";
        } else {
            return "row-finished";
        }
    });
    $(el).find('td').each(function () {
        $(this).toggleClass(function () {
            if (!$(this).hasClass("final") && $(this).parent().hasClass("row-finished")) {
                return "disable-row";
            } else {
                return "";
            }
        });
    });
});
let ticker = null;
let masterID = null;
$('#dataTables-example').find('tr').mouseover(function () {
    ticker = $(this).find('.ticker').text().trim();
    masterID = $('.master_id').val();
});

$('.business-model').change(function () {
    $.post('populate_master', {
        ticker: ticker,
        master: masterID,
        fc1: $(this).val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });
});
$('.business-valuation').change(function () {
    $.post('populate_master', {
        ticker: ticker,
        master: masterID,
        fc2: $(this).val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });

});
$('.digital-footprint').change(function () {
    $.post('populate_master', {
        ticker: ticker,
        master: masterID,
        fc3: $(this).val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });

});
$('.uplift').change(function () {
    $.post('populate_master', {
        ticker: ticker,
        master: masterID,
        fc4: $(this).val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });

});
$('.competitor-analysis').change(function () {
    $.post('populate_master', {
        ticker: ticker,
        master: masterID,
        fc5: $(this).val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });

});
$('.risk').change(function () {
    $.post('populate_master', {
        ticker: ticker,
        master: masterID,
        fc6: $(this).val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });
});

$('.veto').click(function () {
    $(this).find('i').toggleClass(function () {
        if ($(this).hasClass(".fa-check")) {
            return "";
        } else {
            return "fa-check";
        }
    });
    $.post('populate_master', {
        master: masterID,
        veto: $(this).find('i').hasClass('fa-check'),
        flag: 'veto',
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });
});

$('.finalised').click(function () {
    let final = $(this).find('i').toggleClass(function () {
        if ($(this).hasClass(".fa-check")) {
            return "";
        } else {
            return "fa-check";
        }
    });


    $.post('populate_master', {
        master: masterID,
        finalised: $(this).find('i').hasClass('fa-check'),
        flag: 'finalised',
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });
    $(final).closest("tr").toggleClass(function () {
        if ($(this).hasClass(".row-finished")) {
            return "";
        } else {
            return "row-finished";
        }
    });

    $(final).closest("tr").find('td').each(function () {
        $(this).toggleClass(function () {
            if (!$(this).hasClass("final")) {
                return "disable-row";
            } else {
                return "";
            }
        });

    });

});
$('.ic_dates').change(function () {
    let fd = new FormData();
    fd.append('date', $(this).val()); // since this is your file input
    fd.append('csnamerf', $.cookie('csrfcookiename')); // since this is your file input

    $.ajax({
        url: 'dashboard_ajax',
        async: false,
        type: "POST",
        data: fd,
        dataType: "html",
        processData: false, // important
        contentType: false, // important
        success: function (data) {
            $('#dataTables-example').find('tbody').html($(data).find('tbody').html());
        }
    })
});

$('.admin_users').change(function () {
    console.log($(this).val());
})

