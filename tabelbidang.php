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
if(isset($_GET['delete_key'])){
    $hapus_bidang_divisi = $BidangDivisi->getResult();
    $pengurus->getPengurus();
    while(list($id_pengurus, $nim, $nama, $semester, $id_bidang, $img) = $pengurus->getResult()){
        if($id_bidang == $_GET['delete_key']){
            $pengurus->deletePengurus($id_pengurus);
        }
    }
    $BidangDivisi->deleteBidangDivisi($_GET['delete_key']); 
    header('location: bidang_divisi.php');
}
while(list($id_bidang, $jabatan, $id_divisi) = $BidangDivisi->getResult()){
    $divisi->getWhereDivisi($id_divisi);
    $nama_divisi = $divisi->getResult();
    $data .= "<tr>
    <td>". $no ." </td> 
    <td>". $jabatan."</td>
    <td>". $nama_divisi['nama_divisi']."</td>
    <td><button class='btn btn-dark' name='hapus'><a style='text-decoration: none; color:white;' href='tabelbidang.php?delete_key=$id_bidang'>Delete</a>&nbsp</button>
    <button class='btn btn-success' ><a style='text-decoration: none; color:white;' href='editbidang.php?update_key=$id_bidang'>Update</a></button>
    </tr>";
    $no++;
}
$pengurus->close();
$BidangDivisi->close();
$divisi->close();
$tpl = new Template("templates/tabelbidangdivisi.html");
$tpl->replace("DATA_TABEL", $data);
$tpl->write();