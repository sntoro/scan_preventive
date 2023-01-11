<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script> -->
    <!-- <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script> -->

    <script src="http://192.168.0.231/scan_preventive_v3/assets/js/aframe-ar.min.js"></script>
    <script src="http://192.168.0.231/scan_preventive_v3/assets/js/aframe-ar.js"></script>
</head>

<body>
    <a-scene>
        <a-marker preset="hiro">
            <a-entity gltf-model="http://192.168.0.231/scan_preventive_v3/assets/ar_objects/CesiumMan.gltf" scale="5 5 5" rotation="0 90 0"></a-entity>
        </a-marker>
        <a-entity camera id="cam">
            <a-cursor></a-cursor>
        </a-entity>
    </a-scene>
</body>

</html>