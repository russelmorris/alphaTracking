<div id="page-wrapper" class="dashboard">
    <div class="row">
        <div class="col-md-12">
            <h1>Members</h1>
        </div>
        <div class="col-md-12 no-padding">
            <a class="btn btn-default pull-right mb-5" href="<?php echo base_url('add-member')?>">Add Member </a>
        </div>

        <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center">MemberNo</th>
                <th class="text-center">StrategyNo</th>
                <th class="text-center">Member Name</th>
                <th class="text-center">bWeight</th>
                <th class="text-center">Email</th>
                <th class="text-center">Password</th>
                <th class="text-center">Is Active</th>
                <th class="text-center">Is Admin</th>
                <th class="text-center">Is Comittee</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php  foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['memberNo']; ?></td>
                    <td><?php echo $user['strategyNo']; ?></td>
                    <td><?php echo $user['memberName']; ?></td>
                    <td><?php echo $user['bWeight']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['password']; ?></td>
                    <td><?php echo $user['isActive'] == '1' ?
                            '<span class="in-portfolio glyphicon glyphicon glyphicon-ok"></span>':
                            '<span class="out-portfolio glyphicon glyphicon-remove"></span>';?>
                    </td>
                    <td><?php echo $user['isAdmin']== '1' ?
                            '<span class="in-portfolio glyphicon glyphicon glyphicon-ok"></span>':
                            '<span class="out-portfolio glyphicon glyphicon-remove"></span>';?>
                    </td>
                    <td><?php echo $user['isComittee']== '1' ?
                            '<span class="in-portfolio glyphicon glyphicon glyphicon-ok"></span>':
                            '<span class="out-portfolio glyphicon glyphicon-remove"></span>';?>
                    </td>
                    <td>
                            <a class="btn btn-warning text-left mx-1" href="<?php echo base_url('members/' . $user['memberNo'] .'/edit') ?>"> Edit </a>
                     </td>
                </tr>
            <?php
            } ?>
            </tbody>
        </table>
    </div>
</div>