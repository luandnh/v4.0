<div id="contents-performance" class="row" style="display: none;">
    <div class="card" style="padding: 15px;">
        <div class="row">
            <div class="col-md-12">
                <style scoped>
                    .form-group {
                        padding: 0px;
                    }
                </style>
                <h3 class="m0 pb-lg">Filters</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="filter_date">ThờI gian</label>
                            <div class="">
                                <button type="button" class="form-control btn btn-default" id="daterange-btn-performance" style="width: 100%;" name="filter_date">
                                    <span></span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                            <input type="hidden" id="daterange-value-performance" value="" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Chiến dịch</label>
                            <select multiple class="form-control" id="performance-select-campaigns">
                                <option selected value="ALL">ALL</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-flat pull-right" id="performance-search-btn">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="performance-list" class="table table-bordered table-hover dataTable" style="border: 1px solid #f4f4f4">
                </table>
            </div>
        </div>
    </div>
</div><!-- /.row -->