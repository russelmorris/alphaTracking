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

    $.post('/dashboard_ajax', {
        ic_date:  $('.ic_dates').val(),
        user_id: $('.admin_users').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        $('#dataTables-example').html($(data).find('#dataTables-example'));
    }).fail(function () {

     });
});
let ticker = null;
let masterID = null;
let icDate = $('.ic_dates').val();
let user_id = $('.admin_users').val();
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
    $.post('/dashboard_ajax', {
        ic_date: $(this).val(),
        user_id: user_id,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        $('#dataTables-example').html($(data).find('#dataTables-example'));
    }).fail(function () {

    })
});

$('.admin_users').change(function () {
    $.post('/dashboard_ajax', {
        ic_date: icDate,
        user_id: $(this).val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        $('#dataTables-example').html($(data).find('#dataTables-example'));
    }).fail(function () {

    });
});