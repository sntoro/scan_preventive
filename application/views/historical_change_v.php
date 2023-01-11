<meta content='width=device-width; minimum-scale=1; initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
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
                <h3 style="letter-spacing:6px;">HISTORICAL CHANGE MODEL</h3>
                <h2 align="middle" style="letter-spacing:6px;color:#00ff99;font-weight:bolder;"><?php echo str_replace("--","/",$qrcode); ?></h2>
                <br>                
                <div class="project">
                    <div align="left">
                        <input type="hidden" class="text" name="part_code" id="part_code" value="<?php echo $qrcode; ?>">
                        <input type="hidden" class="text" name="id_type" id="id_type" value="<?php echo $id_type; ?>">  
                        <!-- <input type="text" onchange="search_list_repair()" class="text" name="search" id="search" placeholder="SEARCH" value=""> -->
                    </div>
                    <br>
                    <table id="dataTables3" style="color:white;font-size:12px;" class="table table-condensed table-hover display" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Part Code After</th>
                            <th style="text-align:center;">Problem</th>
                            <th style="text-align:center;">Date</th>
                            <th style="text-align:center;">Time</th>
                            <th style="text-align:center;">PIC</th>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1; 
                                foreach($data as $row){ 
                            ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td align="center"><?php echo $row->CHR_PART_CODE_AFTER; ?></td>
                                <td align="center"><?php echo $row->CHR_PROBLEM; ?></td>
                               <td align="center"><?php echo substr($row->CHR_CREATED_DATE, 6, 2) . '/' . substr($row->CHR_CREATED_DATE, 4, 2 ) . '/' . substr($row->CHR_CREATED_DATE, 0, 4 ); ?></td>
                                <td align="center">
                                    <?php 
                                        if(strlen($row->CHR_CREATED_TIME) < 6){
                                            echo '0' . substr($row->CHR_CREATED_TIME, 0, 1) . ':' . substr($row->CHR_CREATED_TIME, 1, 2 ) . ':' . substr($row->CHR_CREATED_TIME, 3, 2 ); 
                                        } else {
                                            echo substr($row->CHR_CREATED_TIME, 0, 2) . ':' . substr($row->CHR_CREATED_TIME, 2, 2 ) . ':' . substr($row->CHR_CREATED_TIME, 4, 2); 
                                        }
                                    ?>
                                </td>
                                <td align="center"><?php echo $row->CHR_CREATED_BY; ?></td>                                
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
<script type="text/javascript">
    // function search_list_repair() {
    //     var val = document.getElementById("search").value;
    //     var code = document.getElementById("part_code").value;
    //     var type = document.getElementById("id_type").value;

    //     location.href = "<?php echo site_url('Scan_c/search_list_repair'); ?>/" + code + "/"  + type + "/" + val;
    // } 
</script>