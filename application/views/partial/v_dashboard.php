<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1 id="user_name">Name: <?php echo $user['memberName']; ?></h1>
            <input id="dash_ajax"
                   type="text"
                   hidden
                   value="<?php echo uri_string() == 'admin-dashboard' ? false : true; ?>">
            <input id="allow_edit_as_admin"
                   hidden
                   value="<?php echo $user['isAdmin'] ? true : false; ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12">
                <label id="finalised-label">0.00% Finalised</label>
                <div class="progress">
                    <div id="finalised-value"
                         class="progress-bar"
                         role="progressbar"
                         aria-valuenow="0"
                         aria-valuemin="0"
                         aria-valuemax="100"
                         style="width: 0%">
                        <span class="sr-only"></span>
                    </div>

                </div>
                <input type="hidden" id="finalised-label-value" value="0">
                </div>
                <div class="col-sm-12">
                    <input type="button" class="btn btn-default" id="create-human-score" value="Create Human Score"/><br><br>
                    <input type="button" class="btn btn-default" id="finalize-all" value="Finalize all"/><br><br>
                </div>

            </div>

        </div>
        <div class="col-sm-4">
            <table class="table table-bordered conviction-table">
                <tr>
                    <td class="text-center">
                            Your estimate for global mkt
                        <br>returns 5 Nov to 3 Dec 2018
                    </td>
                    <td class="text-center">
                        Your virtual allocation to
                        <br><strong>your</strong> portfolio below Vs Cash
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-center">
                            <span id="mkt-value"(0.00%)</span>
                        </div>
                        <div>
                            <input id="mkt-slider" type="range" min="-10" max="10" step="0.01" value="0" class="slider">
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <span id="cash">0.00</span>% cash
                            </div>
                            <div class="col-sm-6 text-right">
                                <span id="equities">100.00</span>% equities
                            </div>
                        </div>
                        <div>
                            <input id="conviction-slider" type="range" min="0" max="100" step="0.01" value="0" class="slider">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-4">
            <div id="factor-chart-holder">
                <img id="factor-chart" class="factor-chart" src="/bottomUp/infoSheets/2018-11-05/factorCharts.jpg" />
            </div>
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>For IC date</label>
                        <select id="ic_dates" class="form-control ic_dates">
                            <?php foreach ($ic_dates as $value): ?>
                                <?php if (new DateTime($closest_icDate_from_today) == new DateTime($value['icDate'])): ?>
                                    <option selected value="<?php echo $value['icDate']; ?>">
                                        <?php echo $value['icDate']; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $value['icDate']; ?>">
                                        <?php echo $value['icDate']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 pull-right">
                    <?php if ($user['isAdmin']): ?>
                        <div class="form-group">
                            <label>Users</label>
                            <select class="form-control admin_users" id="ic-member">
                                <?php foreach ($admin_users as $value): ?>
                                    <option <?php if($selectedMemberNo == $value['memberNo']) {echo 'selected';}?> value="<?php echo $value['memberNo']; ?>">
                                        <?php echo $value['memberName'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <div class="row">
        <div class="col com-sm-12">
            <div class="ml-15">
                <p>"This Period there are <span id="prospectCount"></span> prospects and <span id="portfolioCount"></span> stocks to be included in the portfolio</p>
            </div>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="div-inline-block">DataTables Advanced Tables</div>
                        <div class="pull-right div-inline-block">1 = (I hate it), 10 = (I love it)</div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" id="dashboard-table-holder">
                        <div colspan="15" class="text-center">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

    </div>
</div>
<!-- /#page-wrapper -->

