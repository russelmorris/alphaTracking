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
                            <div class="row">
                                <div class="col">
                                    <input type="text" value="{{ voting_value.factorScore * 10 }}" class="slider-value-holder">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="range" min="1" max="100"
                                           {% if voting_value.isFinalised== '1' or allowEdit != '1' %}
                                    disabled
                                    {% endif %}
                                    value="{{ voting_value.factorScore * 10 }}" class="slider">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="pull-left">0 – not likely/ insignificant/ <br>negative share price growth</span>
                                    <span class="pull-right">100 – likely/ significant<br> share price growth</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <img src="/assets/images/arrow_up.png"/>
                                    <p class="slider-info-text">…breakdown of factors influencing slider</p>
                                </div>
                            </div>
                        {% else %}
                            <div class="row">
                                <div class="col">
                                    <p class="slider-info-text">{{voting_value.factorDashboardName}}</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col">
                                    <label class="radio-inline ml-15">
                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Don’t like it
                                    </label>
                                    <label class="radio-inline ml-15">
                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Pass
                                    </label>
                                    <label class="radio-inline ml-15">
                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3"> Like it
                                    </label>
                                </div>
                            </div>
                        {% endif %}
                    {% endfor %}
                        <div class="row">
                            <div class="col">
                                <p class="slider-info-text">8. Comment</p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col">
                               <textarea cols="4" class="comment-text-area">testset</textarea>
                            </div>
                        </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="mt-10">
                    {% if infoSheetURLExist %}
                    <iframe src="<?php echo base_url($infoSheetURL) ?>" onload="resizeIframe(this)"
                            scrolling="no"></iframe>
                    {% endif %}
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="mt-10">
                    {% if alexaImageURLExist %}
                    <img src="<?php echo base_url($alexaImageURL); ?>" alt="Alexa Data not found" height="100%"
                         width="100%"/>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>