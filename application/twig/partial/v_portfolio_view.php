<h1>Portfolio View</h1>
<div class="dashboard">
    <div class="row">
        <div class="col col-sm-6">
            <select class="ic-member-multiple col col-sm-12" name="members[]" multiple="multiple">
                {% for member in members %}
                    <option value="{{ member.memberName }}">{{ member.memberName }}</option>
                {% endfor %}
            </select>
        </div>

        <div class="col col-sm-6 pull-right form-horizontal" >
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="ic_dates" class="col-sm-2 control-label">Ic Date</label>
                    <div class="col-sm-10">
                        <select class="form-control col-sm-8" id="ic_dates">
                            <option valur="2018-12-25">2018-12-25</option>
                            <option valur="2018-12-21">2018-12-21</option>
                            <option valur="2018-12-22">2018-12-22</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<table width="100%" class="table table-striped table-bordered table-hover" id="portfolio-pivot">
    <thead>
    <tr>
        <th class="nikola">Static 1</th>
        <th>Static 2</th>
        <th>Static 3</th>
        {% for member in members %}
            <th class="ic-member">{{ member.memberName }}</th>
        {% endfor %}
    </tr>
    </thead>
    <tbody>
    {% for i in range(0, 10) %}
        <tr>
            <td>Random String</td>
            <td>Prospect 2</td>
            <td>Prospet RIc</td>
            {% for member in members %}
                <td class="ic-member">123</td>
            {% endfor %}
        </tr>
    {% endfor %}

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