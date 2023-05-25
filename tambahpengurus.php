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
$tpl = new Template("templates/tambahpengurus.html");
if(isset($_GET['id_hapus'])){
    $pengurus->deletePengurus($_GET['id_hapus']);
    header('location: index.php');
}
if(isset($_GET['id_update'])){
    $key = $_GET['id_update'];
    $pengurus->getWherePengurus($_GET['id_update']);
    list($id_pengurus, $nim, $nama, $semester, $id_bidang, $img) = $pengurus->getResult();
    $BidangDivisi->getBidangDivisi();
    while(list($id_nextbidang, $jabatan, $id_divisi) = $BidangDivisi->getResult()){
        $divisi->getWhereDivisi($id_divisi);
        $namadivisi = $divisi->getResult();
        $data .= "<option value='".$id_nextbidang."'"; 
        if($id_bidang == $id_nextbidang){
            $data .= " selected='selected'";
        }
        $data .= ">" . $jabatan. " ". $namadivisi['nama_divisi'] . "</option>";
    }
    if(isset($_POST['submit'])){
        $pnim = $_POST['nim'];
        $pnama = $_POST['nama'];
        $psem = $_POST['semester'];
        $pidbid = $_POST['jabatan_divisi'];
        $img = $_FILES['source']['name']; 
        $tmp = $_FILES['source']['tmp_name'];
        $imgPost = "source/default.jpg";
        $path = "source/".$img;
        if(move_uploaded_file($tmp, $path)){
            $pengurus->updatePengurus($pnim, $pnama, $psem, $pidbid, $path, $key);
        }else{
            $pengurus->updatePengurus($pnim, $pnama, $psem, $pidbid, $imgPost, $key);
        }
        header('location: index.php');
    }
}
if(isset($_GET['id_submit'])){
    $nim = null;
    $nama = null;
    $semester = null;
    $BidangDivisi->getBidangDivisi();
    while(list($id_nextbidang, $jabatan, $id_divisi) = $BidangDivisi->getResult()){
        $divisi->getWhereDivisi($id_divisi);
        $namadivisi = $divisi->getResult();
        $data .= "<option value='".$id_nextbidang."'"; 
        $data .= ">" . $jabatan. " ". $namadivisi['nama_divisi'] ."</option>";
    }
    if(isset($_POST['submit'])){
        $pnim = $_POST['nim'];
        $pnama = $_POST['nama'];
        $psem = $_POST['semester'];
        $pidbid = $_POST['jabatan_divisi'];
        $img = $_FILES['source']['name']; 
        $tmp = $_FILES['source']['tmp_name'];
        $imgPost = "source/default.jpg";
        $path = "source/".$img;
        if(move_uploaded_file($tmp, $path)){
            $pengurus->addPengurus($pnim, $pnama, $psem, $pidbid, $path);
        }else{
            $pengurus->addPengurus($pnim, $pnama, $psem, $pidbid, $imgPost);
        }
        header('location: index.php');
    }
}
$pengurus->close();
$BidangDivisi->close();
$divisi->close();
$tpl->replace("DNIM", $nim);
$tpl->replace("DNama", $nama);
$tpl->replace("DSemester", $semester);
$tpl->replace("DATA_Jabatan", $data);
$tpl->write();