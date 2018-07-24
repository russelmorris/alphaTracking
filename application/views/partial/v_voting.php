<div id="page-wrapper dashboard">
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
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="rb-box">
                <!-- Radio Button Module -->
                <p>1. Business Model (sustainable, high margin, well executed) </p>
                <?php if ($voting_values[0]['factorNo'] == 1): ?>
                    <div id="rb-1" class="rb">
                        <?php for ($i = 1; $i < 11; $i++): ?>
                            <div class="rb-tab <?php echo $voting_values[0]['factorScore'] == $i ? 'rb-tab-active' : ''; ?>"
                                 data-value="<?php echo $i; ?>">
                                <div class="rb-spot">
                                    <span class="rb-txt"><?php echo $i; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

                <!-- Radio Button Module -->
                <p>2. Value vs current price</p>
                <?php if ($voting_values[1]['factorNo'] == 2): ?>
                    <div id="rb-2" class="rb">
                        <?php for ($i = 1; $i < 11; $i++): ?>
                            <div class="rb-tab <?php echo $voting_values[1]['factorScore'] == $i ? 'rb-tab-active' : ''; ?>"
                                 data-value="<?php echo $i; ?>">
                                <div class="rb-spot">
                                    <span class="rb-txt"><?php echo $i; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
                <!-- Radio Button Module -->
                <p>3. Digital Footprint (growing in web traffic/ app downloads/ trends</p>
                <?php if ($voting_values[2]['factorNo'] == 3): ?>
                    <div id="rb-3" class="rb">
                        <?php for ($i = 1; $i < 11; $i++): ?>
                            <div class="rb-tab <?php echo $voting_values[2]['factorScore'] == $i ? 'rb-tab-active' : ''; ?>"
                                 data-value="<?php echo $i; ?>">
                                <div class="rb-spot">
                                    <span class="rb-txt"><?php echo $i; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
                <!-- Radio Button Module -->
                <p>4. Upside in capturing unexploited markets (geography or x-selling extra products)</p>
                <?php if ($voting_values[3]['factorNo'] == 4): ?>
                    <div id="rb-4" class="rb">
                        <?php for ($i = 1; $i < 11; $i++): ?>
                            <div class="rb-tab <?php echo $voting_values[3]['factorScore'] == $i ? 'rb-tab-active' : ''; ?>"
                                 data-value="<?php echo $i; ?>">
                                <div class="rb-spot">
                                    <span class="rb-txt"><?php echo $i; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
                <!-- Radio Button Module -->
                <p>5. Competitor Analysis</p>
                <?php if ($voting_values[4]['factorNo'] == 5): ?>
                    <div id="rb-5" class="rb">
                        <?php for ($i = 1; $i < 11; $i++): ?>
                            <div class="rb-tab <?php echo $voting_values[4]['factorScore'] == $i ? 'rb-tab-active' : ''; ?>"
                                 data-value="<?php echo $i; ?>">
                                <div class="rb-spot">
                                    <span class="rb-txt"><?php echo $i; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
                <!-- Radio Button Module -->
                <p>6. Risks</p>
                <?php if ($voting_values[5]['factorNo'] == 6): ?>
                    <div id="rb-6" class="rb">
                        <?php for ($i = 1; $i < 11; $i++): ?>
                            <div class="rb-tab <?php echo $voting_values[5]['factorScore'] == $i ? 'rb-tab-active' : ''; ?>"
                                 data-value="<?php echo $i; ?>">
                                <div class="rb-spot">
                                    <span class="rb-txt"><?php echo $i; ?></span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
                <p>7. Veto (optional)</p>
                <div id="rb-7" class="rb <?php echo $voting_values[0]['vetoFlag'] == 1 ? 'rb-tab-active' : ''; ?>">
                    <div class="rb-tab " data-value="<?php echo $voting_values[0]['vetoFlag'] == 1 ? '1' : '0'; ?>">
                        <div class="rb-spot">
                            <span class="rb-txt"><?php echo $voting_values[0]['vetoFlag'] == 1 ? 'Yes' : 'No'; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 tarea <?php echo $voting_values[0]['vetoFlag'] == 1 ? '' : 'hidden'; ?> "
                             style="padding-top: 2%">
                            <textarea placeholder="Explain why?" class="form-control">
                                <?php echo ! is_null($voting_values[0]['vetoComment']) ?
                                    $voting_values[0]['vetoComment'] : ''; ?>
                            </textarea>
                            <button id="save_vetoComment" class="btn btn-default btn-sm mt-10">Save Comment</button>
                            <div id="alert_save_success"
                                 style="width:25%"
                                 class="mt-10 alert alert-success alert-dismissible fade in text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Successfully saved!</strong>
                            </div>
                            <div id="alert_save_fail"
                                 style="width:25%"
                                 class="mt-10 alert alert-danger alert-dismissible fade in text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Successfully saved!</strong>
                            </div>

                        </div>
                    </div>
                </div>
                <p>8. Finalise?</p>
                <div id="rb-8" class="rb <?php echo $voting_values[0]['isFinalised'] == 1 ? 'rb-tab-active' : ''; ?>">
                    <div class="rb-tab" data-value="<?php echo $voting_values[0]['isFinalised'] == 1 ? '1' : '0'; ?>">
                        <div class="rb-spot">
                            <span class="rb-txt"><?php echo $voting_values[0]['isFinalised'] == 1 ? 'Yes' : 'No'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="mt-10">
                <?php if (
                file_exists("bottomUp/infoSheets/" . $icdate . "/" .
                            $voting_values[0]['prospectTextID'] . ".htm")): ?>
                    <iframe src="<?php
                    echo base_url("bottomUp/infoSheets/" . $icdate . "/" .
                                  $voting_values[0]['prospectTextID'] . ".htm") ?>"
                            onload="resizeIframe(this)"
                            scrolling="no"></iframe>
                <?php elseif (file_exists("bottomUp/infoSheets/" . $icdate . "/" .
                                          str_replace(" ", "",
                                              strtolower($icdate . '-' . $ticker . '-' . $voting_values[0]['country'])) . ".htm")): ?>
                    <iframe src="<?php
                    echo base_url("bottomUp/infoSheets/" . $icdate . "/" .
                                  str_replace(" ", "",
                                      strtolower($icdate . '-' . $ticker . '-' . $voting_values[0]['country'])) . ".htm") ?>"
                            onload="resizeIframe(this)"
                            scrolling="no"></iframe>
                <?php else: ?>
                    <h3 class="text-center text-info">No Info Sheet Found</h3>
                <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="mt-10">
                <img src="http://disrupterfund.com.au/bottomUp/digiFootprint/alexa/2018-03-31/2018-03-31-pph-newzealand-alexa.jpg" height="100%" width="100%" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="mt-10">
                <img src="http://disrupterfund.com.au/bottomUp/digiFootprint/googletrends/2018-03-31/2018-03-31-pph-newzealand-googletrends.jpg" height="100%" width="100%" />
            </div>
        </div>
    </div>
</div>