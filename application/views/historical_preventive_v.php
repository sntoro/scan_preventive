<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

    <?php   
        $type = '';
        if($id_type =='A'){
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
                <li><a href="<?php echo base_url('index.php/Scan_c/scan_qr_part/'. $id_type); ?>"><?php echo $type; ?></a></li>
                <li><a href="<?php echo base_url('index.php/Scan_c/detail_menu/'. $qrcode . '/' . $id_type); ?>">M E N U</a></li>
                <li><a class="active" href="#">H I S T O R I C A L</a></li>
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
                <h3 style="letter-spacing:6px;">HISTORICAL PREVENTIVE</h3>
                <h2 align="middle" style="letter-spacing:6px;color:#00ff99;font-weight:bolder;"><?php echo str_replace("--","/",$qrcode); ?></h2>
                </br>
                <div class="project">
                    <table id="dataTables3" style="color:white;font-size:12px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">No</th>
                            <!-- <th style="text-align:center;">Part Code</th> -->
                            <th style="text-align:center;">Plan Stroke</th>
                            <th style="text-align:center;">Act Stroke</th>
                            <th style="text-align:center;">Prev Type</th>
                            <th style="text-align:center;">Date</th>
                            <th style="text-align:center;">Time</th>
                            <th style="text-align:center;">PIC Prev</th>                            
                            <th style="text-align:center;">Confirm</th>
                            <th style="text-align:center;">PIC Confirm</th> 
                            <th style="text-align:center;">Detail</th>                         
                        </thead>
                        <tbody>
                            <?php
                                $no = 1; 
                                foreach($data as $row){ 
                            ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <!-- <td align="center"><?php echo $row->CHR_PART_CODE; ?></td> -->
                                <td align="center"><?php echo number_format($row->INT_PLAN_COUNT,0,',','.'); ?></td>
                                <td align="center"><?php echo number_format($row->INT_COUNT,0,',','.'); ?></td>
                                <td align="center"><?php echo $row->CHR_TYPE_PREV; ?></td>
                                <td align="center"><?php echo substr($row->CHR_CREATED_DATE, 6, 2) . '/' . substr($row->CHR_CREATED_DATE, 4, 2 ) . '/' . substr($row->CHR_CREATED_DATE, 2, 2 ) . ' '; ?></td>
                                <td align="center">
                                    <?php                                         
                                        if(strlen($row->CHR_CREATED_TIME) < 6){
                                            echo '0' . substr($row->CHR_CREATED_TIME, 0, 1) . ':' . substr($row->CHR_CREATED_TIME, 1, 2 ); 
                                        } else {
                                            echo substr($row->CHR_CREATED_TIME, 0, 2) . ':' . substr($row->CHR_CREATED_TIME, 2, 2 ); 
                                        }
                                    ?>
                                </td>
                                <td align="center"><?php echo $row->CHR_CREATED_BY; ?></td>
                                <!-- <td align="center"><a onclick="view_detail(<?php echo $row->INT_ID; ?>)" style="color: #00ffff; text-decoration-line: underline;">View</a></td> -->
                                <td align="center">
                                <?php
                                    if($row->INT_FLG_CONFIRM == 1){
                                        echo "<img src='" . base_url() . "/assets/images/check1.png' width='18'>";
                                    } else {
                                        echo "<img src='" . base_url() . "/assets/images/error1.png' width='18'>";
                                    }
                                ?>
                                </td>
                                <td align="center">
                                <?php
                                    if($row->CHR_CONFIRM_BY != NULL){ 
                                        echo $row->CHR_CONFIRM_BY; 
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td align="center"><a href="<?php echo base_url('index.php/Scan_c/process_preventive/'. $row->INT_ID . '/' . $id_type . '/2'); ?>" style="color: #00ffff; text-decoration-line: underline;">View</a></td>
                            </tr>
                            <?php 
                                $no++; 
                                } 
                            ?>
                        </tbody>
                    </table>                    
                </div>
            </div>	
            <div class="clearfix"></div>
        </div>
        <div class="modal" id="modalPrev" tabindex="-1" align="center" style="display: none;"></div>
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
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script type="text/javascript">
    function view_detail(id_prev) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/view_detail_prev'); ?>",
            data: "id=" + id_prev,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalPrev").style.display = "block"; 
                $("#modalPrev").html(data);
            }
        });
    }    

    function hide_detail_prev() {
        document.getElementById("modalPrev").style.display = "none"; 
    }

    $(document).ready(function() {
        $('#dataTables3').DataTable({
            destroy: true,
            scrollX: true,
            lengthMenu: [
                [10, 25, 50],
                [10, 25, 50]
            ]
        });
    });
</script>