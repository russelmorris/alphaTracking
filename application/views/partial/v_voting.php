<div id="page-wrapper dashboard">
    <div class="row mt-10">
        <div class="col col-sm-6">
            <?php if (!empty($prev)) { ?>
                <a href="<?php echo base_url('/voting/' . $icdate . '/' . $prev); ?>"
                   class="btn btn-default">Previous</a>
            <?php } ?>
        </div>
        <div class="col col-sm-6">
            <?php if (!empty($next)) { ?>
                <a href="<?php echo base_url('/voting/' . $icdate . '/' . $next); ?>"
                   class="btn btn-default pull-right">Next</a>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <h4>IC Date: <b><?php echo $icdate; ?></b></h4>
                <h4>Ticker: <b><?php echo $prospect['ticker']; ?></b></h4>
                <h4>Name: <b><?php echo $prospect['name']; ?></b></h4>
                <h4>
                    <a href="<?php echo $prospect['SWSurl']; ?>"
                       target="_blank">
                        Company Information</a>
                    <br>
                    <small>
                        Simply Wall St login:<br>
                        un: portfolio@skyeam.com.au<br>
                        pw: skyeam
                    </small>
                </h4>
                <input id="user_id" hidden value="<?php echo $sub_user ? $sub_user['memberNo'] : $user['memberNo']; ?>">
                <input id="ticker" hidden value="<?php echo $prospect['ticker']; ?>">
                <input id="masterID" hidden  value="<?php echo $masterID; ?>">
                <input id="voting_ic_date" hidden value="<?php echo $icdate; ?>">
                <input id="allow_edit_as_admin"
                       hidden
                       value="<?php echo $user['isAdmin'] ? true : false; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <h4 class="text-right">
                    Name: <?php echo $sub_user ? $sub_user['memberName'] : $user['memberName']; ?></h4>
                <h4 class="text-right">Last modified: <?php echo $dateModified; ?></h4>
            </div>
        </div>
    </div>


<!--     _______________________________________________ Voting Part start _____________________________________________-->
<!--     Radio Button Module-->
    <div class="row">
        <input id="is-finalised" type="hidden" value="<?php echo $voting_values[0]['isFinalised'];?>">
        <input id="allow-edit" type="hidden" value="<?php echo $allowEdit;?>">
        <div class="col-md-8 col-md-offset-2">
            <div class="container rb-box">
                {% for key,voting_value in voting_values %} {
                    {% if voting_value.factorSlider == 1 %}
                        <div class="row">
                            <div class="col col-sm-12">
                                <div class="text-center">Will significant upwards price momentum continue for 2-3 months?</div>
                                <div class="slider-holder">
                                    <input type="range" min="1" max="100"
                                           value="{{ voting_value.factorScore * 10 }}" class="slider"
                                           {% if voting_value.isFinalised== 1 || allowEdit !== 1 %}
                                           disabled
                                           {% endif %}
                                    >
                                </div>
                            </div>
                        </div>
                    {% endif %}
                {% endfor %}
            </div>
        </div>
        <!-- _______________________________________________ Voting Part end ______________________________________________-->

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="mt-10">
                    <?php if ($infoSheetURLExist == true) { ?>
                        <iframe src="<?php echo base_url($infoSheetURL) ?>" onload="resizeIframe(this)"
                                scrolling="no"></iframe>
                    <?php } else { ?>
<!--                        <div class="alert alert-danger" role="alert">-->
<!--                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>-->
<!--                            No Info Sheet Found-->
<!--                        </div>-->
                    <?php } ?>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="mt-10">
                    <?php if ($alexaImageURLExist == true) { ?>
                        <img src="<?php echo base_url($alexaImageURL); ?>" alt="Alexa Data not found" height="100%"
                             width="100%"/>
                    <?php } else { ?>
<!--                        <div class="alert alert-danger" role="alert">-->
<!--                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>-->
<!--                            Alexa Data not found-->
<!--                        </div>-->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>