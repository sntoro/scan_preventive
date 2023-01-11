<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

    <?php   
        $type = '';
        if($id_type == 'A'){
            $type = 'M O L D';
        } else if($id_type == 'B'){
            $type = 'D I E S   S T P';
        } else if($id_type == 'C'){
            $type = 'D I E S   D F';
        } else if($id_type == 'D'){
            $type = 'M A C H I N E';
        } else if($id_type == 'E'){
            $type = 'J I G';
        }
    
    ?>

    <div>
        <div class="top-menu">
            <span class="menu"><img src="<?php echo base_url('assets/images/menu.png'); ?>"> </span>
            <ul>
                <li><a href="<?php echo base_url('index.php/Scan_c/scan_qr_part/'. $id_type) ; ?>"><?php echo $type; ?></a></li>
                <li><a class="active" href="#">M E N U</a></li>
                <li><a href="<?php echo base_url('index.php/login_c'); ?>" onclick="return confirm('Are you sure want to LOGOUT?');">L O G O U T</a></li>
                <div class="clearfix"></div>
            </ul>
        </div>
        <!--script for menu-->
        <script>
            $("span.menu").click(function () {
                $(".top-menu ul").slideToggle(500, function () {
                });
            });
        </script>
        <!--script for menu-->
    </div>
    <div class="clearfix"></div>

    <div class="total-info">
        <div style="height:350px;">
            <div class="hire-me">
                <h3 style="letter-spacing:6px;">TOOLING INFORMATION</h3>
                <br>
                <div class="project">
                    <table style="color:white;font-size:12px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">Tooling Code</th>
                            <th style="text-align:center;">Tooling Name</th>
                            <th style="text-align:center;">Model</th>
                            <th style="text-align:center;">Std Stroke</th> 
                            <th style="text-align:center;">Product Number</th>
                            <?php if($role == 1){ ?>
                                <th style="text-align:center;">Product AR</th>
                            <?php } ?>                          
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center"><?php echo $data->CHR_PART_CODE; ?></td>
                                <td align="center"><?php echo $data->CHR_PART_NAME; ?></td>
                                <td align="center"><?php echo $data->CHR_MODEL; ?></td>
                                <td align="center"><?php echo number_format($data->INT_STROKE_SMALL_PREVENTIVE,0,',','.'); ?></td>
                                <!-- <td align="center"><a data-toggle="modal" data-target="#modalPart" style="color: #00ffff; text-decoration-line: underline;">View</a></td> -->
                                <td align="center"><a onclick="get_detail_part_no(<?php echo $data->INT_ID; ?>)" style="color: #00ffff; text-decoration-line: underline;">View</a></td>
                                <?php if($role == 1){ ?>
                                    <td style="text-align:center;"><a href="<?php echo base_url('index.php/Scan_c/augmented'); ?>" style="color: #00ffff; text-decoration-line: underline;">View</a></td>
                            <?php } ?> 
                            </tr>
                        </tbody>
                    </table>
                    <table style="color:white;font-size:12px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>                            
                            <th style="text-align:center;">Last Prev Stroke</th>
                            <th style="text-align:center;">Actual Stroke</th> 
                            <th style="text-align:center;">Next Prev Stroke</th>
                            <th style="text-align:center;">Remain Stroke</th>
                            <th style="text-align:center;">Stroke/day </br>(Last 3 months)</th>
                            <th style="text-align:center;">Date Est</th>                           
                        </thead>
                        <tbody>
                            <tr>                                
                                <td align="center"><?php echo number_format(($data->INT_STROKE_BIG_PREVENTIVE - $data->INT_STROKE_SMALL_PREVENTIVE),0,',','.'); ?></td>
                                <?php
                                    $id_part = $data->INT_ID;
                                    $date = $data->CHR_DATE_BIG_PREVENTIVE;
                                    $get_stroke = $this->db->query("SELECT SUM(INT_TOTAL_QTY + INT_TOTAL_NG) AS TOTAL FROM TT_PRODUCTION_RESULT 
                                                                    WHERE CHR_PART_NO IN (SELECT CHR_PART_NO FROM TM_PARTS_MTE_DETAIL WHERE INT_ID_PART = '$id_part' AND INT_FLAG_DELETE = '0')
                                                                        AND CHR_DATE >= '$date'")->row();
                                    $act_stroke = $get_stroke->TOTAL;
                                    //===== Get total days from 3 month ago;
                                    $date_now = date('Ymd') . ' ' . date('His');
                                    $date_start = date('Ymd', strtotime("-90 days")) . ' 000001';
                                    $date_1 = new datetime($date_start);
                                    $date_2 = new datetime($date_now);
                                    $diff_days = $date_1->diff($date_2);
                                    $tot_days = (int)$diff_days->format('%a');
                                    
                                    //===== Average stroke per day
                                    $avg_stroke = $act_stroke / $tot_days;

                                    $style = '';
                                    $remain_stroke = ($data->INT_STROKE_BIG_PREVENTIVE - $act_stroke);
                                    if($avg_stroke <= 0){
                                        $tot_days_to_prev = 0;
                                    } else {
                                        $tot_days_to_prev = floor($remain_stroke / $avg_stroke);
                                    }
                                    
                                    $perc_10 = ($data->INT_STROKE_SMALL_PREVENTIVE * (10/100));
                                    $perc_5 = ($data->INT_STROKE_SMALL_PREVENTIVE * (5/100));

                                    $dis_prev = 'disabled';
                                    if(($remain_stroke > $perc_5) && ($remain_stroke <= $perc_10)){
                                        $style = 'style="background-color: orange;"';
                                        $dis_prev = '';
                                    } else if(($remain_stroke > 0) && ($remain_stroke <= $perc_5)){
                                        $style = 'style="background-color: red;"';
                                        $dis_prev = '';
                                    } else if($remain_stroke < 0){
                                        $style = 'style="background-color: #cc00cc;"';
                                        $dis_prev = '';
                                    }
                                ?>
                                <td align="center"><?php echo number_format($act_stroke,0,',','.'); ?></td>
                                <td align="center"><?php echo number_format($data->INT_STROKE_BIG_PREVENTIVE,0,',','.'); ?></td>
                                <td align="center" <?php echo $style; ?>><?php echo number_format(($data->INT_STROKE_BIG_PREVENTIVE - $act_stroke),0,',','.'); ?></td>
                                <td align="center"><?php echo number_format($avg_stroke,0,',','.'); ?></td>
                                <td align="center">
                                    <?php 
                                    if($avg_stroke <= 0){
                                        echo "-";
                                    } else {
                                        echo date('d/m/Y', strtotime("+$tot_days_to_prev days")); 
                                    }
                                    
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>	
            <div class="clearfix"></div>
        </div>
        <div class="modal" id="modalPart" tabindex="-1" style="display: none;"></div>
        <div class="modal" id="modalDrawing" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalHistorical" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalManual" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalFailure" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalRepair" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalPrev" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalChange" tabindex="-1" align="center" style="display: none;"></div>
        <div style="height:290px;">
            <div class="hire-me">
                <h3>M E N U</h3>
                <br>
                <div class="project">
                    <div align="center">
                        <input type="button" class="btn btn-info" value="D R A W I N G" onclick="show_drawing_type()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">
                        &nbsp;
                        <input type="button" class="btn btn-info" value="W O R K &nbsp; I N S T R U C T I O N" onclick="manual_type()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <input type="button" class="btn btn-info" value="O T H E R S" onclick="fta_type()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">
                        &nbsp;
                        <input type="button" class="btn btn-info" value="H I S T O R I C A L" onclick="historical()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">
                    </div>
                </div>
            </div>	
            <div class="clearfix"></div>
        </div>
        <div>
            <div class="hire-me">
                <h3>A C T I O N</h3>
                <br>
                <div class="project">
                    <?php                        
                        $dis_repair = '';
                        $dis_prev = '';
                        if($data->INT_FLAG_STAT == 1){ //===== Stat : On Preventive
                            $dis_repair = 'disabled';
                        } else if($data->INT_FLAG_STAT == 2){ //===== Stat : On Repair
                            $dis_prev = 'disabled';
                        }
                    ?>
                    <div align="center">                        
                        <?php if($id_type == 'B' || $id_type == 'C'){ //===== Case for Dies STP & Dies DF ?>
                            <input type="button" <?php echo $dis_prev; ?> class="btn btn-warning" value="P R E V E N T I V E" onclick="view_preventive()" style="width: 25%; height: 40px; font-size: 15px; font-weight: bold;">
                            &nbsp;
                            <input type="button" <?php echo $dis_repair; ?> class="btn btn-warning" value="R E P A I R" onclick="view_repair()" style="width: 25%; height: 40px; font-size: 15px; font-weight: bold;">
                            &nbsp;
                            <input type="button" <?php echo $dis_repair; ?> class="btn btn-warning" value="C H A N G E &nbsp; M O D E L" onclick="view_change()" style="width: 25%; height: 40px; font-size: 15px; font-weight: bold;">
                        <?php } else { //===== For other type prev?>
                            <input type="button" <?php echo $dis_prev; ?> class="btn btn-warning" value="P R E V E N T I V E" onclick="view_preventive()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">
                            &nbsp;
                            <input type="button" <?php echo $dis_repair; ?> class="btn btn-warning" value="R E P A I R" onclick="view_repair()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">    
                        <?php } ?>
                    </div>
                </div>
                </br>
                &nbsp;
                <div class="project">
                    <div align="center">
                        <?php if($data->INT_FLAG_STAT <> 0){ ?>
                        <table style="color:white;font-size:12px;" class="table table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Start Date</th>
                                <th style="text-align:center;">Start Time</th>
                                <th style="text-align:center;">Duration</th> 
                                <th style="text-align:center;">Start By</th>                         
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if($data->INT_FLAG_STAT == 1){ ?>
                                        <td align="center">On Preventive</td>
                                        <td align="center"><?php echo substr($progress->CHR_START_PREV_DATE, 6, 2) . '/' . substr($progress->CHR_START_PREV_DATE, 4, 2 ) . '/' . substr($progress->CHR_START_PREV_DATE, 0, 4 ); ?></td>
                                        <td align="center"><?php echo substr($progress->CHR_START_PREV_TIME, 0, 2 ) . ':' . substr($progress->CHR_START_PREV_TIME, 2, 2 ); ?></td>
                                        <?php 
                                            $datetime_now = date('Ymd') . ' ' . date('His');
                                            $datetime_start = $progress->CHR_START_PREV_DATE . ' ' . $progress->CHR_START_PREV_TIME;
                                            $datetime_1 = new datetime($datetime_start);
                                            $datetime_2 = new datetime($datetime_now);
                                            $diff = $datetime_1->diff($datetime_2);
                                            // $duration = $diff->format('%y years %m months %a days %h hours %i minutes %s seconds');
                                            $duration = $diff->format('%a days %h hours %i min %s sec');
                                        ?>
                                        <td align="center"><?php echo $duration; ?></td>
                                        <td align="center"><?php echo $progress->CHR_START_PREV_BY; ?></td>
                                    <?php } else if($data->INT_FLAG_STAT == 2){ ?>
                                        <td align="center">On Repair</td>
                                        <td align="center"><?php echo substr($progress->CHR_START_REPAIR_DATE, 6, 2) . '/' . substr($progress->CHR_START_REPAIR_DATE, 4, 2 ) . '/' . substr($progress->CHR_START_REPAIR_DATE, 0, 4 ); ?></td>
                                        <td align="center"><?php echo substr($progress->CHR_START_REPAIR_TIME, 0, 2 ) . ':' . substr($progress->CHR_START_REPAIR_TIME, 2, 2 ); ?></td>
                                        <?php 
                                            $datetime_now = date('Ymd') . ' ' . date('His');
                                            $datetime_start = $progress->CHR_START_REPAIR_DATE . ' ' . $progress->CHR_START_REPAIR_TIME;
                                            $datetime_1 = new datetime($datetime_start);
                                            $datetime_2 = new datetime($datetime_now);
                                            $diff = $datetime_1->diff($datetime_2);
                                            // $duration = $diff->format('%y years %m months %a days %h hours %i minutes %s seconds');
                                            $duration = $diff->format('%a days %h hours %i min %s sec');
                                        ?>
                                        <td align="center"><?php echo $duration; ?></td>
                                        <td align="center"><?php echo $progress->CHR_START_REPAIR_BY; ?></td>
                                    <?php } ?>                                    
                                </tr>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>	
            <div class="clearfix"></div>
        </div>
    </div>
    </br>
    <div style="height:150px;">
        <div class="hire-me" align="center">
            <h3>L O G G E D &nbsp; AS &nbsp; <span style="color:#00ff99;"> MR. <?php echo strtoupper($username) . '( ' . $npk . ' )'; ?> </span></h3>     
            <span style="color:white; font-size:16px; font-style:italic;"><?php echo date('l', strtotime(date('Ymd'))) . ', ' . date("d") . ' ' . date('F', strtotime(date('Ymd'))) . ' ' . date("Y") . ' ' . date("H:i:s"); ?></span>       
        </div>
        <div class="clearfix"></div>
    </div>
    </br>    
<!-- </div> -->

<script type="text/javascript">
    function show_drawing_type() {
        var id_part = '<?php echo $data->INT_ID; ?>';
        var id_type = '<?php echo $id_type; ?>';

        // location.href = "<?php echo site_url('Scan_c/drawing'); ?>/" + id_part + "/" + type;

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/get_drawing_type'); ?>",
            data: "part=" + id_part + "&type=" + id_type,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalDrawing").style.display = "block"; 
                $("#modalDrawing").html(data);
            }
        });
    }

    function manual_type() {
        var id_part = '<?php echo $data->INT_ID; ?>';
        var id_type = '<?php echo $id_type; ?>';

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/get_manual_type'); ?>",
            data: "part=" + id_part + "&type=" + id_type,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalManual").style.display = "block"; 
                $("#modalManual").html(data);
            }
        });
    }

    function fta_type() {
        var id_part = '<?php echo $data->INT_ID; ?>';
        var id_type = '<?php echo $id_type; ?>';

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/get_failure_type'); ?>",
            data: "part=" + id_part + "&type=" + id_type,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalFailure").style.display = "block"; 
                $("#modalFailure").html(data);
            }
        });
    }

    function historical() {
        var part_code = '<?php echo $qrcode; ?>';
        var id_type = '<?php echo $id_type; ?>';
        
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/get_historical_type'); ?>",
            data: "part=" + part_code + "&type=" + id_type,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalHistorical").style.display = "block"; 
                $("#modalHistorical").html(data);
            }
        });
    }

    function get_detail_part_no(id_part) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/get_detail_part_no'); ?>",
            data: "id=" + id_part,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalPart").style.display = "block"; 
                $("#modalPart").html(data);
            }
        });
    }

    function hide_detail_part_no() {
        document.getElementById("modalPart").style.display = "none"; 
    }

    function hide_drawing_type() {
        document.getElementById("modalDrawing").style.display = "none"; 
    }

    function hide_historical_type() {
        document.getElementById("modalHistorical").style.display = "none"; 
    }

    function hide_manual_type() {
        document.getElementById("modalManual").style.display = "none"; 
    }

    function hide_failure_type() {
        document.getElementById("modalFailure").style.display = "none"; 
    }

    function preventive() {
        var id_part = '<?php echo $data->INT_ID; ?>';
        var id_type = '<?php echo $id_type; ?>';

        location.href = "<?php echo site_url('Scan_c/process_preventive'); ?>/" + id_part + "/" + id_type;
    }

    function view_repair() {
        var id_part = '<?php echo $data->INT_ID; ?>';
        var id_type = '<?php echo $id_type; ?>';

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/view_repair'); ?>",
            data: "id=" + id_part + "&type=" + id_type,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalRepair").style.display = "block"; 
                $("#modalRepair").html(data);
            }
        });
    }

    function hide_repair() {
        document.getElementById("modalRepair").style.display = "none"; 
    }

    function view_preventive() {
        var id_part = '<?php echo $data->INT_ID; ?>';
        var id_type = '<?php echo $id_type; ?>';

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/view_preventive'); ?>",
            data: "id=" + id_part + "&type=" + id_type,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalPrev").style.display = "block"; 
                $("#modalPrev").html(data);
            }
        });
    }

    function hide_preventive() {
        document.getElementById("modalPrev").style.display = "none"; 
    }

    function view_change() {
        var id_part = '<?php echo $data->INT_ID; ?>';
        var id_type = '<?php echo $id_type; ?>';
        var stroke = '<?php echo $act_stroke; ?>';

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/view_change'); ?>",
            data: "id=" + id_part + "&type=" + id_type + "&strok=" + stroke,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalChange").style.display = "block"; 
                $("#modalChange").html(data);
            }
        });
    }

    function hide_change() {
        document.getElementById("modalChange").style.display = "none"; 
    }
</script>