<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>IC Dates</h1>
        </div>
        <div class="col-md-12 no-padding">
            <a class="btn btn-default pull-right mb-5" href="<?php echo base_url('add-ic-date')?>"> Add new Date </a>
        </div>

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