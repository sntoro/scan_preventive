<html>
    <head>
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    </head>
    <script src="<?php echo base_url('assets/js/aframe.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/aframe-ar.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/aframe-extras.loaders.min.js') ?>"></script>

    <body style='margin : 0px; overflow: hidden;'>
        <a-scene embedded vr-mode-ui="enabled: false" arjs="sourceType: webcam; debugUIEnabled: false; detectionMode: mono_and_matrix; matrixCodeType: 3x3;">

        <a-assets>
            <!-- <a-asset-item id="animated-asset" src="<?php echo base_url('assets/ar_objects/CesiumMan.gltf'); ?>" crossorigin="anonymous"></a-asset-item> -->
            <a-image src="<?php echo base_url('assets/images/check1.png'); ?>"></a-image>
            <!-- <img id="img" src="<?php echo base_url('assets/images/check1.png'); ?>"> -->
        </a-assets>

        <a-marker id="animated-marker" type='hiro' value='6'>
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