<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>Add new IC Date</h1>
        </div>
        <div class="col-md-12">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label">IC Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">StrategyNo</label>
                    <div class=" input-group col-sm-4 control-label">
                        <input class="form-control" placeholder="StrategyNo" type="number">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Plan Exec Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4 ">Plan Next Exec Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Portfolio</label>
                    <div class=" input-group col-sm-4 control-label">
                        <input class="form-control" placeholder="PortfolioCount" type="number">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4 ">Machine Run Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4 ">Next Machine Run Date</label>
                    <div class="input-group date col-sm-4 control-label" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-3 no-padding">
                        <button type="button" onclick="addNewICDate()" class="btn btn-default">Create</button>
                        <p class="hidden text-success" id="help-block">IC Date has been created.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

