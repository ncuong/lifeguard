<?php
/**
 * Created by PhpStorm.
 * User: VIETBINH
 * Date: 10/3/15
 * Time: 11:30 AM
 */
$resurl = mail('vietbinh.dn@gmail.com','Subject of the e-mail','This is the body of the e-mail!');
    if($resurl){
        echo "Thanh cong";
    }else{
        echo "That bai";
    }
?>