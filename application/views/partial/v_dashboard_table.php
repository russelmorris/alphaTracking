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
        <th>&nbsp;</th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Veto">Veto
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Business model">Model
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Growth sustainability going forward">Growth
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Business valuation">Valuation
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Digital Footprint">Footprint
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Risks">Risks
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Overall growth likely to continue?">Going up?
            <i class="fa fa-info-circle"></i></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($ic_dashboard as $index => $ic): ?>

        <tr class="row_odd <?php echo $ic['isFinalised'] ? "row-finished" : '' ?>" id="tr_<?php echo $ic['ticker']; ?>">

            <td class="vcenter final"><?php echo $index + 1; ?>
            </td>
            <td class="vcenter">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>">
                    <?php echo $ic['inPortfolio'] == '1' ?
                        '<span class="in-portfolio glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>':
                        '<span class="out-portfolio glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?>
                </a>
            </td>
            <td class="vcenter hcenter final final-dis"><span class="hidden"><?php echo $ic['isFinalised']?></span>
                <button class="btn btn-default btn-circle finalised"
                        onclick="updateFinalise('<?php echo $ic['ticker']; ?>', this)">
                    <i class="fa <?php echo $ic['isFinalised'] ? "fa-check" : '' ?>"></i>
                </button>
            </td>
            <td class="vcenter ticker final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>"><?php echo $ic['ticker']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>"><?php echo $ic['name']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>"><?php echo $ic['sector']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>"><?php echo $ic['country']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>"><?php echo $ic['machineRank']; ?></a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>">
                    <?php echo is_null($ic['humanScore']) ? 0 :  round($ic['humanScore'], 2); ?>
                </a>
            </td>
            <td class="vcenter final click">
                <a href="<?php echo base_url("voting/" . $ic['icDate'] . "/" . $ic['ticker']); ?>">
                    <?php echo is_null($ic['humanRank']) ? 0 :  round($ic['humanRank'], 2); ?>
                </a>
            </td>
            <td class="no-padding final click">
                <div class="cell_holder">
                    <div class="cell_part">
                        <p class="mb-10 mt-10">This</p>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10">Prev</p>
                    </div>
                </div>
            </td>
            <td class="vcenter hcenter no-padding">
                <div class="cell_holder">
                    <div class="cell_part"><span class="hidden"><?php echo $ic['vetoFlag']?></span>
                        <button class="btn btn-default btn-circle veto ticker_<?php echo $ic['ticker']; ?>"
                                onclick="updateVeto('<?php echo $ic['ticker']; ?>', this)"
                            <?php if ($ic['isFinalised'] == 1) {
                                echo ' disabled ';
                            } ?> >
                            <i class="fa <?php echo $ic['vetoFlag'] ? "fa-check" : '' ?>"></i>
                        </button>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part"></div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <span class="hidden"><?php echo $ic['factorScore1']; ?></span>
                            <select class="form-control business-model ticker_<?php echo $ic['ticker']; ?>"
                                    onchange="updateTicker('<?php echo $ic['ticker']; ?>', 1, this.value, this)"
                                <?php if ($ic['isFinalised'] == 1) {
                                    echo ' disabled ';
                                } ?>
                            >
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($ic['factorScore1'] == $i) {
                                        echo ' selected ';
                                    } ?>><?php echo ($i == 0)? '-': $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo !empty($ic['factorScoreOld1']) ? round($ic['factorScoreOld1']) : 'N/A' ; ?></p>
                    </div>
                </div>
            </td>


            <td class="no-padding">
                <div class="cell_holder">
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <span class="hidden"><?php echo $ic['factorScore4']; ?></span>
                            <select class="form-control business-valuation ticker_<?php echo $ic['ticker']; ?>"
                                    onchange="updateTicker('<?php echo $ic['ticker']; ?>', 4, this.value, this)"
                                <?php if ($ic['isFinalised'] == 1) {
                                    echo ' disabled ';
                                } ?>
                            >
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($ic['factorScore4'] == $i) {
                                        echo ' selected ';
                                    } ?>><?php echo ($i == 0)? '-': $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo !empty($ic['factorScoreOld4']) ? round($ic['factorScoreOld4']): 'N/A'; ?></p>
                    </div>
                </div>
            </td>



            <td class="no-padding">
                <div class="cell_holder">
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <span class="hidden"><?php echo $ic['factorScore2']; ?></span>
                            <select class="form-control business-valuation ticker_<?php echo $ic['ticker']; ?>"
                                    onchange="updateTicker('<?php echo $ic['ticker']; ?>', 2, this.value, this)"
                                <?php if ($ic['isFinalised'] == 1) {
                                    echo ' disabled ';
                                } ?>
                            >
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($ic['factorScore2'] == $i) {
                                        echo ' selected ';
                                    } ?>><?php echo ($i == 0)? '-': $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo !empty($ic['factorScoreOld2']) ? round($ic['factorScoreOld2']): 'N/A'; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <span class="hidden"><?php echo $ic['factorScore3']; ?></span>
                            <select class="form-control digital-footprint ticker_<?php echo $ic['ticker']; ?>"
                                    onchange="updateTicker('<?php echo $ic['ticker']; ?>', 3, this.value, this)"
                                <?php if ($ic['isFinalised'] == 1) {
                                    echo ' disabled ';
                                } ?>
                            >
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($ic['factorScore3'] == $i) {
                                        echo ' selected ';
                                    } ?>><?php echo ($i == 0)? '-': $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo !empty($ic['factorScoreOld3']) ? round($ic['factorScoreOld3']): 'N/A'; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <span class="hidden"><?php echo $ic['factorScore6']; ?></span>
                            <select class="form-control risk ticker_<?php echo $ic['ticker']; ?>"
                                    onchange="updateTicker('<?php echo $ic['ticker']; ?>', 6, this.value, this)"
                                <?php if ($ic['isFinalised'] == 1) {
                                    echo ' disabled ';
                                } ?>
                            >
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($ic['factorScore6'] == $i) {
                                        echo ' selected ';
                                    } ?>><?php echo ($i == 0)? '-': $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo !empty($ic['factorScoreOld6']) ? round($ic['factorScoreOld6']): 'N/A'; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <span class="dashboard-slider-5-text"><?php echo $ic['factorScore5']*10; ?></span>
                            <input onchange="updateTicker('<?php echo $ic['ticker']; ?>', 5,  this.value/10, this)"
                                   type="range" min="0" max="100" value="<?php echo $ic['factorScore5']*10;?>" class="slider slider_5" >
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo !empty($ic['factorScoreOld5'])? round($ic['factorScoreOld5']*10): 'N/A'; ?></p>
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
        bAutoWidth: false

    });
    $('.slider_5').on('change', function(){
        const value_selector = Math.round($(this).val());
        $(this).parent().find(".dashboard-slider-5-text").html(value_selector);

    })

</script>

