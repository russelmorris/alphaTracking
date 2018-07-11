<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>Name: <?php echo $user['memberName']; ?></h1>
            <input id="dash_ajax"
                   type="text"
                   hidden
                   value="<?php echo uri_string() == 'admin_dashboard' ? false : true; ?>">
            <input id="allow_edit_as_admin"
                   hidden
                   value="<?php echo $user['isAdmin'] ? true : false; ?>">
        </div>
    </div>

    <div class="row">
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

