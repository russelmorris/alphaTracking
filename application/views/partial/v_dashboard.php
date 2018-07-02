<div id="page-wrapper dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>Name: <?php echo $user['memberName']; ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-sm-6">
            <label><?php echo $finalised . ('% Finalised')?></label>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $finalised?>"
                     aria-valuemin="0" aria-valuemax="100" style="<?php echo ('width:'). $finalised;?>">
                    <span class="sr-only"><?php echo $finalised . ('% Complete')?></span>
                </div>
            </div>
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-sm-offset-3 col-sm-3">
            <div class="form-group">
                <label>For IC date</label>
                <select class="form-control">
                    <?php for ($i = 0; $i < 15; $i++): ?>
                        <option value="<?php $ic_date = date('Y-m-d',
                            strtotime('+' . $i . ' days', time())) ?>"><?php echo date('Y-m-d',
                                strtotime('+' . $i . ' days', time())) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary pull-left" href="#"> Click here to see Investment Committee Completion Summary</a>
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
                <p class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th data-toggle="tooltip" data-placement="top" title="Finalised">Fin
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Ticker">Ticker
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Name">Name
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Sector">Sector
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Country">Country
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Machine Rank">MR
                                <i class="fa fa-info-circle"></i></th>
                            <th>&nbsp;</th>
                            <th data-toggle="tooltip" data-placement="top" title="Veto">Veto
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Business model">Business
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Business valuation">Business
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Digital Footprint">Footprint
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip"
                                data-placement="top"
                                title="Significant uplft in addressable maret">Uplft <i class="fa fa-info-circle"></i>
                            </th>
                            <th data-toggle="tooltip" data-placement="top" title="Competitor Analysis">Analysis
                                <i class="fa fa-info-circle"></i></th>
                            <th data-toggle="tooltip" data-placement="top" title="Risks">Risks
                                <i class="fa fa-info-circle"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($ic_dash as $index => $ic): ?>
                        <tr class="row_odd <?php echo $ic['isFinalised'] ? "row-finished" : '' ?>">
                            <td class="vcenter"><?php echo $index + 1; ?></td>
                            <td class="vcenter hcenter">
                                <button type="button" class="btn btn-default btn-circle" onclick="submitData(<?php echo ($index + 1);?>)">
                                    <i class="fa <?php echo $ic['isFinalised'] ? "fa-check" : '' ?>"></i>
                                </button>
                            </td>
                            <td class="vcenter">
                                <?php if ($ic['isFinalised']): ?>
                                    <?php echo $ic['ticker']; ?>
                                <?php else: ?>
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['ticker']; ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="vcenter">
                                <?php if ($ic['isFinalised']): ?>
                                    <?php echo $ic['name']; ?>
                                <?php else: ?>
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['name']; ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="vcenter">
                                <?php if ($ic['isFinalised']): ?>
                                    <?php echo $ic['sector']; ?>
                                <?php else: ?>
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['sector']; ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="vcenter">
                                <?php if ($ic['isFinalised']): ?>
                                    <?php echo $ic['country']; ?>
                                <?php else: ?>
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['country']; ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="vcenter">
                                <?php if ($ic['isFinalised']): ?>
                                    <?php echo $ic['machineRank']; ?>
                                <?php else: ?>
                                    <a href="<?php echo base_url("voting/2018-10-05/" . $ic['ticker']); ?>"><?php echo $ic['machineRank']; ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="no-padding">
                                <div class="cell_holder">
                                    <div class="cell_part">
                                        <p class="mt-10">This</p>
                                    </div>
                                    <div class="cell_part_hr"></div>
                                    <div class="cell_part">
                                        <p class="mt-10">Prev</p>
                                    </div>
                                </div>
                            </td>
                            <td class="vcenter hcenter no-padding">
                                <div class="cell_holder">
                                    <div class="cell_part">
                                        <div class="round">
                                            <input type="checkbox" id="<?php echo 'checkbox'. ($index + 1)?>" />
                                            <label for="<?php echo 'checkbox'. ($index + 1)?>"></label>
                                        </div>
                                        <!--<button type="button" class="btn btn-default btn-circle">
                                            <i class="fa <?php /*echo $ic['vetoFlag'] ? "fa-check" : '' */?>"></i>
                                        </button>-->
                                    </div>
                                    <div class="cell_part_hr"></div>
                                    <div class="cell_part"><?php echo $ic['vetoFlag'] ? "Yes" : "No" ?></div>
                                </div>
                            </td>
                            <?php for ($i = 0; $i < 6; $i++): ?>
                                <td class="no-padding">
                                    <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT); ?></span>
                                        <div class="cell_part <?php echo $ic['isFinalised'] ? "" : 'mbt-5' ?>">
                                            <?php if ($ic['isFinalised']): ?>
                                                <p class="mt-10<?php echo $ic['isFinalised'] ? "" : 'hidden' ?>"><?php echo rand(1,
                                                        10); ?></p>
                                            <?php else: ?>
                                                <div class="form-group">
                                                    <select class="form-control">
                                                        <option value="<?php echo rand(1, 10)?>" <?php echo rand(1, 10) == 1 ? "selected" : '' ?> >1(hate it)</option>
                                                        <option <?php echo rand(1, 10) == 2 ? "selected" : '' ?>>2</option>
                                                        <option <?php echo rand(1, 10) == 3 ? "selected" : '' ?>>3</option>
                                                        <option <?php echo rand(1, 10) == 4 ? "selected" : '' ?>>4</option>
                                                        <option <?php echo rand(1, 10) == 5 ? "selected" : '' ?>>5</option>
                                                        <option <?php echo rand(1, 10) == 6 ? "selected" : '' ?>>6</option>
                                                        <option <?php echo rand(1, 10) == 7 ? "selected" : '' ?>>7</option>
                                                        <option <?php echo rand(1, 10) == 8 ? "selected" : '' ?>>8</option>
                                                        <option <?php echo rand(1, 10) == 9 ? "selected" : '' ?>>9</option>
                                                        <option <?php echo rand(1, 10) == 10 ? "selected" : '' ?>>10(love it)</option>
                                                    </select>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="cell_part_hr"></div>
                                        <div class="cell_part">
                                            <p class="mt-10">NA</p>
                                        </div>
                                    </div>
                                </td>
                            <?php endfor; ?>
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

