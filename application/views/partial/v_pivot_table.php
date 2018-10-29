<h1>Pivot table - proof of concept</h1>
<div class="dashboard">
    <div class="row">
        <div class="col col-sm-12">
            <select class="ic-member-multiple col col-sm-6" name="members[]" multiple="multiple">
                <?php foreach ($members as $member) { ?>
                    <option value="<?php echo $member['memberName']; ?>"><?php echo $member['memberName']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<table width="100%" class="table table-striped table-bordered table-hover" id="portfolio-pivot">
    <thead>
    <tr>
        <th class="nikola">Static 1</th>
        <th>Static 2</th>
        <th>Static 3</th>
        <?php foreach ($members as $member) { ?>
            <th class="ic-member"><?php echo $member['memberName']; ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0; $i<5; $i++){ ?>
        <tr>
            <td><?php echo random_string("alpha", 3); ?></td>
            <td><?php echo random_string("alpha", 10); ?></td>
            <td><?php echo random_string("alpha", 10); ?></td>
            <?php foreach ($members as $member) { ?>
                <td class="ic-member"><?php echo random_string("numeric", 2); ?></td>
            <?php } ?>
        </tr>
    <?php } ?>

    </tbody>
</table>
<script>
    $(document).ready(function () {
        let table = $('#portfolio-pivot').DataTable( {
            retrieve: true,
            responsive: false,
            paging: false,
            info: false,
            autoWidth: false,
            bAutoWidth: false,

        } );
        table.columns().visible(false);
        table.columns(0).visible(true);
        table.columns(1).visible(true);
        table.columns(2).visible(true);


        $('.ic-member-multiple')
            .select2(
                {
                    placeholder: 'Select an IC Member',
                    closeOnSelect: true,
                    allowClear: true,
                    selectOnClose: true

                }
            )
            .on('change.select2', function (e) {
                e.preventDefault();
                let selectedMembers = $(this).select2("val");

                table.columns().every(function (index) {
                    if (index >= 3) {
                        let title = $(table.columns(index).header()).html();
                        if (selectedMembers.indexOf(title) > -1) {
                            this.visible(true);
                        } else {
                            this.visible(false);
                        }
                    } else {
                        this.visible(true);
                    }
                });
            })
            .on('select2:unselecting', function(ev) {
                if (ev.params.args.originalEvent) {
                    // When unselecting (in multiple mode)
                    ev.params.args.originalEvent.stopPropagation();
                } else {
                    // When clearing (in single mode)
                    $(this).one('select2:opening', function(ev) { ev.preventDefault(); });
                }
            })

    });
</script>