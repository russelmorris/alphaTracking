<div id="page-wrapper dashboard">
    <?php if ($user['isAdmin'] == 1 ){ ?>
    <div class="col-lg-12 col-md-12">
        <h2>Current Admin: <?php echo $user['memberName']; ?></h2>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button type="button"
                    class="btn btn-primary btn-block mbt-5"
                    data-toggle="modal"
                    data-target="#prospectModal">Import
                prospect list
            </button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button type="button"
                    class="btn btn-primary btn-block mbt-5"
                    data-toggle="modal"
                    data-target="#returnModal">Import
                return list
            </button>

        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button data-toggle="modal"
                    data-target="#queriesModal" class="btn btn-primary btn-block mbt-5">Build Portfolios</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-primary btn-block mbt-5">Stats Page</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button id="create_googletrends_cvs" class="btn btn-primary btn-block mbt-5">Create Google CSV files</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button id="crate_alexa_cvs" class="btn btn-primary btn-block mbt-5">Create Alexa CSV files</button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-8 col-md-offset-2">
            &nbsp;
        </div>
    </div>
    <!-- /.col-lg-6 -->

    <!-- /.col-lg-6 -->

    <!-- /.row -->
<?php } ?>
    <div class="col-lg-12 col-md-12">
        <table width="100%"
               class="table table-striped table-bordered table-hover "
               style="background: #FFFFFF"
               id="dataTables-example">
            <thead>
            <tr>
                <th colspan="5" class="text-center">Summary of IC members</th>
            </tr>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">IC Member Name</th>
                <th class="text-center">Finalised (%)</th>
                <th class="text-center">Last Edited</th>
                <th class="text-center">bWeight</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $key => $value): ?>
                <tr class="<?php echo ($value['isActive']) ? 'success' : '' ?>">
                    <td class="text-center"><?php echo $key + 1; ?></td>
                    <!--In href will be passed route with the user id-->
                    <td class="text-center">
                        <a href="<?php echo base_url('dashboard') ?>"><?php echo $value['memberName']; ?></a>
                    </td>
                    <td class="text-center"><?php echo $value['finalise_overall']; ?>%</td>
                    <td class="text-center"><?php echo date('d-M-Y', strtotime($value['last_edited'])); ?></td>
                    <td class="text-center"><?php echo $value['bWeight'] * 100; ?>%</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <!-- /.panel -->
    </div>
</div>

<div id="prospectModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Prospects</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>For IC date</label>
                    <select class="form-control import_date">
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
                <label class="btn btn-primary btn-block" style="margin-bottom: 1%">
                    Choose File <i class="glyphicon glyphicon-import"></i>
                    <input id="prospect" type="file" name="prospect" style="display: none;">
                </label>
                <button id="upload-prospects" disabled class="btn btn-primary btn-block"> Upload</button>
                <div id="alert-success" class="alert alert-success alert-dismissible fade in text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Successfully uploaded!</strong>
                </div>
                <div id="alert-danger" class="alert alert-danger alert-dismissible fade in text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error in uploading! Please check the fields of your CSV file</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="returnModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Returns</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>For IC date</label>
                    <select class="form-control import_date">
                        <?php foreach ($ic_dates as $value): ?>
                            <option value="<?php echo $value['icDate']; ?>">
                                <?php echo $value['icDate']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label class="btn btn-primary btn-block" style="margin-bottom: 1%">
                    Choose File <i class="glyphicon glyphicon-import"></i>
                    <input id="returns" type="file" name="returns" style="display: none;">
                </label>
                <button id="upload-return" disabled class="btn btn-primary btn-block"> Upload</button>
                <div id="alert-success-return" class="alert alert-success alert-dismissible fade in text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Successfully uploaded!</strong>
                </div>
                <div id="alert-danger-return" class="alert alert-danger alert-dismissible fade in text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error in uploading! Please check the fields of your CSV file</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="queriesModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Run Queries</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>For IC date</label>
                    <select class="form-control query_ic_date">
                        <?php foreach ($ic_dates as $value): ?>
                            <?php if (strtotime($value['icDate']) >= strtotime('today')): ?>
                                <option value="<?php echo $value['icDate']; ?>">
                                    <?php echo $value['icDate']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button id="query_build" class="btn btn-primary btn-block"> Run</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-- /#page-wrapper -->

