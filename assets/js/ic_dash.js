let ticker = null;
let last_master = null;
let icDate = $('.ic_dates').val();
let user_id = $('.admin_users').val();

$('#dataTables-example').hide();


let ticker_master = function () {
    $('#dataTables-example').find('tr').mouseover(function () {
        ticker = $(this).find('.ticker').text().trim();
        // masterID = $('.master_id').val();
    });
};
let businessModel = function () {
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
};
let businessValuation = function () {
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
};
let digitalFootprint = function () {
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
};
let uplift = function () {
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
};
let competitorAnalysis = function () {
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

};
let risk = function () {
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
            // master: masterID,
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

    if ($('#dash_ajax').val()) {
        $.post('/dashboard_ajax', {
            ic_date: $('.ic_dates').val(),
            user_id: $('.admin_users').val(),
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
            last_master = el.find('tr:last input').val();
            ticker_master();
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
                        ticker_master();
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
});


$('.ic_dates').change(function () {
    $('#empty').show();
    $('#dataTables-example').hide();
    $.post('/dashboard_ajax', {
        ic_date: $(this).val(),
        user_id: user_id,
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
        last_master = table.find('tr:last input').val();
        ticker_master();
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
        ic_date: icDate,
        user_id: $(this).val(),
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
        last_master = table.find('tr:last input').val();
        ticker_master();
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

function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

