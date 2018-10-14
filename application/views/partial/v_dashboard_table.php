<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th data-toggle="tooltip" data-placement="top" title="Included in Portfolio" class="text-center">In?
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" title="Finalised" class="text-center">Fin
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Ticker">Ticker
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Name">Name
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Sector">Sector
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Country">Country
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Machine Rank">MR
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Human Score">HS
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Human Rank">HR
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" WIDTH="30%" title="Overall growth likely to continue?">Going up?
            <i class="fa fa-info-circle"></i></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($ic_dashboard as $index => $ic): ?>

        <tr class="row_odd <?php echo $ic['isFinalised'] ? "row-finished" : '' ?>" id="tr_<?php echo $ic['ticker']; ?>">

            <td class="vcenter final"><?php echo $index + 1; ?>
            </td>
            <td class="vcenter">
                <span style="display: none;"><?php echo $ic['inPortfolio'];?></span>
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>">
                    <?php echo $ic['inPortfolio'] == '1' ?
                        '<span class="in-portfolio glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>':
                        '<span class="out-portfolio glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?>
                </a>
            </td>
            <td class="vcenter hcenter final final-dis"><span class="hidden"><?php echo $ic['isFinalised']?></span>
                <button class="btn btn-default btn-circle finalised"
                        onclick="updateFinalise('<?php echo $ic['masterID']; ?>', this)">
                    <i class="fa <?php echo $ic['isFinalised'] ? "fa-check" : '' ?>"></i>
                </button>
            </td>
            <td class="vcenter ticker final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>"><?php echo $ic['ticker']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>"><?php echo $ic['name']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>"><?php echo $ic['sector']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>"><?php echo $ic['country']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>"><?php echo $ic['machineRank']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>">
                    <?php echo is_null($ic['humanZScore']) ? 0 :  round($ic['humanZScore'], 2); ?>
                </a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['masterID']); ?>">
                    <?php echo is_null($ic['humanRank']) ? 0 :  round($ic['humanRank'], 2); ?>
                </a>
            </td>
             <td class="no-padding">
                <div class="cell_holder">
                    <div class="cell_part mbt-5">
                        <div class="form-group col-sm-12">
                            <span class="dashboard-slider-5-text"><?php echo ($ic['factorScore5'] == 0)? '-': $ic['factorScore5']*10; ?></span>
                            <input onchange="updateTicker('<?php echo $ic['masterID']; ?>', 5,  this.value/10, this)"
                                   type="range" min="1" max="100" value="<?php echo $ic['factorScore5']*10;?>" class="slider slider_5 ticker_<?php echo $ic['ticker']; ?>"
                                <?php if ($ic['isFinalised'] == 1) {
                                    echo ' disabled ';
                                } ?>>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php /*endif; */ ?>

<script>
    table = $('#dataTables-example').DataTable({
        retrieve: true,
        responsive: false,
        paging: false,
        autoWidth: false,
        bAutoWidth: false,
        order: [[ <?php echo $orderBy;?>, 'asc' ]]

    });
    $('.slider_5').on('change', function(){
        const value_selector = Math.round($(this).val());
        $(this).parent().find(".dashboard-slider-5-text").html(value_selector);

    })

</script>

