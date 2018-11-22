
<div class="dashboard">
    <div class="row">
        <div class="col col-sm-4 form-horizontal" >
            <h2>Portfolio View</h2>
        </div>
        <div class="col col-sm-4 form-horizontal" >
            <form class="form-horizontal mt-10">
                <div class="form-group mt-10">
                    <label for="ic_dates" class="col-sm-2 control-label mt-10">Ic Date</label>
                    <div class="col-sm-10 mt-10">
                        <select class="form-control col-sm-8" id="ic_dates">
                            {%for icDate in icDates %}
                            <option value="{{icDate.icDate}}"
                                    {% if icDate.icDate is same as( selectedIcDate ) %}
                                        selected
                                    {% endif %}
                            >{{icDate.icDate}}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="col col-sm-4 form-horizontal">
            <form class="form-horizontal mt-10">
                <div class="form-group mt-10">
                    <label for="ic_dates" class="col-sm-2 control-label mt-10">Ic Member</label>
                    <div class="col-sm-10 mt-10">
                        <select class="ic-member-multiple col col-sm-12" name="members[]" multiple="multiple">
                            {% for member in members %}
                            <option value="{{ member.memberName }}">{{ member.memberName }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
            </form>

        </div>


    </div>

</div>

<table width="100%" class="table table-striped table-bordered table-hover" id="portfolio-pivot" style="font-size: 8px">
    <thead>
    <tr>
        <th>Name</th>
        <th>RIC</th>
        <th>Sector</th>
        <th>Country</th>
        {% for member in members %}
            <th class="ic-member">{{ member['memberName'] }}</th>
        {% endfor %}
    </tr>
    </thead>
    <tbody>
    {% for portfolio in portfolios %}
        <tr>
            <td>{{portfolio.name}}</td>
            <td>{{portfolio.RIC}}</td>
            <td>{{portfolio.sector}}</td>
            <td>{{portfolio.country}}</td>
            {% for member in members %}
                <td class="ic-member">{{ attribute(portfolio, 'member_'~member['memberNo'])|default}}</td>
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
//        table.columns().visible(false);
        table.columns(0).visible(true);
        table.columns(1).visible(true);
        table.columns(2).visible(true);
        table.columns(3).visible(true);
//        table.columns(4).visible(true);

        $('#ic_dates').on('change', function(){
            window.location.replace("/portfolio-view/"+$(this).val());
        });

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