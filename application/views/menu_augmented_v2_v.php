<!DOCTYPE html>
<html>
    <head>
        <title>P E V I T A</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <link href="<?php echo base_url('assets/css/bootstrap.css"') ?> rel="stylesheet">
        <link href="<?php echo base_url('assets/css/font-google.css"') ?> rel="stylesheet">
        <link href="<?php echo base_url('assets/css/style.css"') ?> rel="stylesheet">
        
        <link rel="icon" href="<?php echo base_url('assets/images/pevita.png'); ?>" > 

        <!-- <script src="<?php echo base_url('assets/js/aframe.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/aframe-ar.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/aframe-extras.loaders.min.js') ?>"></script> -->
        <script src="https://aframe.io/releases/0.9.2/aframe.min.js"></script>
        <script src="https://raw.githack.com/jeromeetienne/AR.js/master/aframe/build/aframe-ar.min.js"></script>
        <script src="https://raw.githack.com/donmccurdy/aframe-extras/master/dist/aframe-extras.loaders.min.js"></script>
    </head>    
    <body style='margin : 0px; overflow: hidden;'>
            <a-scene embedded vr-mode-ui="enabled: false" arjs="sourceType: webcam; debugUIEnabled: false; detectionMode: mono_and_matrix; matrixCodeType: 3x3;">
                <a-assets>
                    <!-- <a-asset-item id="animated-asset" src="<?php echo base_url('assets/images/CesiumMilkTruck.gltf'); ?>"></a-asset-item> -->
                    <a-asset-item id="animated-asset" src="https://raw.githubusercontent.com/nicolocarpignoli/nicolocarpignoli.github.io/master/ar-playground/models/CesiumMan.gltf"></a-asset-item>
                </a-assets>

                <a-marker type='barcode' value='7'>
                    <a-box position='0 0.5 0' color="yellow"></a-box>
                </a-marker>

                <a-marker id="animated-marker" type='barcode' value='6'>
                    <a-entity
                        animation-mixer
                        gltf-model="#animated-asset"
                        scale="2 2 2">
                    </a-entity>
                </a-marker>

                <a-entity camera></a-entity>        
            </a-scene>
    </body>
</html>