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
$BidangDivisi->getBidangDivisi();
if(isset($_GET['update_key'])){
    $key = $_GET['update_key'];
    $BidangDivisi->getWhereBidangDivisi($key);
    list($id_bidang, $jabatan, $id_divisi) = $BidangDivisi->getResult();
    $divisi->getDivisi();
    while(list($id_nextdiv, $nama_divisi) = $divisi->getResult()){
        $data .= "<option value='".$id_nextdiv."'"; 
        if($id_divisi == $id_nextdiv){
            $data .= " selected='selected'";
        }
        $data .= ">". $nama_divisi. "</option>";
    }
    if(isset($_POST['submit'])){
        
        $jabatan_post = $_POST['jabatan'];
        $id_divisi_post = $_POST['id_divisi'];
        $BidangDivisi->updateBidangDivisi($key, $jabatan_post, $id_divisi_post);
        header('location: tabelbidang.php');
    }
}else if(isset($_GET['addbid'])){
    $jabatan = null;
    $divisi->getDivisi();
    while(list($id_nextdiv, $nama_divisi) = $divisi->getResult()){
        $data .= "<option value='".$id_nextdiv."'"; 
        $data .= ">". $nama_divisi. "</option>";
    }
    if(isset($_POST['submit'])){
        
        $jabatan_post = $_POST['jabatan'];
        $id_divisi_post = $_POST['id_divisi'];
        $BidangDivisi->addBidangDivisi($jabatan_post, $id_divisi_post);
        header('location: tabelbidang.php');
    }
}
$pengurus->close();
$BidangDivisi->close();
$divisi->close();
$tpl = new Template("templates/formbidangdivisi.html");
$tpl->replace("DJabatan", $jabatan);
$tpl->replace("DATA_Divisi", $data);
$tpl->write();