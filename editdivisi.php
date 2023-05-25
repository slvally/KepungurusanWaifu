<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 

include("conf.php");
include("includes/Template.php");
include("includes/DB.php");
include("includes/Divisi.php");
include("includes/BidangDivisi.php");
include("includes/Pengurus.php");

$divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
$divisi->open();
$BidangDivisi = new BidangDivisi($db_host, $db_user, $db_pass, $db_name);
$BidangDivisi->open();
$pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);
$pengurus->open();

$data = null;
$no = 1;
$divisi->getDivisi();
if(isset($_GET['updatekey'])){
    $key = $_GET['updatekey'];
    $divisi->getWhereDivisi($key);
    list($id_bidang, $nama_divisi) = $divisi->getResult();
    if(isset($_POST['submit'])){
        $pdivisi = $_POST['namadivisi'];
        $divisi->updateDivisi($key, $pdivisi);
        header('location: tabeldivisi.php');
    }
}else if(isset($_GET['addkey'])){
    $nama_divisi = null;
    $divisi->getDivisi();
    if(isset($_POST['submit'])){
        $pdivisi = $_POST['namadivisi'];
        $divisi->addDivisi($pdivisi);
        header('location: tabeldivisi.php');
    }
}
$pengurus->close();
$BidangDivisi->close();
$divisi->close();
$tpl = new Template("templates/formdivisi.html");
$tpl->replace("DNamaDivisi", $nama_divisi);
$tpl->write();