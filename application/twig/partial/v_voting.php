<div id="voting-page">
    <div class="row prev-next-holder">
        <div class="col">
            <div class="pull-left">
                {% if prev %}
                <a href="{{ prevUrl }}" class="btn btn-default">Previous</a>
                {% endif %}
            </div>
            <div class="pull-right">
                {% if next %}
                <a href="{{ nextUrl }}" class="btn btn-default pull-right">Next</a>
                {% endif %}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-6">
            <h4>IC Date: <b>{{ icdate }}</b></h4>
            <h4>Ticker: <b>{{ prospect.ticker }}</b></h4>
            <h4>Name: <b>{{ prospect.name }}</b></h4>
            <h4>
                <a href="{{ prospect.SWSurl }}" target="_blank">Company Information</a>
                <br>
                <small>
                    Simply Wall St login:<br>
                    un: portfolio@skyeam.com.au<br>
                    pw: skyeam
                </small>
            </h4>
            <input id="user_id" type="hidden" value="{{ sub_user ? sub_user.memberNo : user.memberNo }}">
            <input id="ticker" type="hidden" value="{{ prospect.ticker}}">
            <input id="masterID" type="hidden" value="{{ masterID }}">
            <input id="voting_ic_date" type="hidden" value="{{ icdate }}">
            <input id="allow_edit_as_admin" type="hidden" value="{{ user.isAdmin ? true : false}}">

        </div>
        <div class="col col-md-6">
                <h4 class="text-right">
                    Name: {{ sub_user ? sub_user.memberName : user.memberName}}</h4>
                <h4 class="text-right">Last modified: {{ dateModified }}</h4>
        </div>
    </div>


    <div class="row">
        <input id="is-finalised" type="hidden" value="{{ voting_values[0]['isFinalised'] }}">
        <input id="allow-edit" type="hidden" value="{{ allowEdit }}">
        <div class="col-sm-8 col-sm-offset-2 rb-box">
                    {% for key,voting_value in voting_values %}
                        {% if voting_value.factorSlider == 1 %}
                            <div class=" row text-center">
                                <div class="col">
                                    <p class="slider-info-text">Will significant upwards price momentum continue for 2-3
                                        months?</p>
                                </div>
                            </div>
                            <div class="row slider-holder">
                                <div class="col col-xs-4  col-xs-offset-4 col-md-2 col-md-offset-5">
                                    <label id="factor_label_5" class="form-control input-lg text-center">{{ voting_value.factorScore * 10 }}</label>
                                </div>
                            </div>
                            <div class="row slider-holder">
                                <div class="col col-xs-12">
                                    <input title="slider" type="range" min="1" max="100" id="factor_5"
                                           {% if voting_valu.isFinalised== '1' or allowEdit != '1' %}
                                    disabled
                                    {% endif %}
                                    value="{{ voting_value.factorScore * 10 }}" class="slider">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-xs-12">
                                    <span class="pull-left">0 – not likely/ insignificant/ <br>negative share price growth</span>
                                    <span class="pull-right">100 – likely/ significant<br> share price growth</span>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col col-xs-12 text-center">
                                    <img src="/assets/images/arrow_up.png"/>
                                    <p class="slider-info-text break-down">…breakdown of factors influencing slider</p>
                                </div>
                            </div>
                        {% else %}
                            <div class="row">
                                <div class="col col-xs-12">
                                    <p class="slider-info-text">{{voting_value.factorDashboardName}}</p>
                                </div>
                            </div>
                            <div class="row text-center voted-ticker-holder">
                                <div class="col col-xs-12 col-sm-4 radio-do-not-like">
                                    <label for="factor_id_{{voting_value.factorNo}}_0" class="radio-inline hide-on-xs">Don’t like it</label>
                                        <input class="ticker_click radio-voting radio-voting-do-not-like" type="radio" name="factor_{{voting_value.factorNo}}"
                                               id="factor_id_{{voting_value.factorNo}}_0" value="0"
                                               data-value="0" data-factor="{{ voting_value.factorNo }}"
                                               {% if allowEdit != '1' %} disabled {%endif%}
                                               {% if voting_value.factorScore == 0 %} checked {%endif%}>
                                    <label for="factor_id_{{voting_value.factorNo}}_0" class="radio-inline show-on-xs">Don’t like it</label>
                                </div>
                                <div class="col col-xs-12 col-sm-4 pull-left">
                                        <input class="ticker_click radio-voting radio-voting-pass" type="radio" name="factor_{{voting_value.factorNo}}"
                                               id="factor_id_{{voting_value.factorNo}}_null" value=""
                                               data-value="" data-factor="{{ voting_value.factorNo }}"
                                               {% if allowEdit != '1' %} disabled {%endif%}
                                               {% if voting_value.factorScore == '' %} checked {%endif%}>
                                    <label class="radio-inline" for="factor_id_{{voting_value.factorNo}}_null">Pass</label>

                                </div>
                                <div class="col col-xs-12 col-sm-4 radio-like">
                                        <input class="ticker_click radio-voting radio-voting-like" type="radio" name="factor_{{voting_value.factorNo}}"
                                               id="factor_id_{{voting_value.factorNo}}_10" value="10"
                                               data-value="10" data-factor="{{ voting_value.factorNo }}"
                                               {% if allowEdit != '1' %} disabled {%endif%}
                                               {% if voting_value.factorScore == 10 %} checked {%endif%}>
                                    <label class="radio-inline" for="factor_id_{{voting_value.factorNo}}_10">Like it</label>

                                </div>
                            </div>
                        {% endif %}
                    {% endfor %}
                        <div class="row">
                            <div class="col col-xs-12">
                                <p class="slider-info-text">8. Comment </p>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col  comment-text-area-holder">
                               <textarea cols="4"  id='textarea-veto' {% if allowEdit != '1' %} disabled {%endif%}
                                         class="comment-text-area">{{ voting_values[0]['vetoComment'] }}</textarea>
                            </div>
                            <div class="col col-sm-12 text-left save-comment">
                                <button id="save_vetoComment" class="btn btn-default btn-sm"
                                        {% if allowEdit != '1' %} disabled {%endif%}>Save Comment
                                </button>
                                <span id="veto-save-comment" class="alert-save  hidden">Successfully saved!</span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col col-xs-12">
                                <p class="slider-info-text">9. Finalise?
                                    <input class="radio-voting radio-voting-finalize" type="checkbox" name="finalise" id="voting-finalised"
                                           {% if voting_values[0]['isFinalised'] == 1 %} checked {%endif%}
                                          {% if enableFinalised == 0 %} disabled {%endif%}
                                    >
                                </p>
                            </div>
                        </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="mt-10">
                    {% if infoSheetURLExist %}
                    <iframe src="{{ infoSheetURL }}" onload="resizeIframe(this)"
                            scrolling="no"></iframe>
                    {% endif %}
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="mt-10">
                    {% if alexaImageURLExist %}
                    <img src="{{ alexaImageURL }}" alt="Alexa Data not found" height="100%"
                         width="100%"/>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>