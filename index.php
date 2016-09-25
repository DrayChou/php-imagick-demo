<?php

$file = "test.psd";

$im = new \Imagick(realpath($file) . "[0]");
$im->setImageAlphaChannel(11);
$im->mergeImageLayers(imagick::LAYERMETHOD_FLATTEN);
$im->setImageFormat('jpg');
// header("Content-Type: image/jpg");
// echo $im->getImageBlob();
echo '<img src="data:image/jpg;base64,' . base64_encode($im->getImageBlob()) . '" alt="" />';

// header("Content-Type: image/jpg");
$im = new \Imagick(realpath($file));
//$im->setImageAlphaChannel(11);
//$im->mergeImageLayers(imagick::LAYERMETHOD_FLATTEN);
$num_layers = $im->getNumberImages();
var_dump($num_layers);
for ($i = 0; $i < $num_layers; ++$i) {
    // $im->setImageIndex($i);
    $im->setIteratorIndex($i);

    $pagedata = $im->getImagePage();
    print("x,y: " + $pagedata["x"] . ", " . $pagedata["y"] . "<br/>\n");
    print("w,h: " + $pagedata["width"] . ", " . $pagedata["height"] . "<br/>\n");

    foreach ($im->getImageProperties("*") as $k => $v) {
        print("$k: $v<br/>\n");
    }

//    $im->writeImage('layer' . $i . '.png');
//    echo $im->getImageBlob();

    $width = $height = 200;
    if ($pagedata["width"] > $pagedata["height"]) {
        $height *= ($pagedata["height"] / $pagedata["width"]);
    } else {
        $width *= ($pagedata["width"] / $pagedata["height"]);
    }

    $im->setImageFormat("jpg");
    $im->resizeImage($width, $height, 1, 0);
    echo '<img src="data:image/jpg;base64,' . base64_encode($im->getImageBlob()) . '" alt="" />';
    echo '<br/>';
}
