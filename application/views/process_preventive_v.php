
<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

    <?php       
        $type = '';
        $sp_area = '';
        if($id_type == 'A'){
            $type = 'M O L D';
            $sp_area = 'MT01';
        } else if($id_type == 'B'){
            $type = 'D I E S   S T P';
            $sp_area = 'MT01';
        } else if($id_type == 'C'){
            $type = 'D I E S   D F';
            $sp_area = 'MT02';
        } else if($id_type == 'D'){
            $type = 'M A C H I N E';
            $sp_area = 'MT03';
        } else if($id_type == 'E'){
            $type = 'J I G';
            $sp_area = 'EN01';
        }
    
    ?>

    <div>
        <div class="top-menu">
            <span class="menu"><img src="<?php echo base_url('assets/images/menu.png'); ?>"> </span>
            <ul>
                <li><a href="<?php echo base_url('index.php/Scan_c/scan_qr_part/'. $id_type); ?>"><?php echo $type; ?></a></li>
                <li><a href="<?php echo base_url('index.php/Scan_c/detail_menu/'. $qrcode . '/' . $id_type); ?>">M E N U</a></li>
                <li><a class="active" href="#">P R E V E N T I V E</a></li>
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
    
    <div class="total-info" onclick="focus()">
        <div>
            <div class="hire-me">                
                <h3 style="letter-spacing:6px;">PREVENTIVE - <?php echo str_replace("--","/",$qrcode); ?></h3>
                <div class="project">
                    <?php if($status == '0'){ ?>
                    <div align="center">  
                        <input type="button" class="btn btn-info" value="S T A R T &nbsp; P R E V E N T I V E" onclick="start_prev()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;"> 
                    </div>
                    <?php } else if($status <> '0'){ ?>
                    <?php echo form_open('Scan_c/finish_preventive/' . $progress->INT_ID, 'class="form-horizontal"'); ?>
                    <div align="center">
                        <input type="hidden" class="text" name="id_part" id="id_part" value="<?php echo $id_part; ?>">
                        <input type="hidden" class="text" name="id_type" id="id_type" value="<?php echo $id_type; ?>">
                        <?php if($status == '1'){ ?>
                            <label><img src='<?php echo base_url(); ?>/assets/images/onprogress.png' width='40'></label>
                            <br><br>
                            <label style="color:white;">O N &nbsp; P R O G R E S S &nbsp; P R E V E N T I V E</label>
                        <?php } else if($status == '2') { ?>
                            <label><img src='<?php echo base_url(); ?>/assets/images/check1.png' width='40'></label>
                            <br><br>
                            <label style="color:white;">F I N I S H &nbsp; P R E V E N T I V E</label>
                        <?php } ?>

                        <br>&nbsp;
                        <table style="color:white;font-size:12px;" class="table table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <th style="text-align:center;">Start Date & Time</th>
                                <th style="text-align:center;">Finish Date & Time</th>
                                <th style="text-align:center;">Duration</th> 
                                <th style="text-align:center;">Start By</th>
                                <th style="text-align:center;">Finish By</th> 
                                <th style="text-align:center;">Confirm By</th>                         
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center"><?php echo substr($progress->CHR_START_PREV_DATE, 6, 2) . '/' . substr($progress->CHR_START_PREV_DATE, 4, 2 ) . '/' . substr($progress->CHR_START_PREV_DATE, 0, 4 ) . ' ' . substr($progress->CHR_START_PREV_TIME, 0, 2 ) . ':' . substr($progress->CHR_START_PREV_TIME, 2, 2 ); ?></td>
                                    <?php if($progress->CHR_FINISH_PREV_DATE != NULL){ ?>
                                        <td align="center"><?php echo substr($progress->CHR_FINISH_PREV_DATE, 6, 2) . '/' . substr($progress->CHR_FINISH_PREV_DATE, 4, 2 ) . '/' . substr($progress->CHR_FINISH_PREV_DATE, 0, 4 ) . ' ' . substr($progress->CHR_FINISH_PREV_TIME, 0, 2 ) . ':' . substr($progress->CHR_FINISH_PREV_TIME, 2, 2 ); ?></td>
                                    <?php } else { ?>
                                        <td align="center">-</td>
                                    <?php } ?>
                                    <?php 
                                        if($progress->CHR_FINISH_PREV_DATE != NULL){
                                            $datetime_now = $progress->CHR_FINISH_PREV_DATE . ' ' . $progress->CHR_FINISH_PREV_TIME;
                                        } else {
                                            $datetime_now = date('Ymd') . ' ' . date('His');
                                        }
                                        $datetime_start = $progress->CHR_START_PREV_DATE . ' ' . $progress->CHR_START_PREV_TIME;
                                        $datetime_1 = new datetime($datetime_start);
                                        $datetime_2 = new datetime($datetime_now);
                                        $diff = $datetime_1->diff($datetime_2);
                                        // $duration = $diff->format('%y years %m months %a days %h hours %i minutes %s seconds');
                                        $duration = $diff->format('%a days %h hours %i min %s sec');
                                    ?>
                                    <td align="center"><?php echo $duration; ?></td>
                                    <td align="center"><?php echo $progress->CHR_START_PREV_BY; ?></td>
                                    <?php if($progress->CHR_FINISH_PREV_BY != NULL){ ?>
                                        <td align="center"><?php echo $progress->CHR_FINISH_PREV_BY; ?></td>
                                    <?php } else { ?>
                                        <td align="center">-</td>
                                    <?php } ?>
                                    <?php if($progress->CHR_CONFIRM_BY != NULL){ ?>
                                        <td align="center"><?php echo $progress->CHR_CONFIRM_BY; ?></td>
                                    <?php } else { ?>
                                        <td align="center">-</td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <label style="color:white;">C H E C K S H E E T <span style="color:red;">*</span></label>
                    <br>&nbsp;
                    <div align="center">
                        <table id="example1" style="color:white;font-size:12px;" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Checksheet Code</th>
                                <th style="text-align:center;">Checksheet Name</th>
                                <th style="text-align:center;">Last Update</th>
                                <th style="text-align:center;">Check</th> 
                                <th style="text-align:center;">Action</th>                         
                            </thead>
                            <tbody>
                                <?php
                                    $stat = 0;
                                    $no = 1;
                                    foreach($checksheet as $row){
                                ?>
                                <tr>
                                    <td align="center"><?php echo $no; ?></td>
                                    <td align="center"><?php echo $row->CHR_CHECKSHEET_CODE; ?></td>
                                    <td align="center"><?php echo $row->CHR_CHECKSHEET_NAME; ?></td>
                                    <?php if($row->CHR_MODIFIED_DATE == NULL){ ?>
                                        <td align="center"><?php echo substr($row->CHR_CREATED_DATE, 6, 2) . '/' . substr($row->CHR_CREATED_DATE, 4, 2 ) . '/' . substr($row->CHR_CREATED_DATE, 0, 4 ); ?></td>
                                    <?php } else { ?>
                                        <td align="center"><?php echo substr($row->CHR_MODIFIED_DATE, 6, 2) . '/' . substr($row->CHR_MODIFIED_DATE, 4, 2 ) . '/' . substr($row->CHR_MODIFIED_DATE, 0, 4 ); ?></td>
                                    <?php } ?>

                                    <?php 
                                        $id_checksheet = $row->INT_ID;
                                        $id_prev = $progress->INT_ID;
                                        // $check = $this->db->query("SELECT COUNT(INT_ID) AS TOTAL_ROW FROM MTE.TT_CHECKSHEET_PREVENTIVE WHERE INT_ID_PREV_DETAIL = '$id_prev' AND INT_ID_CHECKSHEET = '$id_checksheet'")->row();
                                        $check = $this->db->query("SELECT B.INT_ID_CHECKSHEET, COUNT(A.INT_ID) AS TOTAL_ROW FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL A
                                                                    LEFT JOIN (SELECT X.INT_ID, X.INT_ID_CHECKSHEET FROM MTE.TM_ACTIVITY_PREVENTIVE X
                                                                                LEFT JOIN MTE.TM_CHECKSHEET_PREVENTIVE Y ON X.INT_ID_CHECKSHEET = Y.INT_ID) B ON A.INT_ID_ACTIVITY = B.INT_ID
                                                                    WHERE B.INT_ID_CHECKSHEET = '$id_checksheet'
                                                                    GROUP BY B.INT_ID_CHECKSHEET")->row();
                                        if($check->TOTAL_ROW > 0){
                                            $tot_check = $this->db->query("SELECT COUNT(INT_ID) AS TOTAL_ROW FROM MTE.TT_CHECKSHEET_PREVENTIVE WHERE INT_ID_PREV_DETAIL = '$id_prev' AND INT_ID_CHECKSHEET = '$id_checksheet' AND INT_FLG_CHECK = '1'")->row();
                                            if($tot_check->TOTAL_ROW == 0){
                                                $stat = 0;
                                                echo '<td align="center" style="background-color:red;">0/' . $check->TOTAL_ROW . '</td>';
                                            } else {
                                                if($tot_check->TOTAL_ROW == $check->TOTAL_ROW){
                                                    $stat = 1;
                                                    echo '<td align="center" style="background-color:green;">' . $tot_check->TOTAL_ROW . '/' . $check->TOTAL_ROW .'</td>';
                                                } else {
                                                    $stat = 0;
                                                    echo '<td align="center" style="background-color:orange;">' . $tot_check->TOTAL_ROW . '/' . $check->TOTAL_ROW .'</td>';
                                                }
                                            }                                            
                                        }
                                    ?>
                                    
                                    <td align="center"><a onclick="edit_checksheet(<?php echo $row->INT_ID; ?>)" style="color: #00ffff; text-decoration-line: underline;"><?php if($status == '2'){ echo 'View'; } else { echo 'Edit'; } ?></a></td>
                                </tr>
                                <?php
                                    $no++;
                                    }
                                ?>                                
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <label style="color:white;">S P A R E P A R T</label>
                    <br>&nbsp;
                    <?php 
                        $style = "display:none;";
                        // $sp_part = "";
                        $qty = "";
                        $check1 = "";
                        $check2 = "";
                        $disabled_radio = "";                        
                        if($progress->INT_FLG_SPARE_PART == 1){
                            $style = "display:block;";
                            $check2 = "checked";
                            // $sp_part = $progress->CHR_SPARE_PART_NAME;
                            // $qty = $progress->INT_QTY_SPARE_PART;

                            $check_ordered_sp = $this->db->query("SELECT * 
                                                FROM MTE.TT_SPARE_PARTS_USAGE 
                                                WHERE INT_ID_ACTIVITY = '$progress->INT_ID' AND CHR_ACTIVITY_TYPE = 'P' AND INT_FLG_ORDER = '1' AND INT_FLG_DELETE = '0' 
                                                ORDER BY CHR_PART_NO");
                            if($check_ordered_sp->num_rows() > 0){
                                $disabled_radio = "disabled";
                            }
                        } else {
                            $check1 = "checked";
                        }
                    ?>
                    <div align="left" style="color:white;">
                        <input type="radio" <?php if($status == '2'){ echo "disabled"; } else { echo $disabled_radio; }; ?> onclick="show_sparepart(0); changeColorButton()" name="opt_radio" id="opt_radio" value="0" <?php echo $check1; ?>>&nbsp; N O
                        &nbsp;
                        <input type="radio" <?php if($status == '2'){ echo "disabled"; } ?> onclick="show_sparepart(1); changeColorButton()" name="opt_radio" id="opt_radio" value="1" <?php echo $check2; ?>>&nbsp; Y E S
                    </div>
                    &nbsp;                                      
                    <div align="left" id="sparepart" style="<?php echo $style; ?>">
                            <!-- <input type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" name="sparepart_name" id="sparepart_name" placeholder="SPAREPART NAME" value="<?php echo $sp_part; ?>" style="width:83%;"> -->
                            <!-- &nbsp; -->
                            <!-- <input type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" name="qty" id="qty" placeholder="QTY" value="<?php echo $qty; ?>" style="width:15%;"> -->
                            <!-- &nbsp; -->
                            <table width="100%">
                            <tr>
                                <td width="80%">
                                    <input type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" placeholder="K E Y W O R D S" name="keywords" id="keywords" value="" style="width:100%;">
                                </td>
                                <td width="2%"></td>
                                <td width="18%">
                                    <a onclick="add_spareparts(<?php echo $progress->INT_ID; ?>)" class="btn btn-info" <?php if($status == '2'){ echo "disabled"; } ?>>S E A R C H &nbsp; S P A R E P A R T S</a>
                                </td>
                            </tr>
                            </table>
                            <!-- <textarea <?php //if($status == '2'){ echo "disabled"; } ?> class="text" name="sparepart_name" id="sparepart_name" placeholder="SPAREPART NAME" style="width:83%;"><?php //echo $sp_part; ?></textarea> -->
                    </div>
                    &nbsp;
                    <div id="table_sparepart" style="<?php echo $style; ?>">
                    <?php 
                        $disabled_finish = "";
                        if($progress->INT_FLG_SPARE_PART == 1){ 
                            $get_sp = $this->db->query("SELECT A.INT_ID, A.INT_ID_SPARE_PART, A.CHR_PART_NO, A.INT_QTY, B.CHR_SPARE_PART_NAME, B.CHR_MODEL, B.CHR_BACK_NO, B.CHR_COMPONENT, B.CHR_SPECIFICATION, B.INT_QTY_ACT, A.INT_FLG_ORDER 
                                                FROM MTE.TT_SPARE_PARTS_USAGE A 
                                                LEFT JOIN (SELECT DISTINCT X.INT_ID, X.CHR_PART_NO, X.CHR_BACK_NO, X.CHR_SPARE_PART_NAME, X.CHR_COMPONENT, X.CHR_MODEL, X.CHR_TYPE, X.CHR_SPECIFICATION, 
                                                        X.INT_QTY_USE, X.INT_QTY_MIN, X.INT_QTY_MAX, (CONVERT(FLOAT,X.CHR_PRICE)) AS CHR_PRICE, X.CHR_PART_TYPE, Y.INT_QTY AS INT_QTY_ACT, X.CHR_FILENAME, X.CHR_FLAG_DELETE, 
                                                        X.CHR_CREATED_BY, X.CHR_CREATED_DATE, X.CHR_CREATED_TIME, X.CHR_MODIFIED_BY, X.CHR_MODIFIED_DATE, X.CHR_MODIFIED_TIME
                                                        FROM DB_SAMANTA.dbo.TM_SPARE_PARTS X
                                                        INNER JOIN DB_SAMANTA.dbo.TT_SPARE_PARTS_SLOC Y ON Y.CHR_PART_NO = X.CHR_PART_NO
                                                        WHERE X.CHR_FLAG_DELETE = 'F' AND Y.CHR_SLOC = '$sp_area') B ON A.INT_ID_SPARE_PART = B.INT_ID 
                                                WHERE INT_ID_ACTIVITY = '$progress->INT_ID' AND CHR_ACTIVITY_TYPE = 'P' AND INT_FLG_DELETE = '0' 
                                                ORDER BY CHR_PART_NO");
                            if($get_sp->num_rows() > 0){
                                echo '<table id="example" style="color:white;font-size:12px;" class="table table-condensed table-hover display" cellspacing="0" width="100%">';
                                echo '<thead>';
                                echo '<th style="text-align:center;">No</th>';
                                echo '<th style="text-align:center;">Part No</th>';
                                echo '<th style="text-align:center;">Part Name</th>';
                                echo '<th style="text-align:center;">Back No</th>';
                                echo '<th style="text-align:center;">Comp</th>';
                                echo '<th style="text-align:center;">Model</th>';
                                echo '<th style="text-align:center;">Specification</th>';
                                echo '<th style="text-align:center;">Qty Actual</th>';
                                echo '<th style="text-align:center;">Qty Order</th>';
                                echo '<th style="text-align:center;">Status</th>';
                                echo '<th style="text-align:center;">Action</th>';
                                echo '</thead>';
                                echo '<tbody>';
                                $no = 1;
                                $stat_err = 0;
                                $row = 0;
                                $row_order = 0;
                                foreach($get_sp->result() as $sp){
                                    echo '<tr>';
                                    echo '<td align="center">' . $no . '</td>';
                                    echo '<td align="center">' . $sp->CHR_PART_NO . '</td>';
                                    echo '<td align="center">' . $sp->CHR_SPARE_PART_NAME . '</td>';
                                    echo '<td align="center">' . $sp->CHR_BACK_NO . '</td>';
                                    echo '<td align="center">' . $sp->CHR_COMPONENT . '</td>';
                                    echo '<td align="center">' . $sp->CHR_MODEL . '</td>';
                                    echo '<td align="center">' . $sp->CHR_SPECIFICATION . '</td>';
                                    echo '<td align="center">' . $sp->INT_QTY_ACT . '</td>';                                    
                                    $change_qty = '';
                                    $stat_sp = '-';
                                    if($sp->INT_FLG_ORDER == 1){                                        
                                        $change_qty = 'disabled';
                                        $stat_sp = '<img src="' . base_url() .'/assets/images/ok_summary.png" width="20">';
                                        $row_order++;
                                    }
                                    echo '<td align="center"><input type="number" name="qty_sp" id="qty_sp" onchange="update_qty_spareparts(this.value, '. $sp->INT_ID .');" style="width:50px;color:black;" ' . $change_qty . ' min="0" max="' . $sp->INT_QTY_ACT . '" value="' . $sp->INT_QTY . '"></td>';
                                    echo '<td align="center">' . $stat_sp . '</td>';
                                    echo '<td align="center">';
                                    if($sp->INT_FLG_ORDER == 1){
                                        echo '<a class="label label-default" style="font-size:11px;" href="#">Order</a>&nbsp;&nbsp;';
                                        echo '<a class="label label-default" style="font-size:11px;" href="#">Cancel</a>';
                                    } else {
                                        if($sp->INT_QTY > $sp->INT_QTY_ACT){
                                            $stat_err = 1;
                                            echo '<a class="label label-default" style="font-size:11px;" href="#">Order</a>&nbsp;&nbsp;';
                                        } else {
                                            echo '<a class="label label-info" style="font-size:11px;" href="' . base_url('index.php/Scan_c/order_spareparts/'. $sp->INT_ID . '/' . $progress->INT_ID . '/' . $id_part . '/' . $id_type . '/P') . '">Order</a>&nbsp;&nbsp;';
                                        }
                                        
                                        echo '<a class="label label-danger" style="font-size:11px;" href="' . base_url('index.php/Scan_c/cancel_spareparts/'. $sp->INT_ID . '/' . $progress->INT_ID . '/' . $id_part . '/' . $id_type . '/P') . '">Cancel</a>';
                                    }
                                    
                                    echo '</td>';
                                    echo '</tr>';
                                    $row++;
                                    $no++;
                                }
                                echo '<tr>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';
                                echo '<td align="center"></td>';                                
                                if($stat_err == 1){
                                    $disabled_finish = "disabled";
                                    echo '<td align="center"><a class="label label-default" style="font-size:11px;" href="#">Order All</a></td>';
                                } else {
                                    if($row == $row_order){
                                        echo '<td align="center"><a class="label label-default" style="font-size:11px;" href="#">Order All</a></td>';
                                    } else {
                                        $disabled_finish = "disabled";
                                        echo '<td align="center"><a class="label label-info" style="font-size:11px;" href="' . base_url('index.php/Scan_c/order_all_spareparts/'. $progress->INT_ID . '/P/' . $id_part . '/' . $id_type) . '">Order All</a></td>';
                                    }                                    
                                }
                                echo '</tr>';
                                echo '</tbody>';
                                echo '</table>';
                            }
                    ?> 

                    <?php } ?>
                    </div>
                    <br>
                    <label style="color:white;">N O T E S <span style="color:red;">*</span></label>
                    <br>&nbsp;
                    <div align="center">                            
                            <input type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" name="notes" id="notes" placeholder="N O T E S" value="<?php echo $progress->CHR_REMARKS; ?>" required onchange="changeColorButton()">
                    </div>
                    <br>
                    <div align="center">
                        <?php if($status <> '2'){ ?>
                            <input class="btn btn-info" <?php if($progress->INT_FLG_PREV == '2'){ echo 'disabled'; } ?> type="submit" name="update" id="update" value="U P D A T E &nbsp; P R O G R E S S" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">
                            <input class="btn btn-warning" <?php if($stat == 0){ echo 'disabled'; } else { echo $disabled_finish; } ?> type="submit" name="finish" value="F I N I S H &nbsp; P R E V E N T I V E"  style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">                             
                        <?php 
                            } else {
                                if($progress->INT_FLG_CONFIRM == '0' || $progress->INT_FLG_CONFIRM == NULL){ 
                                    if($role == '1'){
                        ?>
                            <a class="btn btn-info" href="<?php echo base_url('index.php/Scan_c/process_confirm_preventive/'. $progress->INT_ID . '/' . $id_type); ?>">C O N F I R M</a>&nbsp;
                        <?php       }
                                } 
                        ?>
                            <a class="btn btn-warning" href="<?php echo base_url('index.php/Scan_c/historical_preventive/'. $qrcode . '/' . $id_type); ?>">B A C K &nbsp; T O &nbsp; H I S T O R Y</a>
                        <?php } ?>
                    </div>
                    <?php echo form_close(); ?>                           
                    <?php } ?>
                    <br>    
                </div>                
                <div class="project">
                    
                </div>
                <br>
            </div>	
            <div class="clearfix"></div>
        </div>
        <div class="modal" id="modalEdit" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalAddSparepart" tabindex="-1" align="middle" style="display: none;"></div>
        <div class="modal" id="modalNote" tabindex="-1" align="center" style="display: none;"></div>
        <div class="modal" id="modalChart" tabindex="-1" align="center" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">                                   
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" onclick="hide_his_chart()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalprogress"><strong>History Chart</strong></h4>
                        </div>
                        <input type="hidden" id="test" value="2">
                        <div class="modal-body">
                            <div id="chartRange2" style="height: 400px; width: 100%;">
                                <!-- <iframe src="<?php // echo site_url('Scan_c/test_chart'); ?>" height="450px" width="100%" scrolling="no" frameborder="0" allowtransparency="true"></iframe> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

<script type="text/javascript" src="<?php echo base_url('assets/script/newcanvas.js'); ?>"></script>
<script type="text/javascript" >
    function edit_checksheet(id_checksheet) {
        var id_preventive = '<?php echo $progress->INT_ID; ?>';

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/edit_checksheet'); ?>",
            data: "id=" + id_checksheet + "&id_prev=" + id_preventive,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalEdit").style.display = "block"; 
                $("#modalEdit").html(data);
            }
        });
    }    

    function hide_edit() {
        document.getElementById("modalEdit").style.display = "none"; 
    }

    // function add_notes(id_act) {
    //     $.ajax({
    //         async: false,
    //         type: "POST",
    //         url: "<?php // echo site_url('Scan_c/add_note'); ?>",
    //         data: "id=" + id_act,
    //         success: function (data) {
    //             // alert(data);     
    //             document.getElementById("modalNote").style.display = "block"; 
    //             $("#modalNote").html(data);
    //         }
    //     });
    // }    

    // function hide_note() {
    //     document.getElementById("modalNote").style.display = "none"; 
    // }

    function show_sparepart(opt_val){
        //  var opt_val =  document.getElementById("opt_radio").value;
        if(opt_val == 0){
            document.getElementById("sparepart").style.display = "none"; 
            document.getElementById("table_sparepart").style.display = "none";
        } else {
            document.getElementById("sparepart").style.display = "block"; 
            document.getElementById("table_sparepart").style.display = "block";
        }
    }

    function add_spareparts(id_repair) {
        // document.getElementById('update').click();

        var id_type = '<?php echo $id_type; ?>';
        var trans_type = 'P';
        var keyword =  document.getElementById("keywords").value;

        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/add_spareparts'); ?>",
            data: "trans_type=" + trans_type + "&trans_id=" + id_repair + "&type=" + id_type + "&key=" + keyword,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalAddSparepart").style.display = "block"; 
                $("#modalAddSparepart").html(data);
            }
        });
    } 

    function hide_add_sparepart() {
        document.getElementById("modalAddSparepart").style.display = "none"; 
    }

    function update_qty_spareparts(qty, id_sp){
        var data1 = <?php echo $progress->INT_ID; ?>;
        var data2 = <?php echo $id_part; ?>;
        var data3 = <?php echo '"' . $id_type . '"'; ?>;
        location.href = "<?php echo site_url('Scan_c/update_spareparts'); ?>/" + id_sp + "/" + data1 + "/" + data2 + "/" +  data3 + "/" + qty + "/P";
    }

    function changeColorButton() {
        document.getElementById("update").style.backgroundColor = "blue"; 
    }

    function show_his_chart(id_check_det) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/show_history_chart'); ?>",
            data: "id_check=" + id_check_det,
            success: function (data) {
                // alert(data);
                document.getElementById("modalChart").style.display = "block"; 
                $("#chartRange2").html(data);                
            }
        });
    } 
    
    function hide_his_chart() {
        document.getElementById("modalChart").style.display = "none"; 
    }

    // window.onload = function() {
    //     var val_test = document.getElementById("test").value;
    //     var chart_range = new CanvasJS.Chart("chartRange2", {
    //         animationEnabled: true,
    //         theme: "light",
    //         title: {
    //             text: "Data Range",
    //             fontFamily: "tahoma"
    //         },
    //         legend: {
    //             horizontalAlign: "center",
    //             verticalAlign: "bottom",
    //             fontSize: 12
    //         },
    //         axisY: {
    //             title: "Range",
    //             includeZero: false,
    //             interval: 0.01,
    //             minimum: 82.30,
    //             maximum: 82.35,
    //             gridThickness: 1,
    //             gridDashType: "dash",
    //             suffix: " mm",
    //             stripLines: [{
    //                     value: 82.31,
    //                     lineThickness: 2,
    //                     showOnTop: true,
    //                     label: "Min SL = 82.31",
    //                     labelFontColor: "#ed1e1a",
    //                     color: "#ed1e1a"
    //                 },
    //                 {
    //                     value: 82.34,
    //                     lineThickness: 2,
    //                     showOnTop: true,
    //                     label: "Max SL = 82.34",
    //                     labelFontColor: "#ed1e1a",
    //                     color: "#ed1e1a"
    //                 }
    //             ]
    //         },
    //         axisX: {
    //             title: "Date",
    //             labelMaxWidth: 75,
    //             labelWrap: true
    //         },
    //         toolTip: {
    //             shared: true
    //         },
    //         data: [{
    //             type: "line",
    //             name: "Range",
    //             showInLegend: true,
    //             legendText: "Data Range Hasil",
    //             toolTipContent: "<span style=\"color:#C0504E\">{name}</span> : {y} mm",
    //             dataPoints: [
    //                 {
    //                     y: 82.33,
    //                     label: "xx"
    //                 },
    //                 {
    //                     y: 82.32,
    //                     label: "xx"
    //                 }
    //             ]
    //         }]
    //     });
    //     chart_range.render();
    // }

</script>