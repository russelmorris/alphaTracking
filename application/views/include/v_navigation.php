<!-- Navigation -->

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url('dashboard'); ?>">Alpha Tracking v 1.0.9</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
       <!-- <li>
                <a href="<?php /*echo base_url('factor-weights') */?>">
                    <i class="fa fa-balance-scale fa-fw"></i> Factor Weights
                </a>
        </li>-->
        <li>
            <?php if (($user['isComittee'] == 1 || $user['isAdmin'] == 1 )&& uri_string() != 'dashboard') { ?>
                <a href="<?php echo base_url('dashboard') ?>">
                    <i class="fa fa-desktop fa-fw"></i> IC Dashboard
                </a>
            <?php } ?>
        </li>
        <li>
            <?php if (($user['isAdmin'] == 1 )&& uri_string() != 'ic-dates') { ?>
                <a href="<?php echo base_url('ic-dates') ?>">
                    <i class="fa fa-calendar fa-fw"></i>IC Dates
                </a>
            <?php } ?>
        </li>
        <li>
            <?php if (($user['isAdmin'] == 1 )&& uri_string() != 'members') { ?>
                <a href="<?php echo base_url('members') ?>">
                    <i class="fa fa-users fa-fw"></i>Members
                </a>
            <?php } ?>
        </li>
        <?php if ($user['isAdmin'] == 1 && !in_array(uri_string(), ['admin-dashboard', 'committee-completion-summary'])) { ?>
            <li>
                <a href="<?php echo base_url('admin-dashboard') ?>">
                    <i class="fa fa-th-large fa-fw"></i> IC Admin Dashboard
                </a>
            </li>
        <?php } ?>
        <li>
            <?php if (($user['isAdmin'] == 1 )) { ?>
                <a href="<?php echo base_url('portfolio-view') ?>">
                    <i class="fa fa-th fa-fw"></i>Portfolio View
                </a>
            <?php } ?>
        </li>


        <?php if (uri_string() == 'dashboard') {  ?>
        <li>
            <a href="<?php echo  base_url('committee-completion-summary')?>">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
                Investment Committee Completion Summary
            </a>
        </li>
        <?php } ?>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>
                <?php echo $admin ? $admin['memberName'] : $user['memberName']; ?>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li class="disabled">
                    <a href="#"><i class="fa fa-user fa-fw"></i>
                        <?php echo $admin ? $admin['memberName'] : $user['memberName']; ?>
                    </a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
</nav>
<div class="content-holder">
