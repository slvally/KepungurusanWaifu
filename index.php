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
if(isset($_GET['idp'])){
    $pengurus->getWherePengurus($_GET['idp']);
    (list($id_pengurus, $nim, $nama, $semester, $id_bidang, $img) = $pengurus->getResult());
    $BidangDivisi->getWhereBidangDivisi($id_bidang);
    $jabatan = $BidangDivisi->getResult();
    $divisi->getWhereDivisi($jabatan['id_divisi']);
    $iddivisi = $divisi->getResult();
    $data .= "
    <div class='col-xl-4 mb-4'>
        <a href='index.php?idp=". $id_pengurus ."' style='text-decoration: none; color:black; '>
            <div class='border d-flex flex-columns'>
                <img class='card-img-top' src='". $img ."' alt='img' style='width: 200px; height: 200px; object-fit: cover;'>
                <div class='d-flex justify-content-center ps-3 flex-column'>
                    <h4 class=''>". $nama ."</h4>
                    <p class='fst-italic'>".  $jabatan['jabatan'] . " - " .$iddivisi["nama_divisi"] ."</p>
                </div>
            </div>
        </a>
        <button class='btn btn-dark mt-2 me-1' name='hapus' ><a style='text-decoration: none; color:white; ' href='tambahpengurus.php?id_hapus=" . $id_pengurus . "'>Hapus</a></button>
        <button class='btn btn-success mt-2' ><a style='text-decoration: none; color:white; ' href='tambahpengurus.php?id_update=" . $id_pengurus .  "'>Update</a></button>
    </div>";
}else{
    $pengurus->getPengurus();
    while (list($id_pengurus, $nim, $nama, $semester, $id_bidang, $img) = $pengurus->getResult()) {
        $BidangDivisi->getWhereBidangDivisi($id_bidang);
        $jabatan = $BidangDivisi->getResult();
        $divisi->getWhereDivisi($jabatan['id_divisi']);
        $iddivisi = $divisi->getResult();
        $data .= "
        <div class='col-xl-4 mb-4'>
            <a href='index.php?idp=". $id_pengurus ."' ' style='text-decoration: none; color:black;'>
                <div class='border rounded-3 d-flex flex-columns bg-light'>
                    <img class='card-img-top' src='". $img ."' alt='img' style='width: 200px; height: 200px; object-fit: cover;'>
                    <div class='d-flex justify-content-center ps-3 flex-column'>
                        <h4 class=''>". $nama ."</h4>
                        <p class='fst-italic'>".  $jabatan['jabatan'] . " - " .$iddivisi["nama_divisi"] ."</p>
                    </div>
                </div>
            </a>
        </div>";
    }
}

$pengurus->close();
$BidangDivisi->close();
$divisi->close();
$tpl = new Template("templates/index.html");
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
