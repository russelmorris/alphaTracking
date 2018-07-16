function final_value() {
    $.post('finalised_value', {
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        $('#finalised-label').text(data + "% Finalised");
        $('#finalised-value').prop('aria-valuenow', data).css('width', data + '%');
    }).fail(function (err) {

    });

}

function updateTicker(ticker, factor, value) {
    $.post('update-factor', {
        ticker: ticker,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        factor: factor,
        value: value,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });
};

function updateVeto(ticker, element) {
    $.post('update-veto', {
        ticker: ticker,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        if (data == '0') {
            element.innerHTML = '<i class="fa"></i>';
        } else {
            element.innerHTML = '<i class="fa fa-check"></i>';
        }
    }).fail(function (err) {

    });
};

function updateFinalise(ticker, element) {
    $.post('update-finalise', {
        ticker: ticker,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        final_value();
        if (data == 0) {
            element.innerHTML = '<i class="fa"></i>';
            $(".ticker_" + ticker).prop('disabled', false);
            $('#tr_' + ticker).closest("tr").removeClass("row-finished");
        } else {
            element.innerHTML = '<i class="fa fa-check"></i>';
            $(".ticker_" + ticker).prop('disabled', true);
            $('#tr_' + ticker).closest("tr").addClass("row-finished");

        }
    }).fail(function (err) {

    });
};

function reloadDashboard() {
    $('#dashboard-table-holder').html('' +
        '<div colspan="15" class="text-center">' +
        '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>' +
        '<span class="sr-only">Loading...</span>' +
        '</div>');
    var allow_edit = moment(new Date()).isBefore($('.ic_dates').val());
    $.post('/dashboard_ajax', {
        ic_date: $('.ic_dates').val(),
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        $('#dashboard-table-holder').html(data);
        final_value();
        if (!allow_edit && !$('#allow_edit_as_admin').val()) {
            $('.finalised').prop('disabled', true);
            $('.veto').prop('disabled', true);
            $('.business-model').prop('disabled', true);
            $('.business-valuation').prop('disabled', true);
            $('.digital-footprint').prop('disabled', true);
            $('.uplift').prop('disabled', true);
            $('.competitor-analysis').prop('disabled', true);
            $('.risk').prop('disabled', true);
        }
    }).fail(function () {

    });
}

$(document).ready(function () {
    if ($('#dash_ajax').val() != undefined) {
        reloadDashboard();

        $('.ic_dates').change(function () {
            reloadDashboard();
        });

        $('.admin_users').change(function () {
            $('#user_name').text('Name: ' + $(this).find('option:selected').text().trim());
            reloadDashboard();
        });
    }
});


function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

