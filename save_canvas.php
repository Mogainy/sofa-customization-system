<?php

if(isset($_POST['image'])){

    $image = $_POST['image'];

    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $data = base64_decode($image);

    if(!is_dir("uploads/customized_sofas")){
        mkdir("uploads/customized_sofas",0777,true);
    }

    $filename = "sofa_" . time() . "_" . rand(1000,9999) . ".png";

    $filepath = "uploads/customized_sofas/" . $filename;

    file_put_contents($filepath,$data);

    echo $filepath;
}
?>