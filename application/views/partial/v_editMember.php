<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>Add new Member</h1>
        </div>
    </div>
    <div class="row">
        <form class="form-horizontal" method="post">
            <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>"/>
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            <div class="form-group  ">
                <label class="col-sm-4 control-label">strategy No</label>
                <div class=" col-sm-4">
                    <input type="number" name="strategyNo" id="strategyNo" class="form-control" value="<?php echo $member['strategyNo']?>"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group  ">
                <label class="col-sm-4 control-label">Member Name</label>
                <div class=" col-sm-4">
                    <input type="text" name="memberName" id="memberName" class="form-control" autofocus
                           value="<?php echo $member['memberName']?>" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">bWeight</label>
                <div class="col-sm-4">
                    <input type="number" name="bWeight" id="bWeight" class="form-control" value="<?php echo $member['bWeight']*100?>"
                           autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Email</label>
                <div class="col-sm-4">
                    <input type="text" name="email" id="email" class="form-control" value="<?php echo $member['email']?>"
                           autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Password</label>
                <div class="col-sm-4">
                    <input type="text" name="password" id="password" class="form-control" value="<?php echo $member['password']?>"
                           autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 text-right">Is Active</label>
                <div class="col-sm-4">
                    <input type="checkbox" name="isActive" id="isActive"
                        <?php if($member['isActive']== '1'){ ?>
                            checked
                        <?php }; ?>
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="admin" class="col-sm-4 text-right">Is Admin</label>
                <div class="col-sm-4">
                    <input type="checkbox" name="isAdmin" id="admin"
                        <?php if($member['isAdmin']== '1'){ ?>
                            checked
                        <?php }; ?>
                    >
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 text-right">Is Comittee</label>
                <div class="col-sm-4">
                    <input type="checkbox" name="isComittee" id="isComittee"
                        <?php if($member['isComittee']== '1'){ ?>
                            checked
                        <?php }; ?>
                    >
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-3 no-padding">
                    <button type="submit" class="btn btn-default">Update</button>
                    <p class="hidden text-success" id="help-block">Member has been updated.</p>
                </div>
            </div>

        </form>
    </div>
</div>