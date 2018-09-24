<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>IC Dates</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-6">
            <div class="form-group form-inline no-padding">
                <label for="current-ic-date"><h4>Current ICDate:</h4> </label>
                <select class="form-control" id="current-ic-date">
                    <?php foreach ($ic_dates as $ic_date) { ?>
                        <option><?php echo $ic_date['icDate'] ?></option>
                    <?php } ?>
                </select>
                <button class="btn btn-primary" type="button"> Set Curenet date</button>
            </div>
        </div>
        <div class="col-md-6 no-padding pull-right">
            <a class="btn btn-primary pull-right mb-5" href="<?php echo base_url('add-ic-date') ?>"> Add new Date </a>
        </div>
    </div>
    <div class="row">
        <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center">icDate</th>
                <th class="text-center">StrategyNo</th>
                <th class="text-center">Plan Exec Date</th>
                <th class="text-center">Plan NextExec Date</th>
                <th class="text-center">PortfolioCount</th>
                <th class="text-center">Machine Run Date</th>
                <th class="text-center">Next Machine Run Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ic_dates as $ic_date) { ?>
                <tr>
                    <td><?php echo $ic_date['icDate']; ?></td>
                    <td><?php echo $ic_date['strategyNo']; ?></td>
                    <td><?php echo $ic_date['planExecDate']; ?></td>
                    <td><?php echo $ic_date['planNextExecDate']; ?></td>
                    <td><?php echo $ic_date['portfolioCount']; ?></td>
                    <td><?php echo $ic_date['machineRunDate']; ?></td>
                    <td><?php echo $ic_date['nextMachineRunDate']; ?></td>
                </tr>
            <?php }; ?>
            </tbody>
        </table>

    </div>
</div>