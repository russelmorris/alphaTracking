<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>IC Dates</h1>
        </div>

        <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th data-toggle="tooltip" data-placement="top" title="icDate" class="text-center">icDate
                <th data-toggle="tooltip" data-placement="top" title="strategyNo" class="text-center">StrategyNo
                <th data-toggle="tooltip" data-placement="top" title="planExecDate" class="text-center">Plan Exec Date
                <th data-toggle="tooltip" data-placement="top" title="planNextExecDate" class="text-center">Plan Next
                    Exec Date
                <th data-toggle="tooltip" data-placement="top" title="portfolioCount" class="text-center">Portfolio
                    Count
                <th data-toggle="tooltip" data-placement="top" title="machineRunDate" class="text-center">Machine Run
                    Date
                <th data-toggle="tooltip" data-placement="top" title="nextMachineRunDate" class="text-center">Next
                    Machine Run Date
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