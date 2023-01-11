<!DOCTYPE html>
<html>
    <head>
        <title>P E V I T A</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <link rel="icon" href="<?php echo base_url('assets/images/pevita.png'); ?>" > 

        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </head>    
    
    <body data-baseurl="<?php echo base_url(); ?>">        
        <div class="container">
            <?php $this->load->view($content); ?>
        </div>
        &nbsp;
        
        <div class="footer">
        </div>
    </body>
</html>