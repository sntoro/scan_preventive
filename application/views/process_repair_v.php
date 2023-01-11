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
                <li><a href="<?php echo base_url('index.php/Scan_c/scan_repair'); ?>">S C A N &nbsp; R E P A I R</a></li>
                <li><a class="active" href="#">R E P A I R</a></li>
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
                <h3>START / FINISH REPAIR</h3>   
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
                    <?php if($qr_no != '' && $status == '0'){ ?>
                    <div align="center">                        
                            <input class="btn btn-info" type="button" value="S T A R T &nbsp; R E P A I R" onclick="start_repair()">
                    </div>
                    <?php } else if($qr_no != '' && $status == '1'){ ?>
                    <?php echo form_open('Scan_c/finish_repair/' . $qr_no, 'class="form-horizontal"'); ?>
                    <div align="center">
                            <input type="text" class="text" name="notes" id="notes" placeholder="NOTES" value="">
                    </div>
                    <br>
                    <div align="center">
                            <!-- <input class="btn btn-warning" type="button" value="F I N I S H &nbsp; R E P A I R" onclick="finish_repair()"> -->
                            <input class="btn btn-warning" type="submit" value="F I N I S H &nbsp; R E P A I R">                             
                    </div>
                    <?php echo form_close(); ?>                           
                    <?php } ?>
                    <br>    
                </div>                
                <div class="project">
                    <table style="color:white;font-size:11px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">Tray</th>
                            <th style="text-align:center;">Model</th>
                            <th style="text-align:center;">Status</th>                           
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center"><?php echo $result->CHR_PART_CODE; ?></td>
                                <td align="center"><?php echo $result->CHR_MODEL; ?></td>
                                <td align="center">
                                <?php
                                    if($result->INT_FLG_REPAIR == 2){
                                        echo "<img src='" . base_url() . "/assets/images/check1.png' width='18'>";
                                    } else if($result->INT_FLG_REPAIR == 1) {
                                        echo "<img src='" . base_url() . "/assets/images/onprogress.png' width='18'>";
                                    } else {
                                        echo "<img src='" . base_url() . "/assets/images/error1.png' width='18'>";
                                    }
                                ?>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                    <table style="color:white;font-size:11px;" class="table table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <th style="text-align:center;">Start</th>
                            <th style="text-align:center;">&nbsp;</th>
                            <th style="text-align:center;">Finish</th>                           
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center"><?php if($result->CHR_START_REPAIR_DATE == NULL){ echo '-'; } else { echo substr($result->CHR_START_REPAIR_DATE, 6, 2) . '/' . substr($result->CHR_START_REPAIR_DATE, 4, 2 ) . '/' . substr($result->CHR_START_REPAIR_DATE, 2, 2 ) . ' ' . substr($result->CHR_START_REPAIR_TIME, 0, 2 ) . ':' . substr($result->CHR_START_REPAIR_TIME, 2, 2 ); } ?></td>
                                <td align="center">&nbsp;</td>
                                <td align="center"><?php if($result->CHR_FINISH_REPAIR_DATE == NULL){ echo '-'; } else { echo substr($result->CHR_FINISH_REPAIR_DATE, 6, 2) . '/' . substr($result->CHR_FINISH_REPAIR_DATE, 4, 2 ) . '/' . substr($result->CHR_FINISH_REPAIR_DATE, 2, 2 ) . ' ' . substr($result->CHR_FINISH_REPAIR_TIME, 0, 2 ) . ':' . substr($result->CHR_FINISH_REPAIR_TIME, 2, 2 ); } ?></td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
                <br>
            </div>	
            <div class="clearfix"></div>
        </div>
    </div>

<script type="text/javascript" >
    function start_repair() {
        var qr_no = "<?php echo $qr_no; ?>";
        location.href = "<?php echo site_url('Scan_c/start_repair'); ?>/" + qr_no;
    }

    // function finish_repair() {
    //     var qr_no = "<?php echo $qr_no; ?>";
    //     location.href = "<?php echo site_url('Scan_c/finish_repair'); ?>/" + qr_no;
    // }
</script>