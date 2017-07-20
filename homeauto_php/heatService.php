<?php
$sicaklikLog = file_get_contents("http://188.3.100.39:5000/heatforSave");
header('Content-Type: application/json');
echo $sicaklikLog;
?>
