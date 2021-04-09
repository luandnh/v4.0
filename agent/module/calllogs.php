<div id="contents-calllogs" class="row" style="display: none;">
    <div class="card row" style="padding: 15px;">
        <div class="col-md-9">
            <table id="calllogs-list" class="display" style="border: 1px solid #f4f4f4">
                <thead>
                    <tr>
                        <th>
                            <?= $lh->translationFor('date') ?>
                        </th>
                        <th>
                            <?= $lh->translationFor('customer') ?>
                        </th>
                        <th>
                            <?= $lh->translationFor('phone_number') ?>
                        </th>
                        <th>
                            <?= $lh->translationFor('status') ?>
                        </th>
                        <th>
                            <?= $lh->translationFor('duration') ?>
                        </th>
                        <th>
                            <?= $lh->translationFor('campaign_id') ?>
                        </th>
                        <th>
                            <?= $lh->translationFor('list_id') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <style scoped>
                .form-group {
                    padding: 0px;
                }
            </style>
            <h3 class="m0 pb-lg">Filters</h3>
            <div class="form-group">
                <label for="filter_date">Date</label>
                <div class="">
                    <button type="button" class="form-control btn btn-default" id="daterange-btn-calllogs" style="width: 100%;" name="filter_date">
                        <span></span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <input type="hidden" id="daterange-value-calllogs" value="" />
            </div>
            <div class="form-group">
                <label>Select Campaigns</label>
                <select multiple class="form-control" id="calllogs-select-campaigns">
                    <option selected value="ALL">ALL</option>
                </select>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-block btn-primary btn-flat" id="calllogs-search-btn">
                    Search
                </button>
            </div>
        </div>

    </div>
</div><!-- /.row -->