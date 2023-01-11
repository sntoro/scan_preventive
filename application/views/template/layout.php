<!DOCTYPE html>
<html>

<head>
    <title>P E V I T A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="<?php echo base_url('assets/css/bootstrap.css') ?>" rel="stylesheet">
    <!-- <link href="<?php echo base_url('assets/css/font-google.css') ?>" rel="stylesheet"> -->
    <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">

    <link rel="icon" href="<?php echo base_url('assets/images/pevita.png'); ?>">

    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-datatables/css/dataTables.bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.tableTools.css'); ?>">
</head>
<!-- <body data-baseurl="<?php echo base_url(); ?>" onload="toggleFullScreen()"> -->

<body data-baseurl="<?php echo base_url(); ?>">
    <script src="<?php echo base_url('assets/plugins/jquery-datatables/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-datatables/js/dataTables.bootstrap.js') ?>"></script>

    <script src="<?php echo base_url('assets/js/datatables.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.tableTools.js'); ?>"></script>

    <!-- <button id="full-screen">FULL SCREEN</button> -->
    <div class="container">
        <?php
        if ($content != 'login_v') {
            echo '<div style="padding-top:0px; padding-bottom:25px;"><img src="' . base_url('/assets/images/logo-aisin5.png') . '" width="130"></br>';
            echo '<span style="color:white; font-size:11px; font-weight:bold; letter-spacing:1px;">PT AISIN INDONESIA</span>';
            echo '</div>';
        }
        ?>
        <?php $this->load->view($content); ?>
    </div>
    &nbsp;
    <div class="footer">
        <div class="copy-rights text-center">
            <p><a href="#" target="target_blank">2020 &copy; PEVITA Ver. 3 </br> PT Aisin Indonesia</a></p>
        </div>
    </div>
</body>
<!-- <button id="goFS" hidden>Go fullscreen</button> -->
<script type="text/javascript">
    // var goFS = document.getElementById("goFS");
    // goFS.addEventListener("click", function() {
    //     document.body.requestFullscreen();
    // }, false);
</script>

</html>