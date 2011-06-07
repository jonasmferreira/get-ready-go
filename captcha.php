<?php
$path_root_captcha = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_captcha = "{$path_root_captcha}{$DS}";
include "{$path_root_captcha}lib{$DS}captcha{$DS}securimage.php";
$img = new securimage();
$img->show();
