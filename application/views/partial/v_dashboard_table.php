<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
    <tr>
        <th class="text-center">#</th>
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
        <th>&nbsp;</th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Veto">Veto
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Business model">
            Business
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip"
            data-placement="top"
            class="text-center"
            title="Business valuation">Business
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip"
            data-placement="top"
            class="text-center"
            title="Digital Footprint">Footprint
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip"
            data-placement="top" class="text-center"
            title="Significant uplft in addressable maret">Uplft <i class="fa fa-info-circle"></i>
        </th>
        <th data-toggle="tooltip"
            data-placement="top"
            class="text-center"
            title="Competitor Analysis">Analysis
            <i class="fa fa-info-circle"></i></th>
        <th data-toggle="tooltip" data-placement="top" class="text-center" title="Risks">Risks
            <i class="fa fa-info-circle"></i></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($ic_dashboard as $index => $ic): ?>

        <tr class="row_odd <?php echo $ic['isFinalised'] ? "row-finished" : '' ?>" id="tr_<?php echo $ic['ticker'];?>">

            <td class="vcenter final"><?php echo $index + 1; ?>
                <input class="hidden master_id" value="<?php echo $ic['masterID'];  ?>">
            </td>
            <td class="vcenter hcenter final final-dis">
                <button class="btn btn-default btn-circle finalised" onclick="updateFinalise('<?php echo $ic['ticker'];?>', this)">
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
                    <div class="cell_part">
                        <button class="btn btn-default btn-circle veto ticker_<?php echo $ic['ticker'];?>"
                                onclick="updateVeto('<?php echo $ic['ticker'];?>', this)"
                            <?php if($ic['isFinalised'] == 1) {echo ' disabled ' ;}?>  >
                            <i class="fa <?php echo $ic['vetoFlag'] ? "fa-check" : '' ?>"></i>
                        </button>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part"></div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <select class="form-control business-model ticker_<?php echo $ic['ticker'];?>"
                                    onchange="updateTicker('<?php echo $ic['ticker'];?>', 1, this.value)"
                                    <?php if($ic['isFinalised'] == 1) {echo ' disabled ' ;}?>
                            >
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                      <option value="<?php echo $i; ?>" <?php if($ic['factorScore1'] == $i){ echo ' selected '; }?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld1']; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <select class="form-control business-valuation ticker_<?php echo $ic['ticker'];?>"
                                    onchange="updateTicker('<?php echo $ic['ticker'];?>', 2, this.value)"
                                <?php if($ic['isFinalised'] == 1) {echo ' disabled ' ;}?>
                            >
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if($ic['factorScore2'] == $i){ echo ' selected '; }?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld2']; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <select class="form-control digital-footprint ticker_<?php echo $ic['ticker'];?>"
                                    onchange="updateTicker('<?php echo $ic['ticker'];?>', 3, this.value)"
                                <?php if($ic['isFinalised'] == 1) {echo ' disabled ' ;}?>
                            >
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if($ic['factorScore3'] == $i){ echo ' selected '; }?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld3']; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <select class="form-control uplift ticker_<?php echo $ic['ticker'];?>"
                                    onchange="updateTicker('<?php echo $ic['ticker'];?>', 4, this.value)"
                                <?php if($ic['isFinalised'] == 1) {echo ' disabled ' ;}?>
                            >
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if($ic['factorScore4'] == $i){ echo ' selected '; }?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld4']; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <select class="form-control competitor-analysis ticker_<?php echo $ic['ticker'];?>"
                                    onchange="updateTicker('<?php echo $ic['ticker'];?>', 5, this.value)"
                                <?php if($ic['isFinalised'] == 1) {echo ' disabled ' ;}?>
                            >
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if($ic['factorScore5'] == $i){ echo ' selected '; }?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld5']; ?></p>
                    </div>
                </div>
            </td>
            <td class="no-padding">
                <div class="cell_holder">
                                        <span class="hidden"><?php echo str_pad(rand(1, 10), 2, '0',
                                                STR_PAD_LEFT); ?></span>
                    <div class="cell_part mbt-5">
                        <div class="form-group">
                            <select class="form-control risk ticker_<?php echo $ic['ticker'];?>"
                                    onchange="updateTicker('<?php echo $ic['ticker'];?>', 6, this.value)"
                                <?php if($ic['isFinalised'] == 1) {echo ' disabled ' ;}?>
                            >
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if($ic['factorScore6'] == $i){ echo ' selected '; }?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cell_part_hr"></div>
                    <div class="cell_part">
                        <p class="mb-10 mt-10"><?php echo $ic['factorScoreOld6']; ?></p>
                    </div>
                </div>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
<?php /*endif; */ ?>

<script>
    $('#dataTables-example').DataTable({
        responsive: false,
        paging: false,
        autoWidth: false,
        bAutoWidth: false

    });
</script>

