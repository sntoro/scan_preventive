<meta content='width=device-width; minimum-scale=1 initial-scale=1.0; maximum-scale=1.0; user-scalable=no;' name='viewport' />
<meta name="viewport" content="width=device-width" />

<div onclick="fokus()">
    <div>
        <div class="logo">    
            <h1>
                <img src="<?php echo base_url('/assets/images/logo-aisin5.png') ?>" width="200"></br>
                <span style="color:white; font-size:13px; font-weight:bold; letter-spacing:3px;">PT AISIN INDONESIA</span>
            </h1>       
            <a href="<?php echo base_url('index.php/Login_c'); ?>">                
                <h1>
                P E V I T A
                </br>
                <span style="font-size:14px; letter-spacing:3px;">PREVENTIVE MAINTENANCE APPLICATION</span>
                </h1>
                <!-- <h4 style="color:white; align:center;">PREVENTIVE MAINTENANCE APPLICATION</h4> -->
            </a>            
        </div>
    </div>
    <div class="clearfix"></div>

    <div onclick="fokus()">
        <div class="clearfix"></div>
        <div class="hire-me">
            <h3>L O G &nbsp; I N</h3>
            <div class="project">
                <div class="your-top">
                    <input class="form-control" name="CHR_NPK" id="CHR_NPK" type="text" placeholder="NPK" autocomplete=off onchange="scan_npk()" required="true" autofocus="autofocus">

                    <script type="text/javascript" >
                        document.getElementById("CHR_NPK").focus();
                    </script>
                    <?php if($error == 'ERR'){ ?>
                    <div>
                        <span></span>
                        <textarea readonly id="error-regis" style="height: 50px; background: #ff3333; color:#ffffff;">NPK TIDAK TERDAFTAR</textarea>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>


<script type="text/javascript">
    function fokus() {
        document.getElementById("CHR_NPK").focus();
        // document.body.requestFullscreen();
    } 
    
    function scan_npk() {
        var npk = document.getElementById("CHR_NPK").value;
        // var npk = npk.replace(/\D/g, '');

        if (npk == '') {
            location.href = "<?php echo site_url('Login_c/'); ?>/" + npk;
        } else {
            location.href = "<?php echo site_url('Login_c/try_login/'); ?>/" + npk;
        }
    }
</script>

