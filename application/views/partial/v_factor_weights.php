<div id="page-wrapper" class="dashboard pt-20">
    <?php if($closest_icDate_from_today || $admin){?>
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="closestIcDate" class="col-sm-4 control-label">IC Date</label>
                <div class="col-sm-3">
                    <?php if ($user['isAdmin'] == 1 ){ ?>
                        <select class="form-control admin_users" id="factorWeightIcDate">
                                <option value=""></option>
                            <?php foreach ($ic_dates as $value): ?>
                                <option  value="<?php echo $value['icDate']; ?>"
                                    <?php  echo ($value['icDate'] === $closest_icDate_from_today ) ? ' selected ': '' ?>
                                ><?php echo $value['icDate']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php } ?>

                    <input type="<?php echo ($user['isAdmin'] == 1)? 'hidden':'text';?>" class="form-control" id="closestIcDate"
                           value="<?php echo $closest_icDate_from_today; ?>"
                           disabled>

                    <input type="hidden" class="form-control" id="factorWeightIcUser"
                           value="<?php echo $user['memberNo']; ?>"
                           disabled>
                </div>
            </div>
            <?php if ($user['isAdmin'] == 1 ){ ?>
            <div class="form-group">
                <label for="factorWeightIcMember" class="col-sm-4 control-label">IC Member</label>
                <div class="col-sm-3">
                    <select class="form-control admin_users" id="factorWeightIcMember">
                        <?php foreach ($admin_users as $value): ?>
                                <option value="<?php echo $value['memberNo']; ?>"><?php echo $value['memberName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php } ?>
            <?php if(count($factorWeights) > 0 ){?>
            <?php foreach($factorWeights as $factorWeight ) {?>
                <div class="form-group">
                    <label for="factor_<?php echo $factorWeight['factorNo'];?>" class="col-sm-4 text-right pt-0">
                        <?php echo $factorWeight['factorDesc'] ;?></label>
                    <div class="col-sm-3">
                        <input type="range" min="0" max="100" value="0" <?php echo (!$enableEditing) ? 'disabled':'';?>
                               class="slider " id="factor_<?php echo $factorWeight['factorNo'];?>">
                    </div>
                    <div class="col-sm-1">
                        <label id="factor_label_<?php echo $factorWeight['factorNo'];?>"></label>
                    </div>
                </div>
                <script>
                    var slider_<?php echo $factorWeight['factorNo'];?> = document.getElementById("factor_<?php echo $factorWeight['factorNo'];?>");
                    var output_<?php echo $factorWeight['factorNo'];?> = document.getElementById("factor_label_<?php echo $factorWeight['factorNo'];?>");
                    output_<?php echo $factorWeight['factorNo'];?>.innerHTML = slider_<?php echo $factorWeight['factorNo'];?>.value/10; // Display the default slider value

                    // Update the current slider value (each time you drag the slider handle)
                    slider_<?php echo $factorWeight['factorNo'];?>.oninput = function() {
                        output_<?php echo $factorWeight['factorNo'];?>.innerHTML = this.value/10;
                    }
                </script>

            <?php } ?>
            <?php if ($enableEditing === true){ ?>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-3">
                        <button type="button" onclick="saveFactorWeight()" class="btn btn-default">Save</button>
                        <p class="hidden text-success" id ="help-block">Factors weights has been saved.</p>
                    </div>
                </div>
            <?php } ?>
            <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            <p>Factor Weight can not be found for this user on this Ic Date</p>
                        </div>
            <?php } ?>

        </form>
    <?php } else{ ?>
        <div class="alert alert-danger" role="alert">
            <p>Next IC date can not be found</p>
        </div>
    <?php }?>
</div>
<script>


   function saveFactorWeight () {
       var factors = [];
       <?php foreach($factorWeights as $factorWeight ) {?>
            factors.push({
                    factor_id: <?php echo $factorWeight['factorNo'];?>,
                    factor_value: $('#factor_<?php echo $factorWeight['factorNo'];?>').val()/10
            });
       <?php } ?>

       $.post('/submit-factors-weight', {
           factors: factors,
           ic_date: $('#closestIcDate').val(),
           ic_user: $('#factorWeightIcUser').val(),
           csnamerf: $.cookie('csrfcookiename')
       }).done(function (data) {
           $('#help-block').removeClass('hidden');
           setTimeout(function(){
               $('#help-block').addClass('hidden');
           }, 2000);

       })
   }

</script>

