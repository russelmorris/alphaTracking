<div id="page-wrapper dashboard">
    <div class="col-lg-12 col-md-12">
        <h2>Current Admin: <?php echo $user['memberName'];?></h2>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Import prospect list</button>
            <!--<label class="btn btn-primary btn-block" style="margin-bottom: 1%">
                Import prospect list <i class="glyphicon glyphicon-import"></i><input id="prospect" type="file" name="prospect" style="display: none;">
            </label>-->
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <label class="btn btn-primary btn-block" style="margin-bottom: 1%">
               Import returns data <i class="glyphicon glyphicon-import"></i> <input id="returns" type="file" name="returns" style="display: none;">
            </label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-primary btn-block" style="margin-bottom: 1%">Run queries to build master</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-primary btn-block" style="margin-bottom: 1%">Stats Page</button>
        </div>
    </div>

    <!-- /.col-lg-6 -->

    <!-- /.col-lg-6 -->

    <!-- /.row -->
    <div class="col-lg-12 col-md-12" >
        <table width="100%" class="table table-striped table-bordered table-hover " style="background: #FFFFFF" id="dataTables-example">
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
                    <td class="text-center"><a href="<?php echo base_url() . $value['memberNo'] ?>"><?php echo $value['memberName']; ?></a></td>
                    <td class="text-center"><?php echo rand(0, 100);?>%</td>
                    <td class="text-center">02-Jun-2018</td>
                    <td class="text-center"><?php echo $value['bWeight'] *100;?>%</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <!-- /.panel -->
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
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
                            <option value="<?php echo $value['icDate']; ?>">
                                <?php echo $value['icDate']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label class="btn btn-primary btn-block" style="margin-bottom: 1%">
                    Choose File <i class="glyphicon glyphicon-import"></i><input id="prospect" type="file" name="prospect" style="display: none;">
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-- /#page-wrapper -->

