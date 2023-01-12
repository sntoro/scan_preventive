<meta content='width=device-width; minimum-scale=1 initial-scale=1; maximum-scale=1; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

<?php
$type = '';
if ($id_type == 'A') {
    $type = 'M O L D';
} else if ($id_type == 'B') {
    $type = 'D I E S   S T P';
} else if ($id_type == 'C') {
    $type = 'D I E S   D F';
} else if ($id_type == 'D') {
    $type = 'M A C H I N E';
} else if ($id_type == 'E') {
    $type = 'J I G';
}

?>

<div>
    <div class="top-menu">
        <span class="menu"><img src="<?php echo base_url('assets/images/menu.png'); ?>"> </span>
        <ul>
            <li><a href="<?php echo base_url('index.php/Scan_c'); ?>">P E V I T A</a></li>
            <li><a class="active" href="#"><?php echo $type; ?></a></li>
            <li><a href="<?php echo base_url('index.php/login_c'); ?>" onclick="return confirm('Are you sure want to LOGOUT?');">L O G O U T</a></li>
            <div class="clearfix"></div>
        </ul>
    </div>
    <!--script for menu-->
    <script>
        $("span.menu").click(function() {
            $(".top-menu ul").slideToggle(500, function() {});
        });
    </script>
    <!--script for menu-->
</div>
<div class="clearfix"></div>

<div class="total-info">
    <div style="height:220px;">
        <div class="hire-me">
            <h3>S C A N &nbsp; Q R &nbsp; <?php echo $type; ?></h3>
            <br>
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
                <div align="center">
                    <input type="hidden" id="id_type" class="text" value="<?php echo $id_type; ?>">
                    <input type="text" class="text" name="qrcode" id="qrcode" onchange="next_process()" placeholder="S C A N &nbsp; Q R &nbsp; <?php echo $type; ?>" onfocus="this.value = '';" onblur="if (this.value == '') { this.value = ''; }">
                    <script type="text/javascript">
                        document.getElementById("qrcode").focus();
                    </script>
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
    function next_process() {
        var data = document.getElementById("qrcode").value;
        var id_type = document.getElementById("id_type").value;
        var data = data.replace("/", "--");

        location.href = "<?php echo site_url('Scan_c/detail_menu'); ?>/" + data + "/" + id_type;
    }
</script>