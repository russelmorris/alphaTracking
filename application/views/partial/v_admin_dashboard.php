<div id="page-wrapper dashboard">
    <div class="col-lg-12 col-md-12">
        <h2>Current Admin: <?php echo $user['memberName'];?></h2>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <label class="btn btn-primary btn-block" style="margin-bottom: 1%">
                Import prospect list <i class="glyphicon glyphicon-import"></i><input id="prospect" type="file" name="prospect" style="display: none;">
            </label>
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
    <div class="col-md-6 pull-right">
        <div class="form-group">
            <label>For IC date</label>
            <select class="form-control">
                <?php for ($i = 0; $i <= 10; $i++): ?>
                    <option value="<?php echo date('Y-m-d',
                        strtotime('+' . $i . ' days', time())) ?>"><?php echo date('Y-m-d',
                            strtotime('+' . $i . ' days', time())) ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
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
<!-- /#page-wrapper -->

