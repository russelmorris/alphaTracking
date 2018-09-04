<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>Add new IC Date</h1>
        </div>
        <div class="col-md-12">
            <form class="form-horizontal" method="post">
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <div class="form-group">
                    <label class="col-sm-4 control-label">IC Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" name="icDateDatePicker" id="icDateDatePicker"
                               class="form-control" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">StrategyNo</label>
                    <div class=" input-group col-sm-4 control-label">
                        <input class="form-control" name="strategyNo" id="strategyNo" placeholder="StrategyNo" type="number" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Plan Exec Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" name="planExecDateDataPicer" id="planExecDateDataPicer"
                               class="form-control" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4 ">Plan Next Exec Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" name="planNextExecDateDatePicker" id="planNextExecDateDatePicker"
                               class="form-control" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Portfolio Count</label>
                    <div class=" input-group col-sm-4 control-label">
                        <input class="form-control" name="portfolioCount" id="portfolioCount" placeholder="PortfolioCount" type="number"autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4 ">Machine Run Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" name="machineRunDateDatePicker" id="machineRunDateDatePicker"
                               class="form-control" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4 ">Next Machine Run Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" name="NextMachineRunDateDatePicker"  id="NextMachineRunDateDatePicker"
                               class="form-control" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-3 no-padding">
                        <button type="submit" class="btn btn-default">Create</button>
                        <p class="hidden text-success" id="help-block">IC Date has been created.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $( function() {
        $( "#icDateDatePicker" ).datepicker({
            dateFormat: "yy-mm-dd",
            });
    } );
    $( function() {
        $( "#planExecDateDataPicer" ).datepicker({
            dateFormat: "yy-mm-dd",
        });

    } );
    $( function() {
        $( "#planNextExecDateDatePicker" ).datepicker({
            dateFormat: "yy-mm-dd",
        });
    } );
    $( function() {
        $( "#machineRunDateDatePicker" ).datepicker({
            dateFormat: "yy-mm-dd",
        });
    } );
    $( function() {
        $( "#NextMachineRunDateDatePicker" ).datepicker({
            dateFormat: "yy-mm-dd",
        });
    } );
</script>