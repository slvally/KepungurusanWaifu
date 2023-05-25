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
if(isset($_GET['keydiv'])){
    $hapus_divisi = $divisi->getResult();
    $BidangDivisi->getBidangDivisi();
    while(list($id_bidang, $jabatan, $id_nextdiv) = $BidangDivisi->getResult()){
        if($id_nextdiv == $_GET['keydiv']){
            $pengurus->getPengurus();
            while(list($id_pengurus, $nim, $nama, $semester, $id_nextbid, $img) = $pengurus->getResult()){
                if($id_bidang == $id_nextbid){
                    $pengurus->deletePengurus($id_pengurus);
                }
            }
            $BidangDivisi->deleteBidangDivisi($id_bidang);
        }
    }
    $divisi->deleteDivisi($_GET['keydiv']);
    header('location: tabeldivisi.php');
}
while(list($id_divisi, $nama_divisi) = $divisi->getResult()){
    $data .= "<tr>
    <td>". $no ." </td> 
    <td>". $nama_divisi."</td>
    <td><button class='btn btn-dark' name='hapus'><a style='text-decoration: none; color:white;' href='tabeldivisi.php?keydiv=$id_divisi'>Delete</a>&nbsp</button>
    <button class='btn btn-success' ><a style='text-decoration: none; color:white;' href='editdivisi.php?updatekey=$id_divisi'>Update</a></button></td>
    </tr>";
    $no++;
}

$pengurus->close();
$BidangDivisi->close();
$divisi->close();
$tpl = new Template("templates/tabeldivisi.html");
$tpl->replace("DATA_TABEL", $data);
$tpl->write();