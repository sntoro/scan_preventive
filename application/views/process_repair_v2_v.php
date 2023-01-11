
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
                <li><a class="active" href="#">R E P A I R</a></li>
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
        <div>
            <div class="hire-me">                
                <h3 style="letter-spacing:6px;">REPAIR - <?php echo str_replace("--","/",$qrcode); ?></h3>
                <div class="project">
                    <div align="center">
                        <?php if($status == '1'){ ?>
                            <label><img src='<?php echo base_url(); ?>/assets/images/onprogress.png' width='40'></label>
                            <br><br>
                            <label style="color:white;">O N &nbsp; P R O G R E S S &nbsp; R E P A I R</label>
                        <?php } else if($status == '2') { ?>
                            <label><img src='<?php echo base_url(); ?>/assets/images/check1.png' width='40'></label>
                            <br><br>
                            <label style="color:white;">F I N I S H &nbsp; R E P A I R</label>
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
                                    <td align="center"><?php echo substr($progress->CHR_START_REPAIR_DATE, 6, 2) . '/' . substr($progress->CHR_START_REPAIR_DATE, 4, 2 ) . '/' . substr($progress->CHR_START_REPAIR_DATE, 0, 4 ) . ' ' . substr($progress->CHR_START_REPAIR_TIME, 0, 2 ) . ':' . substr($progress->CHR_START_REPAIR_TIME, 2, 2 ); ?></td>
                                    <?php if($progress->CHR_FINISH_REPAIR_DATE != NULL){ ?>
                                        <td align="center"><?php echo substr($progress->CHR_FINISH_REPAIR_DATE, 6, 2) . '/' . substr($progress->CHR_FINISH_REPAIR_DATE, 4, 2 ) . '/' . substr($progress->CHR_FINISH_REPAIR_DATE, 0, 4 ) . ' ' . substr($progress->CHR_FINISH_REPAIR_TIME, 0, 2 ) . ':' . substr($progress->CHR_FINISH_REPAIR_TIME, 2, 2 ); ?></td>
                                    <?php } else { ?>
                                        <td align="center">-</td>
                                    <?php } ?>
                                    <?php 
                                        if($progress->CHR_FINISH_REPAIR_DATE != NULL){
                                            $datetime_now = $progress->CHR_FINISH_REPAIR_DATE . ' ' . $progress->CHR_FINISH_REPAIR_TIME;
                                        } else {
                                            $datetime_now = date('Ymd') . ' ' . date('His');
                                        }
                                        $datetime_start = $progress->CHR_START_REPAIR_DATE . ' ' . $progress->CHR_START_REPAIR_TIME;
                                        $datetime_1 = new datetime($datetime_start);
                                        $datetime_2 = new datetime($datetime_now);
                                        $diff = $datetime_1->diff($datetime_2);
                                        // $duration = $diff->format('%y years %m months %a days %h hours %i minutes %s seconds');
                                        $duration = $diff->format('%a days %h hours %i min %s sec');
                                    ?>
                                    <td align="center"><?php echo $duration; ?></td>
                                    <td align="center"><?php echo $progress->CHR_START_REPAIR_BY; ?></td>
                                    <?php if($progress->CHR_FINISH_REPAIR_BY != NULL){ ?>
                                        <td align="center"><?php echo $progress->CHR_FINISH_REPAIR_BY; ?></td>
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
                </div>
                <br>
                <div class="project">
                    <?php if($status == '0'){ ?>
                    <div align="center">  
                        <input type="button" class="btn btn-info" value="S T A R T &nbsp; R E P A I R" onclick="start_repair()" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;"> 
                    </div>
                    <?php } else if($status <> '0'){ ?>
                    <?php echo form_open('Scan_c/finish_repair_v2/' . $qrcode, 'class="form-horizontal"'); ?>
                    <input type="hidden" class="text" name="id_part" id="id_part" value="<?php echo $id_part; ?>">
                    <input type="hidden" class="text" name="id_repair" id="id_repair" value="<?php echo $progress->INT_ID; ?>">
                    <input type="hidden" class="text" name="id_type" id="id_type" value="<?php echo $id_type; ?>">
                    <label style="color:white;">P R O B L E M <span style="color:red;">*</span></label>
                    <br>&nbsp;
                    <div align="center">
                            <input type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" name="problem" id="problem" placeholder="P R O B L E M" value="<?php echo $progress->CHR_PROBLEM; ?>" required onchange="changeColorButton()">
                    </div>
                    <br>
                    <label style="color:white;">R O O T &nbsp; C A U S E <span style="color:red;">*</span></label>
                    <br>&nbsp;
                    <div align="center">
                            <input type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" name="cause" id="cause" placeholder="R O O T &nbsp; C A U S E" value="<?php echo $progress->CHR_ROOT_CAUSE; ?>" required onchange="changeColorButton()">
                    </div>
                    <br>
                    <label style="color:white;">A C T I O N <span style="color:red;">*</span></label>
                    <br>&nbsp;
                    <div align="center">
                            <!-- <input type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" name="action" id="action" placeholder="ACTION" value="<?php if($progress->INT_FLG_REPAIR == '2'){ echo $progress->CHR_ACTION; } ?>" required> -->
                            <textarea type="text" <?php if($status == '2'){ echo "disabled"; } ?> class="text" name="action" id="action" placeholder="A C T I O N" required onchange="changeColorButton()"><?php echo $progress->CHR_ACTION; ?></textarea>
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
                                                WHERE INT_ID_ACTIVITY = '$progress->INT_ID' AND CHR_ACTIVITY_TYPE = 'R' AND INT_FLG_ORDER = '1' AND INT_FLG_DELETE = '0' 
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
                                                WHERE INT_ID_ACTIVITY = '$progress->INT_ID' AND CHR_ACTIVITY_TYPE = 'R' AND INT_FLG_DELETE = '0' 
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
                                            echo '<a class="label label-info" style="font-size:11px;" href="' . base_url('index.php/Scan_c/order_spareparts/'. $sp->INT_ID . '/' . $progress->INT_ID . '/' . $id_part . '/' . $id_type . '/R') . '">Order</a>&nbsp;&nbsp;';
                                        }
                                        
                                        echo '<a class="label label-danger" style="font-size:11px;" href="' . base_url('index.php/Scan_c/cancel_spareparts/'. $sp->INT_ID . '/' . $progress->INT_ID . '/' . $id_part . '/' . $id_type . '/R') . '">Cancel</a>';
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
                                        echo '<td align="center"><a class="label label-info" style="font-size:11px;" href="' . base_url('index.php/Scan_c/order_all_spareparts/'. $progress->INT_ID . '/R/' . $id_part . '/' . $id_type) . '">Order All</a></td>';
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
                            <input class="btn btn-info" <?php if($progress->INT_FLG_REPAIR == '2'){ echo 'disabled'; } ?> type="submit" name="update" id="update" value="U P D A T E &nbsp; P R O G R E S S" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">                             
                            <input class="btn btn-warning" <?php if($progress->INT_FLG_REPAIR == '2'){ echo 'disabled'; } else { echo $disabled_finish; } ?> type="submit" name="finish" value="F I N I S H &nbsp; R E P A I R" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;" onclick="return confirm('Are you sure want to FINISH this repair?');">                             
                        <?php 
                            } else {
                                if($progress->INT_FLG_CONFIRM == '0' || $progress->INT_FLG_CONFIRM == NULL){ 
                                    if($role == '1'){
                        ?>
                            <a class="btn btn-info" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;" href="<?php echo base_url('index.php/Scan_c/process_confirm_repair/'. $progress->INT_ID . '/' . $id_type); ?>">C O N F I R M</a>&nbsp;
                        <?php       }
                                } 
                        ?>
                            <a class="btn btn-warning" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;" href="<?php echo base_url('index.php/Scan_c/historical_repair/'. $qrcode . '/' . $id_type); ?>">B A C K &nbsp; T O &nbsp; H I S T O R Y</a>
                        <?php } ?>
                    </div>
                    <?php echo form_close(); ?>                           
                    <?php } ?>
                    <br>    
                </div>
            </div>	
            <div class="clearfix"></div>
        </div>
        <div class="modal" id="modalAddSparepart" tabindex="-1" align="middle" style="display: none;">
            <!-- Data by JSON -->
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

<script type="text/javascript" >
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
        var trans_type = 'R';
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
        location.href = "<?php echo site_url('Scan_c/update_spareparts'); ?>/" + id_sp + "/" + data1 + "/" + data2 + "/" +  data3 + "/" + qty + "/R";
    }

    function changeColorButton() {
        document.getElementById("update").style.backgroundColor = "blue"; 
    }

    // function start_repair() {
    //     var qr_no = "<?php echo $qrcode; ?>";
    //     location.href = "<?php echo site_url('Scan_c/start_repair'); ?>/" + qr_no;
    // }

    // function finish_repair() {
    //     var qr_no = "<?php echo $qrcode; ?>";
    //     location.href = "<?php echo site_url('Scan_c/finish_repair'); ?>/" + qr_no;
    // }
</script>