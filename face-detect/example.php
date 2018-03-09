<?php

include "FaceDetector.php";

$face_detect = new Face_Detector('detection.dat');
$face_detect->face_detect('sample-image3.jpg');
$face_detect->toJpeg();

?>
