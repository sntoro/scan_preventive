<style>
.a {
    color: #fff;
    text-transform: ;
    font-size: 0.9em;
    font-weight: 600;
    text-align: center;
    margin-bottom:0em;
    letter-spacing:2px;
}
.shell {
  position: relative;
  line-height: 1; }
  .shell span {
    position: absolute;
    left: 3px;
    top: 1px;
    color: #ccc;
    pointer-events: none;
    z-index: -1; }
    .shell span i {
      font-style: normal;
      /* any of these 3 will work */
      color: transparent;
      opacity: 0;
      visibility: hidden; }

input.masked,
.shell span {
  padding-right: 10px;
  background-color: transparent;
  text-transform: uppercase; }
</style>

<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

    <div>
        <div class="top-menu">
            <span class="menu"><img src="<?php echo base_url('assets/images/menu.png'); ?>"> </span>
            <ul>
                <li><a href="<?php echo base_url('index.php/Scan_c'); ?>">P E V I T A</a></li>
                <li><a class="active" href="#">S C A N &nbsp; R E P A I R</a></li>
                <li><a href="<?php echo base_url('index.php/Login_c'); ?>" onclick="return confirm('Are you sure want to LOGOUT?');">L O G O U T</a></li>
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
                <h3>SCAN QR TRAY - REPAIR</h3>   
                <div align="center" style="width:300;">
                    <?php if (isset($error)) {
                        ?>
                        <span style="color:#ff3333;"><strong>ERROR</strong></span>
                        <div style="background: #ff3333; color:#ffffff;"><?php echo $error; ?></div>
                        </br>
                    <?php } ?>
                    <?php if (isset($success)) {
                        ?>
                        <span style="color:#66ff66;"><strong>SUCCESS</strong></span>
                        <div style="background: #66ff66; color:#000000;"><?php echo $success; ?></div>
                        </br>
                    <?php } ?>
                </div>                                        
                <div class="project">
                    <div>
                        <input type="text" class="text" name="qrcode" id="qrcode" onchange="next_process()" placeholder="SCAN QR TRAY - REPAIR" onfocus="this.value = '';" onblur="if (this.value == '') { this.value = ''; }">
                        <script type="text/javascript" >
                            document.getElementById("qrcode").focus();
                        </script>
                    </div><br>    
                </div>                
                <div class="project">
                    <table style="color:white;font-size:10px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Tray</th>
                            <th style="text-align:center;">Model</th>
                            <th style="text-align:center;">Last Used</th>
                            <th style="text-align:center;">Status</th>                            
                        </thead>
                        <tbody>
                            <?php
                            $i = 1; 
                            foreach($result as $data){ ?>
                                <tr>
                                    <td align="center"><?php echo $i; ?></td>
                                    <td align="center"><?php echo $data->CHR_PART_CODE; ?></td>
                                    <td align="center"><?php echo $data->CHR_MODEL; ?></td>
                                    <td align="center"><?php echo substr($data->CHR_CREATED_DATE, 6, 2) . '/' . substr($data->CHR_CREATED_DATE, 4, 2 ) . '/' . substr($data->CHR_CREATED_DATE, 2, 2 ) . ' ' . substr($data->CHR_CREATED_TIME, 0, 2 ) . ':' . substr($data->CHR_CREATED_TIME, 2, 2 ); ?></td>
                                    <td align="center">
                                    <?php
                                    if($data->INT_FLG_REPAIR == 2){
                                        echo "<img src='" . base_url() . "/assets/images/check1.png' width='18'>";
                                    } else if($data->INT_FLG_REPAIR == 1) {
                                        echo "<img src='" . base_url() . "/assets/images/onprogress.png' width='18'>";
                                    } else {
                                        echo "<img src='" . base_url() . "/assets/images/error1.png' width='18'>";
                                    }
                                    ?>
                                    </td>
                                </tr>
                            <?php
                            $i++; 
                            } 
                            ?>
                        </tbody>
                    </table>  
                </div>
                <br>
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

<script type="text/javascript" >
    function next_process() {
        var data = document.getElementById("qrcode").value;
        // var baru = data.replace(/[^\d\s ]/g, "");

        location.href = "<?php echo site_url('Scan_c/process_repair'); ?>/" + data;
    }
</script>