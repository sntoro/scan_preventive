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
                <li><a href="<?php echo base_url('index.php/Scan_c/scan_qr_part/'. $id_type); ?>"><?php echo $type; ?></a></li>
                <li><a href="<?php echo base_url('index.php/Scan_c/detail_menu/'. $qrcode . '/' . $id_type); ?>">M E N U</a></li>
                <li><a class="active" href="#">D R A W I N G</a></li>
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
                <h3 style="letter-spacing:6px;">DRAWING LIST</h3>
                <h2 align="middle" style="letter-spacing:6px;color:#00ff99;font-weight:bolder;"><?php echo $qrcode; ?></h2>
                <br>
                <div class="project">
                    <table id="dataTables3" style="color:white;font-size:12px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Drawing Code</th>
                            <th style="text-align:center;">Drawing Name</th>
                            <th style="text-align:center;">Drawing Type</th>
                            <th style="text-align:center;">2D</th>
                            <th style="text-align:center;">3D</th>                          
                        </thead>
                        <tbody>
                            <?php
                                $no = 1; 
                                foreach($data as $row){ 
                            ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td align="center"><?php echo $row->CHR_DRAWING_CODE; ?></td>
                                <td align="center"><?php echo $row->CHR_DRAWING_NAME; ?></td>
                                <td align="center"><?php echo $row->CHR_DRAWING_TYPE; ?></td>
                                <!-- DRAWING 2D -->
                                <?php
                                    $get_ext = explode(".", $row->CHR_FILE_DRAWING);
                                    $ext = end($get_ext);
                                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'PNG' || $ext == 'PDF' || $ext == 'pdf'){ 
                                ?>
                                <td align="center"><a onclick="view_drawing(<?php echo $row->INT_ID; ?>)" style="color: #00ffff; text-decoration-line: underline;">View</a></td>
                                <?php
                                    } else { 
                                ?>
                                <td align="center">
                                    <a href="<?php echo base_url('index.php/Scan_c/download_drawing') . '/' . $row->INT_ID . '/2D' ; ?>" style="color: #00ffff; text-decoration-line: underline;">Download</a>                                    
                                </td>
                                <?php
                                    }
                                ?>
                                <!-- DRAWING 3D -->
                                <?php   
                                    $get_ext = explode(".", $row->CHR_FILE_DRAWING);
                                    $ext = end($get_ext);
                                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'PNG'){ 
                                ?>
                                <td align="center"><a onclick="view_drawing(<?php echo $row->INT_ID; ?>)" style="color: #00ffff; text-decoration-line: underline;">View</a></td>
                                <?php
                                    } else { 
                                ?>
                                <td align="center"><a href="<?php echo base_url('index.php/Scan_c/download_drawing') . '/' . $row->INT_ID . '/3D' ; ?>" style="color: #00ffff; text-decoration-line: underline;">Download</a></td>
                                <?php
                                    }
                                ?>
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
        <div class="modal" id="modalDrawing" tabindex="-1" align="center" style="display: none;"></div>
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
    function view_drawing(id_drw) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/view_drawing'); ?>",
            data: "id=" + id_drw,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalDrawing").style.display = "block"; 
                $("#modalDrawing").html(data);
            }
        });
    }    

    function hide_drawing() {
        document.getElementById("modalDrawing").style.display = "none"; 
    }
</script>