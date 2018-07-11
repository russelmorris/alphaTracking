let ticker = null;
let icDate = $('.ic_dates').val();
let user_id = $('.admin_users').val();

let tickerFunc = function () {
    $('#dataTables-example').find('tr').mouseover(function () {
        ticker = $(this).find('.ticker').text().trim();
    });
};
let businessModel = function () {

    $('.business-model').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            fc1: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
let businessValuation = function () {
    $('.business-valuation').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            fc2: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
let digitalFootprint = function () {
    $('.digital-footprint').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            fc3: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });

    });
};
let uplift = function () {
    $('.uplift').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            fc4: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });

    });
};
let competitorAnalysis = function () {
    $('.competitor-analysis').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            fc5: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });

    });

};
let risk = function () {
    $('.risk').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            fc6: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
let veto = function () {
    $('.veto').click(function () {
        $(this).find('i').toggleClass(function () {
            if ($(this).hasClass(".fa-check")) {
                return "";
            } else {
                return "fa-check";
            }
        });
        $.post('populate_master', {
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            veto: $(this).find('i').hasClass('fa-check'),
            ticker: ticker,
            flag: 'veto',
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
let finalised = function () {
    $('.finalised').click(function () {
        let final = $(this).find('i').toggleClass(function () {
            if ($(this).hasClass(".fa-check")) {
                return "";
            } else {
                return "fa-check";
            }
        });

        $.post('populate_master', {
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ticker: ticker,
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
};

$(document).ready(function () {

    let el = $("#dataTables-example");
    if (!$('#dash_ajax').val()) {
        el.show();

    } else if ($('#dash_ajax').val()) {
        el.hide();
        $.post('/dashboard_ajax', {
            ic_date: $('.ic_dates').val(),
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
            if (data) {
                $('#empty').hide();
                $('#dataTables-example').show();
            }
            el.find('tbody').html($(data).find('#dataTables-example > tbody > *'));
            el.find('tr').each(function () {
                if ($(this).hasClass("row-finished")) {
                    return "";
                } else {
                    return "row-finished";
                }
            });
            el.find('td').each(function () {
                $(this).toggleClass(function () {
                    if (!$(this).hasClass("final") && $(this).parent().hasClass("row-finished")) {
                        return "disable-row";
                    } else {
                        return "";
                    }
                });
            });
            tickerFunc();
            businessModel();
            businessValuation();
            digitalFootprint();
            uplift();
            competitorAnalysis();
            risk();
            veto();
            finalised();
            /*$(window).scroll(function () {
                if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                    $.post('/dashboard_ajax', {
                        ic_date: $(this).val(),
                        user_id: user_id,
                        limit: ($('#dataTables-example tr').length - 1) + 10,
                        csnamerf: $.cookie('csrfcookiename')
                    }).done(function (data) {
                        let table = $('#dataTables-example');
                        table.find('tbody').html($(data).find('#dataTables-example > tbody > *'));
                        table.find('tr').each(function () {
                            if ($(this).hasClass("row-finished")) {
                                return "";
                            } else {
                                return "row-finished";
                            }
                        });
                        table.find('td').each(function () {
                            $(this).toggleClass(function () {
                                if (!$(this).hasClass("final") && $(this).parent().hasClass("row-finished")) {
                                    return "disable-row";
                                } else {
                                    return "";
                                }
                            });
                        });
                        // last_master = table.find('tr:last input').val();
                        ticker();
                        businessModel();
                        businessValuation();
                        digitalFootprint();
                        uplift();
                        competitorAnalysis();
                        risk();
                        veto();
                        finalised();
                    }).fail(function () {

                    })

                }
            });*/

        }).fail(function () {

        });
    }

    $('.ic_dates').change(function () {
        $('#empty').show();
        $('#dataTables-example').hide();
        let allow_edit = moment(new Date()).isBefore($(this).val());
        $.post('/dashboard_ajax', {
            ic_date: $(this).val(),
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
            if (data) {
                $('#empty').hide();
                $('#dataTables-example').show();
            }

            let table = $('#dataTables-example');
            table.find('tbody').html($(data).find('#dataTables-example > tbody > *'));
            if (!allow_edit && !$('#allow_edit_as_admin').val()) {
                el.find('tr').each(function () {
                    if (!$(this).hasClass('row-finished')) {
                        $(this).children('td').toggleClass(function () {
                            if ($(this).hasClass("click")) {
                                return "";
                            } else {
                                return "disable-row";
                            }
                        });
                    }
                    else {
                        $(this).children('td').toggleClass(function () {
                            if ($(this).hasClass("final-dis")) {
                                return "disable-row";
                            } else {
                                return "";
                            }
                        });
                    }
                });
            }

            table.find('tr').each(function () {
                if ($(this).hasClass("row-finished")) {
                    return "";
                } else {
                    return "row-finished";
                }
            });
            table.find('td').each(function () {
                $(this).toggleClass(function () {
                    if (!$(this).hasClass("final") && $(this).parent().hasClass("row-finished")) {
                        return "disable-row";
                    } else {
                        return "";
                    }
                });
            });
            // last_master = table.find('tr:last input').val();
            tickerFunc();
            businessModel();
            businessValuation();
            digitalFootprint();
            uplift();
            competitorAnalysis();
            risk();
            veto();
            finalised();
        }).fail(function () {

        })
    });

    $('.admin_users').change(function () {
        $('#empty').show();
        $('#dataTables-example').hide();
        $.post('/dashboard_ajax', {
            ic_date: $('.ic_dates').val(),
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            // allow_edit: moment(new Date()).isBefore(icDate),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
            if (data) {
                $('#empty').hide();
                $('#dataTables-example').show();
            }
            let table = $('#dataTables-example');
            table.find('tbody').html($(data).find('#dataTables-example > tbody > *'));
            table.find('tr').each(function () {
                if ($(this).hasClass("row-finished")) {
                    return "";
                } else {
                    return "row-finished";
                }
            });
            table.find('td').each(function () {
                $(this).toggleClass(function () {
                    if (!$(this).hasClass("final") && $(this).parent().hasClass("row-finished")) {
                        return "disable-row";
                    } else {
                        return "";
                    }
                });
            });
            // last_master = table.find('tr:last input').val();
            tickerFunc();
            businessModel();
            businessValuation();
            digitalFootprint();
            uplift();
            competitorAnalysis();
            risk();
            veto();
            finalised();
        }).fail(function () {

        });
    });
});


function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

