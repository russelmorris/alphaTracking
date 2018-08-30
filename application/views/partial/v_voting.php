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
                <h4>Ticker: <b><?php echo $ticker; ?></b></h4>
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
                <input id="ticker" hidden value="<?php echo $ticker; ?>">
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
    <!-- _______________________________________________ Voting Part start _____________________________________________-->
    <!-- Radio Button Module -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="rb-box">
                <?php $listNumber = 0; ?>
                <?php foreach ($voting_values as $key => $voting_value){ ?>
                    <?php if ($voting_value['factorNo'] == 5) { ?>
                        <!--                        Slider Start-->

                        <p><?php echo ++$listNumber;?>. Overall momentum likely to continue? </p>
                        <div id="rb-1" class="rb">
                                <div id="factor5-pass" class="ticker_click rb-tab <?php echo $voting_value['factorScore'] == 0 ? 'rb-tab-active' : ''; ?> <?php if ($i == 0) {
                                    echo 'rb-null-element';
                                } ?>"
                                     data-value="<?php echo 0; ?>" data-factor="<?php echo $voting_value['factorNo'];?>">
                                    <span class="rb-spot"><span class="rb-txt rb-txt-na">Pass</span></span>
                                </div>
                               <label id="factor_label_5" class="slider_label_holder">
                                   <?php echo (($voting_value['factorScore']*10) !== 0) ? $voting_value['factorScore']*10: '';?>
                               </label>
                                <div class="slider-holder">
                                    <input  type="range" min="1" max="100" value="<?php echo $voting_value['factorScore']*10;?>" class="slider" id="factor_5">
                                </div>
                        </div>

                        <!--                        slider stop-->

                    <?php } else { ?>
                        <!--                        Round Buttons start     -->
                        <p><?php echo ++$listNumber;?>. <?php echo $voting_value['factorDesc'] ?> </p>
                        <div id="rb-1" class="rb">
                            <?php for ($i = 0; $i < 11; $i++): ?>
                                <div class="ticker_click rb-tab <?php echo $voting_value['factorScore'] == $i ? 'rb-tab-active' : ''; ?> <?php if ($i == 0) {
                                    echo 'rb-null-element';
                                } ?>"
                                     data-value="<?php echo $i; ?>" data-factor="<?php echo $voting_value['factorNo'];?>">
                                    <span class="rb-spot">
                                        <?php if ($i == 0) { ?>
                                            <span class="rb-txt rb-txt-na">Pass</span>
                                        <?php } else { ?>
                                            <span class="rb-txt"><?php echo $i; ?></span>
                                        <?php } ?>
                                    </span>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <!--round buttons end -->
                    <?php }?>
                <?php }?>

                <p><?php echo ++$listNumber;?>. Veto (optional)</p>
                <div id="veto" class="rb-7 rb <?php echo $voting_values[0]['vetoFlag'] == 1 ? 'rb-tab-active' : ''; ?>">
                    <div id="veto-data-value" class="rb-tab veto_click" data-value="<?php echo $voting_values[0]['vetoFlag'] == 1 ? '1' : '0'; ?>">
                        <div class="rb-spot">
                            <span class="rb-txt"><?php echo $voting_values[0]['vetoFlag'] == 1 ? 'Yes' : 'No'; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 tarea veto_togle <?php echo $voting_values[0]['vetoFlag'] == 1 ? '' : 'hidden'; ?> "
                             style="padding-top: 2%">
                            <p class="sub-header-comment">Comment</p>
                            <textarea id='textarea-veto' placeholder="Explain wshy?" class="form-control">
                                <?php echo ! is_null($voting_values[0]['vetoComment']) ?
                                    $voting_values[0]['vetoComment'] : ''; ?>
                            </textarea>
                            <div class="row">
                                <div class="col-md-2">
                                <button id="save_vetoComment" class="btn btn-default btn-sm mt-10">Save Comment</button>
                                </div>
                                <div class="col-md-10">
                                    <p id="veto-save-comment" class=" alert-save  hidden">Successfully saved!</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <p><?php echo ++$listNumber;?>. Deeper Dive Required? (optional)</p>
                <div id="deep-dive" class="rb-7 rb <?php echo $voting_values[0]['isDeepDive'] == 1 ? 'rb-tab-active' : ''; ?>">
                    <div id="deep-dive-data-value" class="rb-tab deep_dive_click" data-value="<?php echo $voting_values[0]['isDeepDive'] == 1 ? '1' : '0'; ?>">
                        <div class="rb-spot">
                            <span class="rb-txt"><?php echo $voting_values[0]['isDeepDive'] == 1 ? 'Yes' : 'No'; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 tarea deep_dive_togle <?php echo $voting_values[0]['isDeepDive'] == 1 ? '' : 'hidden'; ?> "
                             style="padding-top: 2%">
                            <p class="sub-header-comment">Comment</p>
                            <textarea id='textarea-deep-dive' placeholder="Explain wshy?" class="form-control">
                                <?php echo ! is_null($voting_values[0]['deepDiveComment']) ?
                                    $voting_values[0]['deepDiveComment'] : ''; ?>
                            </textarea>
                            <div class="row">
                                <div class="col-md-2">
                                    <button id="deepDiveComment" class="btn btn-default btn-sm mt-10">Save Comment</button>
                                </div>
                                <div class="col-md-10">
                                    <p id="deep-dive-save-comment" class=" alert-save  hidden">Successfully saved!</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <p><?php echo ++$listNumber;?>. Finalise?</p>
                <div id="rb-8" class="rb <?php echo $voting_values[0]['isFinalised'] == 1 ? 'rb-tab-active' : ''; ?>">
                    <div class="rb-tab" data-value="<?php echo $voting_values[0]['isFinalised'] == 1 ? '1' : '0'; ?>">
                        <div class="rb-spot">
                            <span class="rb-txt"><?php echo $voting_values[0]['isFinalised'] == 1 ? 'Yes' : 'No'; ?></span>
                        </div>
                    </div>
                </div>

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
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            No Info Sheet Found
                        </div>
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
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            Alexa Data not found
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

<!--        <div class="row">-->
<!--            <div class="col-md-8 col-md-offset-2">-->
<!--                <div class="mt-10">-->
<!--                    --><?php //if ($googleImageURLExist == true) { ?>
<!--                        <img src="--><?php //echo base_url($googleImageURL); ?><!--" alt="Alexa Data not found" height="100%"-->
<!--                             width="100%"/>-->
<!--                    --><?php //} else { ?>
<!--                        <div class="alert alert-danger" role="alert">-->
<!--                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>-->
<!--                            Google Trends Data not found-->
<!--                        </div>-->
<!--                    --><?php //} ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>