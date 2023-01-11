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
                <li><a class="active" href="#">M A N U A L &nbsp; B O O K</a></li>
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
                <h3 style="letter-spacing:6px;">MANUAL BOOK</h3>
                <h2 align="middle" style="letter-spacing:6px;color:#00ff99;font-weight:bolder;"><?php echo $qrcode; ?></h2>
                <br>
                <div class="project">
                    <table id="dataTables3" style="color:white;font-size:12px;" class="table table-condensed"  cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Manual Book Code</th>
                            <th style="text-align:center;">Manual Book Name</th>
                            <th style="text-align:center;">Manual Book Type</th>
                            <th style="text-align:center;">Action</th>                          
                        </thead>
                        <tbody>
                            <?php
                                $no = 1; 
                                foreach($data as $row){ 
                            ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td align="center"><?php echo $row->CHR_WI_CODE; ?></td>
                                <td align="center"><?php echo $row->CHR_WI_NAME; ?></td>
                                <td align="center"><?php echo $row->CHR_WI_TYPE; ?></td>
                                <td align="center"><a onclick="view_manual(<?php echo $row->INT_ID; ?>)" style="color: #00ffff; text-decoration-line: underline;">View</a></td>
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
        <div class="modal" id="modalManual" tabindex="-1" align="center" style="display: none;"></div>
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
    function view_manual(id_wi) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('Scan_c/view_manual'); ?>",
            data: "id=" + id_wi,
            success: function (data) {
                // alert(data);     
                document.getElementById("modalManual").style.display = "block"; 
                $("#modalManual").html(data);
            }
        });
    }    

    function hide_manual() {
        document.getElementById("modalManual").style.display = "none"; 
    }
</script>