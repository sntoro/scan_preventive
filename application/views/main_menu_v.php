<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />
    
    <div>
        <div class="top-menu">
            <span class="menu"><img src="<?php echo base_url('assets/images/menu.png'); ?>"> </span>
            <ul>
                <li><a class="active" href="#">P E V I T A</a></li>
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
    </br>
    <div style="height:150px;">
        <div class="hire-me" align="center">
            <h3>W E L C O M E &nbsp; <span style="color:#00ff99;"> MR. <?php echo strtoupper($username) . '( ' . $npk . ' )'; ?> </span></h3>     
            <span style="color:white; font-size:16px; font-style:italic;"><?php echo date('l', strtotime(date('Ymd'))) . ', ' . date("d") . ' ' . date('F', strtotime(date('Ymd'))) . ' ' . date("Y") . ' ' . date("H:i:s"); ?></span>       
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="total-info">
        <div style="height:600px;">
            <div class="hire-me">
                <h3>C H O O S E &nbsp; T Y P E</h3>
                <br>
                <div class="project">
                    <div align="center">
                        <input type="button" class="btn btn-warning" value="M O L D" onclick="scan_qr_part('A')"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <input type="button" class="btn btn-warning" value="D I E S &nbsp; S T A M P I N G" onclick="scan_qr_part('B')"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <input type="button" class="btn btn-warning" value="D I E S &nbsp; D O O R F R A M E" onclick="scan_qr_part('C')"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <input type="button" class="btn btn-warning" value="M A C H I N E" onclick="scan_qr_part('D')"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <input type="button" class="btn btn-warning" value="J I G" onclick="scan_qr_part('E')"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <input type="button" class="btn btn-warning" value="E L E C T R O D E" onclick="electrode()"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <?php if($role == 1){ ?>
                        <input type="button" class="btn btn-warning" value="A U G M E N T E D" onclick="augmented()"  style="width: 80%; height: 40px; font-size: 15px; font-weight: bold;">
                        <span>
                        <?php } ?> 
                    </div>
                </div>
            </div>	
            <div class="clearfix"></div>
        </div>
    </div>
    </br>
<!-- </div> -->

<script type="text/javascript">
    function scan_qr_part(type) {
        var type = type;
        location.href = "<?php echo site_url('Scan_c/scan_qr_part'); ?>/" + type;
    }

    function electrode() {
        location.href = "<?php echo site_url('Scan_c/scan_electrode'); ?>/";
    }

    function augmented() {
        location.href = "<?php echo site_url('Scan_c/augmented'); ?>/";
    }
</script>