<div id="page-wrapper" class="dashboard pt-20">
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">IC Date</label>
            <div class="col-sm-3">
                <input type="input" class="form-control" id="inputEmail3"
                       value="<?php echo $closest_icDate_from_today; ?>"
                       disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">IC Member</label>
            <div class="col-sm-3">
                <select class="form-control admin_users">-->
                    <?php foreach ($admin_users as $value): ?>
                        <?php if ($value['isAdmin']): ?>
                            <option selected value="<?php echo $value['memberNo']; ?>">
                                <?php echo $value['memberName']; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $value['memberNo']; ?>">
                                <?php echo $value['memberName']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php foreach($factorWeights as $key => $factorWeight ) {?>
            <div class="form-group">
                <label for="factor_<?php echo $key;?>" class="col-sm-2 control-label"><?php echo $factorWeight['factorDesc'] ;?></label>
                <div class="col-sm-3">
                    <input type="range" min="0" max="100" value="<?php echo $factorWeight['factorWeight']*10 ;?>" class="slider" id="factor_<?php echo $key;?>">
                </div>
                <div class="col-sm-1">
                    <label id="factor_label_<?php echo $key;?>"></label>
                </div>
            </div>
            <script>
                var slider_<?php echo $key;?> = document.getElementById("factor_<?php echo $key;?>");
                var output_<?php echo $key;?> = document.getElementById("factor_label_<?php echo $key;?>");
                output_<?php echo $key;?>.innerHTML = slider_<?php echo $key;?>.value/10; // Display the default slider value

                // Update the current slider value (each time you drag the slider handle)
                slider_<?php echo $key;?>.oninput = function() {
                    output_<?php echo $key;?>.innerHTML = this.value/10;
                }
            </script>
        <?php } ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="button" onclick="saveFactorWeight()" class="btn btn-default">Save</button>
            </div>
        </div>
    </form>
</div>
<script>
   function saveFactorWeight () {
       $.post('/submit-factors-weight', {
//           fc2: $(this).attr('data-value'),
//           user_id: $('#user_id').val(),
//           ticker: $('#ticker').val(),
//           ic_date: $('#voting_ic_date').val(),
           csnamerf: $.cookie('csrfcookiename')
       }).done(function (data) {
           console.log('on return', data);
       })
   }
</script>

