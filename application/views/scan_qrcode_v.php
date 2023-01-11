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
                <!-- <li><a href="<?php echo base_url('index.php/Scan_c'); ?>">P E V I T A</a></li> -->
                <li><a href="<?php echo base_url('index.php/Scan_c/scan_prev') . "/" . "$qr_no"; ?>">S C A N &nbsp; T R A Y &nbsp; O L D</a></li>
                <li><a class="active" href="#">S C A N &nbsp; T R A Y &nbsp; N E W</a></li>
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
                <h3>SCAN QR TRAY - NEW</h3>   
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
                    <input type="hidden" name="qr_no" id="qr_no" class="form-control" value="<?php echo($qr_no); ?>">
                    <input type="hidden" name="qr_new" id="qr_new" class="form-control" value="<?php echo($qr_new); ?>">                     
                    <?php if($match == 'OK'){ ?> 
                    <?php echo form_open('Scan_c/save_preventive/' . $qr_no . '/' . $qr_new, 'class="form-horizontal"'); ?>
                        <div align="center">
                            <input type="text" class="text" name="notes" id="notes" placeholder="NOTES" value="">                        
                        </div><br>
                        <div align="center">
                            <input type="submit" value="C H A N G E &nbsp; T R A Y" class="btn btn-warning">
                        </div><br>
                    <?php echo form_close(); ?>
                    <?php } else { ?>   
                        <div align="center">
                        <input type="text" class="text" name="qrcode" id="qrcode" onchange="next_process()" placeholder="SCAN QR TRAY - NEW" onfocus="this.value = '';" onblur="if (this.value == '') { this.value = ''; }">
                        <script type="text/javascript" >
                            document.getElementById("qrcode").focus();
                        </script>
                    </div><br>  
                    <?php } ?>      
                </div>                
                <div class="project">
                    <table style="color:white;font-size:11px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">Old Tray</th>
                            <th style="text-align:center;">Model</th>
                            <th style="text-align:center;">Last Stroke</th>                            
                        </thead>
                        <tbody>
                            <td align="center"><?php echo $result[0]->CHR_PART_CODE; ?></td>
                            <td align="center"><?php echo $result[0]->CHR_MODEL; ?></td>
                            <td align="center"><?php echo $result[0]->INT_STROKE_BIG_PREVENTIVE; ?></td>
                        </tbody>
                    </table>  
                </div>
                <?php if($match == 'OK'){ ?>
                <div class="project">
                    <table style="color:white;font-size:11px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">New Tray</th>
                            <th style="text-align:center;">Model</th>
                            <th style="text-align:center;">Status</th>                            
                        </thead>
                        <tbody>
                            <td align="center"><?php echo $result[0]->CHR_PART_CODE; ?></td>
                            <td align="center"><?php echo $result[0]->CHR_MODEL; ?></td>
                            <td align="center"><?php echo "<img src='" . base_url() . "/assets/images/check1.png' width='18'>"; ?></td>
                        </tbody>
                    </table>  
                </div>
                <?php } ?>
                <br>
            </div>	
            <div class="clearfix"></div>
        </div>
    </div>

<script type="text/javascript" >
    function next_process() {
        var data = document.getElementById("qrcode").value;
        var data2 = document.getElementById("qr_no").value;

        // var baru = data.replace(/[^\d\s ]/g, "");

        location.href = "<?php echo site_url('Scan_c/scan_new_qr'); ?>/" + data2 + "/" + data;
    }

    function save_preventive() {
        var qr_old = document.getElementById("qr_no").value;
        var qr_new = document.getElementById("qr_new").value;
        location.href = "<?php echo site_url('Scan_c/save_preventive'); ?>/" + qr_old + "/" + qr_new;
    }
</script>