<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

<!-- <div class="container"> -->
    <div>
        <!-- <div class="logo">
            <a href="<?php echo base_url('index.php/Login_c'); ?>"><h1>R E N I T A</h1></a>
        </div> -->
        <div class="top-menu">
            <span class="menu"><img src="<?php echo base_url('assets/images/menu.png'); ?>"> </span>
            <ul>
                <li><a href="<?php echo base_url('index.php/Scan_c'); ?>">P E V I T A</a></li>
                <li><a class="active" href="#">S C A N &nbsp; T R A Y &nbsp; O L D</a></li>
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

    <div class="total-info" onclick="fokus()">
        <div style="height:200px;">
            <div class="hire-me">
                <h3>SCAN QR TRAY - OLD</h3>
                <div align="center" style="width:300;">
                    <?php if (isset($error)) { ?>
                        <span style="color:#ff3333;"><strong>ERROR</strong></span>
                        <div readonly style="background: #ff3333; color:#ffffff;"><?php echo $error; ?></div>
                    <?php } ?>
                    <?php if (isset($success)) { ?>
                        <span style="color:#66ff66;"><strong>SUCCESS</strong></span>
                        <div readonly style="background: #66ff66; color:#000000;"><?php echo $success; ?></div>
                    <?php } ?>
                </div>
                <div class="project">
                    <div>
                        <span></span>
                        <input type="text" class="text" name="qr_no" id="qr_no" onchange="next_process()" placeholder="SCAN QR TRAY - OLD" autofocus="autofocus" onfocus="this.value = '';" onblur="if (this.value == '') {
                                    this.value = '';
                                }">
                        <script type="text/javascript" >
                            document.getElementById("qr_no").focus();
                        </script>
                    </div>                    
                </div>
            </div>	
            <div class="clearfix"></div>
        </div>
    </div>
    </br>
<!-- </div> -->

<script type="text/javascript" >
    function next_process() {
        var data = document.getElementById("qr_no").value;
        // var baru = data.replace(/\D/g, '');

        if (data == '') {
            location.href = "<?php echo site_url('Scan_c'); ?>/";
        } else {
            location.href = "<?php echo site_url('Scan_c/scan_prev/'); ?>/" + data;
        }

    }

    function fokus() {
        document.getElementById("qr_no").focus();
    }
</script>