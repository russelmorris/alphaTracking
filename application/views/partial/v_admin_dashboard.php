<div id="page-wrapper dashboard">
    <div class="col-lg-12 col-md-12">
        <h2>Current Admin: Russel Morris</h2>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <label class="btn btn-primary btn-block" style="margin-bottom: 1%">
                Import prospect list <input id="pros" type="file" name="prospect" style="display: none;">
            </label>
<!--            <button class="btn btn-primary btn-block" style="margin-bottom: 1%">Import prospect list</button>-->
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-primary btn-block" style="margin-bottom: 1%">Import returns data</button>
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
                <?php for($i=1; $i < 10; $i++): ?>
                    <option value="<?php echo date('Y-m-d', strtotime('+' . $i . ' days', time())) ?>"><?php echo date('Y-m-d', strtotime('+' . $i . ' days', time())) ?></option>
                <?php endfor; ?>
                <!--<option>01 Jan 2018</option>
                <option>01 Feb 2018</option>
                <option>01 Mar 2018</option>
                <option>01 Apr 2018</option>
                <option>01 Maj 2018</option>
                <option selected>01 Jun 2018</option>-->
            </select>
        </div>
    </div>
    <!-- /.col-lg-6 -->

    <!-- /.row -->
    <div class="col-lg-12 col-md-12">
        <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
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

            <tr class="row_odd">
                <td class="text-center">1</td>
                <td class="text-center"><a href="#">Craig Burton</a></td>
                <!--In href will be passed route with the user id-->
                <td class="text-center">50%</td>
                <td class="text-center">02-Jun-2018</td>
                <td class="text-center">75%</td>
            </tr>
            <tr class="row_odd">
                <td class="text-center">2</td>
                <td class="text-center"><a href="#">Chris Briedahl</a></td>
                <td class="text-center">20%</td>
                <td class="text-center">02-Jun-2018</td>
                <td class="text-center">50%</td>
            </tr>
            <tr class="row_odd">
                <td class="text-center">3</td>
                <td class="text-center"><a href="#">Russel Morris</a></td>
                <td class="text-center">30%</td>
                <td class="text-center">02-Jun-2018</td>
                <td class="text-center">25%</td>
            </tr>
            <tr class="row_odd">
                <td class="text-center">4</td>
                <td class="text-center"><a href="#">Jason Davis</a></td>
                <td class="text-center">10%</td>
                <td class="text-center">02-Jun-2018</td>
                <td class="text-center">25%</td>
            </tr>
            </tbody>
        </table>
        <!-- /.panel -->
    </div>
</div>
<!-- /#page-wrapper -->

