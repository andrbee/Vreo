<?php
$uploaddir = '/tmp/';
$uploads_dir = '/uploads';
print_r($_FILES['userfile']['tmp_name']);
foreach ($_FILES['userfile']['tmp_name'] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['userfile']['tmp_name'][$key];
        // basename() может предотвратить атаку на файловую систему;
        // может быть целесообразным дополнительно проверить имя файла
        $name = basename($_FILES['userfile']['tmp_name'][$key]);
        move_uploaded_file($tmp_name, "$uploads_dir/$name");
    }
}
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir .
  $_FILES['userfile']['name'])) {
  print "File is valid, and was successfully uploaded.";
} else {
  print "There some errors!";
}
