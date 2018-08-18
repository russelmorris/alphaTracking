<div id="page-wrapper" class="dashboard pt-20">
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="closestIcDate" class="col-sm-4 control-label">IC Date</label>
            <div class="col-sm-3">
                <input type="input" class="form-control" id="closestIcDate"
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
        <?php foreach($factorWeights as $factorWeight ) {?>
            <div class="form-group">
                <label for="factor_<?php echo $factorWeight['factorNo'];?>" class="col-sm-4 text-right pt-0">
                    <?php echo $factorWeight['factorDesc'] ;?></label>
                <div class="col-sm-3">
                    <input type="range" min="0" max="100" value="0"
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
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-3">
                <button type="button" onclick="saveFactorWeight()" class="btn btn-default">Save</button>
                <p class="hidden text-success" id ="help-block">Factors weights has been saved.</p>
        </div>
        </div>
    </form>
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

