<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>Name: <?php echo $user['memberName']; ?></h1>
        </div>
    </div>

    <div class="row">
        <?php $finalised = 40; ?>
        <div class="col-sm-6">
            <label><?php echo $finalised . ('% Finalised') ?></label>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $finalised ?>"
                     aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $finalised; ?>%;">
                    <span class="sr-only"><?php echo $finalised . ('% Complete') ?></span>
                </div>
            </div>
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-sm-offset-3 col-sm-3">
            <div class="form-group">
                <label>For IC date</label>
                <select class="form-control ic_dates">
                    <?php foreach ($ic_dates as $value): ?>
                        <option value="<?php echo $ic_date = $value['icDate']; ?>">
                            <?php echo $value['icDate']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <a class="btn btn-primary pull-left" href="#"> Click here to see Investment Committee Completion
                Summary</a>
        </div>
        <div class="col-sm-offset-3 col-sm-3">

            <?php if ($user['isAdmin']): ?>
                <div class="form-group">
                    <label>Users</label>
                    <select class="form-control admin_users">
                        <?php foreach ($admin_users as $value): ?>
                            <?php if ($value['isAdmin']): ?>
                                <option selected value="<?php echo $value['memberNo']; ?>">
                                    <?php echo $value['memberName']; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $value['memberNo']; ?>">
                                    <?php echo $value['memberName']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="row">
        <div class="col">
            &nbsp;
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="-pull-left div-inline-block">DataTables Advanced Tables</div>
                    <div class="pull-right div-inline-block">
                        <a data-toggle="modal" data-target="#legendModal">
                            Legend
                        </a>
                        <!-- Modal -->
                        <div class="modal fade"
                             id="legendModal"
                             tabindex="-1"
                             role="dialog"
                             aria-labelledby="legendModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title" id="legendModalLabel">Legend</h4>
                                    </div>
                                    <div class="modal-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                                        culpa qui officia deserunt mollit anim id est laborum.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th data-toggle="tooltip" data-placement="top" title="Finalised" class="text-center">Fin
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Ticker">Ticker
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Name">Name
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Sector">Sector
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Country">Country
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Machine Rank">MR
                                <i class="fa fa-info-circle"></i></th>
                            <th>&nbsp;</th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Veto">Veto
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Business model">
                                Business
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip"
                                data-placement="top"
                                class="text-center"
                                title="Business valuation">Business
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip"
                                data-placement="top"
                                class="text-center"
                                title="Digital Footprint">Footprint
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip"
                                data-placement="top" class="text-center"
                                title="Significant uplft in addressable maret">Uplft <i class="fa fa-info-circle"></i>
                            </th>
                            <th data-toggle="tooltip"
                                data-placement="top"
                                class="text-center"
                                title="Competitor Analysis">Analysis
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" class="text-center" title="Risks">Risks
                                <i class="fa fa-info-circle"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($ic_dashboard as $index => $ic): ?>
                            <input class="hidden master_id" value="<?php echo $ic['masterID']; ?>">
                            <tr class="row_odd <?php echo $ic['isFinalised'] ? "row-finished" : '' ?>">
                                <td class="vcenter"><?php echo $index + 1; ?></td>
                                <td class="vcenter hcenter final">
                                    <button class="btn btn-default btn-circle finalised">
                                        <i class="fa <?php echo $ic['isFinalised'] ? "fa-check" : '' ?>"></i>
                                    </button>
                                </td>
                                <td class="vcenter ticker">
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['ticker']; ?></a>
                                </td>
                                <td class="vcenter">
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['name']; ?></a>
                                </td>
                                <td class="vcenter">
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['sector']; ?></a>
                                </td>
                                <td class="vcenter">
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['country']; ?></a>
                                </td>
                                <td class="vcenter">
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['machineRank']; ?></a>
                                </td>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10">This</p>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10">Prev</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="vcenter hcenter no-padding">
                                    <div class="cell_holder">
                                        <div class="cell_part">
                                            <button class="btn btn-default btn-circle veto">
                                                <i class="fa <?php echo $ic['vetoFlag'] ? "fa-check" : '' ?>"></i>
                                            </button>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part"></div>
                                    </div>
                                </td>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                                        <div class="cell_part mbt-5">
                                            <div class="form-group">
                                                <select class="form-control business-model">
                                                    <?php for ($i = 1; $i < 11; $i++): ?>
                                                        <?php if ($i == 1): ?>
                                                            <option value="<?php echo $i; ?>">1</option>
                                                        <?php elseif ($i == 10): ?>
                                                            <option value="<?php echo $i; ?>">10</option>
                                                        <?php elseif ($i == 5): ?>
                                                            <option value="<?php echo $i; ?>" selected>5</option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld1']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                                        <div class="cell_part mbt-5">
                                            <div class="form-group">
                                                <select class="form-control business-valuation">
                                                    <?php for ($i = 1; $i < 11; $i++): ?>
                                                        <?php if ($i == 1): ?>
                                                            <option value="<?php echo $i; ?>">1</option>
                                                        <?php elseif ($i == 10): ?>
                                                            <option value="<?php echo $i; ?>">10</option>
                                                        <?php elseif ($i == 5): ?>
                                                            <option value="<?php echo $i; ?>" selected>5</option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld2']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                                        <div class="cell_part mbt-5">
                                            <div class="form-group">
                                                <select class="form-control digital-footprint">
                                                    <?php for ($i = 1; $i < 11; $i++): ?>
                                                        <?php if ($i == 1): ?>
                                                            <option value="<?php echo $i; ?>">1</option>
                                                        <?php elseif ($i == 10): ?>
                                                            <option value="<?php echo $i; ?>">10</option>
                                                        <?php elseif ($i == 5): ?>
                                                            <option value="<?php echo $i; ?>" selected>5</option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld3']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                                        <div class="cell_part mbt-5">
                                            <div class="form-group">
                                                <select class="form-control uplift">
                                                    <?php for ($i = 1; $i < 11; $i++): ?>
                                                        <?php if ($i == 1): ?>
                                                            <option value="<?php echo $i; ?>">1</option>
                                                        <?php elseif ($i == 10): ?>
                                                            <option value="<?php echo $i; ?>">10</option>
                                                        <?php elseif ($i == 5): ?>
                                                            <option value="<?php echo $i; ?>" selected>5</option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld4']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                                        <div class="cell_part mbt-5">
                                            <div class="form-group">
                                                <select class="form-control competitor-analysis">
                                                    <?php for ($i = 1; $i < 11; $i++): ?>
                                                        <?php if ($i == 1): ?>
                                                            <option value="<?php echo $i; ?>">1</option>
                                                        <?php elseif ($i == 10): ?>
                                                            <option value="<?php echo $i; ?>">10</option>
                                                        <?php elseif ($i == 5): ?>
                                                            <option value="<?php echo $i; ?>" selected>5</option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld5']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                                        <div class="cell_part mbt-5">
                                            <div class="form-group">
                                                <select class="form-control risk">
                                                    <?php for ($i = 1; $i < 11; $i++): ?>
                                                        <?php if ($i == 1): ?>
                                                            <option value="<?php echo $i; ?>">1</option>
                                                        <?php elseif ($i == 10): ?>
                                                            <option value="<?php echo $i; ?>">10</option>
                                                        <?php elseif ($i == 5): ?>
                                                            <option value="<?php echo $i; ?>" selected>5</option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld6']; ?></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /#page-wrapper -->

