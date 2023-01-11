<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

    <div>
        <div class="top-menu">
            <span class="menu"><img src="<?php echo base_url('assets/images/menu.png'); ?>"> </span>
            <ul>
                <li><a href="<?php echo base_url('index.php/Scan_c'); ?>">P E V I T A</a></li>
                <li><a class="active" href="#">E L E C T R O D E</a></li>
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
        <div style="height:270px;">
            <div class="hire-me">
                <h3>C H O O S E &nbsp; A C T I V I T Y</h3>
                <br>
                <div class="project">
                    <div align="center">
                        <input type="button" class="btn btn-info" value="R E P A I R" onclick="repair()"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <input type="button" class="btn btn-warning" value="C H A N G E &nbsp; T R A Y" onclick="preventive()" style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">                        
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
    function repair() {
        location.href = "<?php echo site_url('Scan_c/scan_repair'); ?>/";
    }

    function preventive() {
        location.href = "<?php echo site_url('Scan_c/scan_qr'); ?>/";
    }
</script>