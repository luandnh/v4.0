<div class="modal" tabindex="-1" role="dialog" id="uploadleads-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php $lh->translateText("upload_import"); ?></h4>
            </div>
            <div class="modal-body">
                <style>
                    #progress-wrp {
                        border: 1px solid #0099CC;
                        border-radius: 3px;
                        position: relative;
                        width: 100%;
                        height: 30px;
                        background-color: #367fa9;
                    }

                    #progress-wrp .progress-bar {
                        border-radius: 3px;
                        position: absolute;
                        width: 1%;
                        height: 100%;
                        background-color: #00a65a;
                        /* background-color: #4CAF50; */
                    }

                    #progress-wrp .status {
                        top: 3px;
                        left: 50%;
                        position: absolute;
                        display: inline-block;
                        color: white;
                        font-style: bold;
                        /* color: #000000; */
                    }
                </style>
                <div class="row">
                    <div class="col-lg-12" id="list_sidebar">
                        <form action="./php/AddLoadLeads.php" method="POST" enctype="multipart/form-data" id="upload_form" name="upload_form">
                            <input type="hidden" name="log_user" value="<?= $_SESSION['user'] ?>" />
                            <input type="hidden" name="log_group" value="<?= $_SESSION['usergroup'] ?>" />
                            <div class="form-group">
                                <label><?php $lh->translateText("list_id"); ?>:</label>
                                <div class="form-group">
                                    <!-- <select id="-1" class="form-control" name="list_id"> -->
                                    <select id="list_id" class="form-control " name="list_id" required>
                                        <option value="" selected disabled></option>
                                        <?php
                                        for ($i = 0; $i < count($lists->list_id); $i++) {
                                            echo '<option value="' . $lists->list_id[$i] . '">' . $lists->list_id[$i] . ' - ' . $lists->list_name[$i] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php $lh->translateText("duplicate_check"); ?> :</label>
                                    <SELECT size="1" NAME="goDupcheck" ID="goDupcheck" TITLE="Duplicate Check - Will check phone numbers on the lead file and cross reference it with all phone numbers on a specific campaign or in all List ID or in the entire system." class="form-control ">
                                        <OPTION value="NONE"><?php $lh->translateText("no_duplicate_check"); ?></OPTION>
                                        <OPTION value="DUPLIST"><?php $lh->translateText("check_phones_in_list_id"); ?></OPTION>
                                        <OPTION value="DUPCAMP"><?php $lh->translateText("check_phones_in_campaign-lists"); ?></OPTION>
                                        <?php
                                        // Customization
                                        if (LEADUPLOAD_CHECK_PHONES_IN_SYSTEM === 'y') {
                                        ?>
                                            <OPTION value="DUPSYS"><?php $lh->translateText("check_phones_in_system"); ?></OPTION>
                                        <?php } //end customization 
                                        ?>
                                    </SELECT>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php $lh->translateText("lead_mapping"); ?> </label> &nbsp;&nbsp;
                                <label class="switch">
                                    <input type="checkbox" id="LeadMapSubmit" name="LeadMapSubmit" value="0" />
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label><?php $lh->translateText("csv_file"); ?>:</label>
                                <div class="form-group" id="dvImportSegments">
                                    <div class="input-group">
                                        <input type="text" class="form-control file-name" name="file_name" placeholder="<?php $lh->translateText("csv_file"); ?>" required>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn browse-btn  btn-primary" type="button"><?php $lh->translateText("browse"); ?></button>
                                        </span>
                                    </div>
                                    <input type="file" class="file-box hide" name="file_upload" id="txtFileUpload" accept=".csv">
                                </div>

                                <div id="LeadMappingContainer" class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">
                                                    <div class="col-sm-12 col-md-8">
                                                        <b>LEAD MAPPING</b>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <span id="lead_map_data"></span>
                                                <!--<input type="hidden" id="LeadMapSubmit" name="LeadMapSubmit" value="0"/>-->
                                                <span id="lead_map_fields"></span>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="button" id="btnUpload" name="btnUpload" value="<?php $lh->translateText("proceed"); ?>" class="btn btn-primary" onClick="goProgressBar();">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="goValuesContainer"></div>
                            </div>

                            <!-- Progress bar -->
                            <div class="form-group">
                                <div id="progress-wrp">
                                    <div class="progress-bar"></div>
                                    <div class="status">0%</div>
                                </div>
                                <div id="output">
                                    <!-- error or success results -->
                                </div>
                                <br />
                                <div>
                                    <div class="alert alert-success" style="display:none;" id="dStatus">
                                        <div id="qstatus"> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Progress bar -->

                            <div id="jMapFieldsdiv">
                                <span id="jMapFieldsSpan"></span>
                            </div>
                            <?php
                            if (isset($_GET['message'])) {
                                echo '<div class="col-lg-12" style="margin-top: 10px;">';
                                if ($_GET['message'] == "success") {
                                    echo '<div class="alert alert-success"> <strong>Succes: </strong>' . $_GET['RetMesg'] . " leads uploaded</div>";
                                } else {
                                    echo '<div class="alert alert-success"> <strong>Error: </strong>' . $_GET['RetMesg'] . "</div>";
                                }
                                echo '</div>';
                            }
                            #var_dump($_GET);
                            ?>

                    </div><!-- ./upload leads -->
                </div><!-- /.row -->
            </div>
            <div class="modal-footer">
                <input type="button" id="btnUpload" name="btnUpload" value="<?php $lh->translateText("update"); ?>" class="btn btn-primary" onClick="goProgressBar();">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>