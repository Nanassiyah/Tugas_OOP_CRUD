<?php
ob_start();
require_once('../config/koneksi.php');
require_once('../models/database.php');
include "../models/m_mahasiswa.php";
$connection = new Database ($host, $user, $pass, $database);
$mhs = new Mahasiswa($connection);

$id = $_POST['id'];
$nim = $connection->conn->real_escape_string($_POST['nim']);
$namamhs = $connection->conn->real_escape_string($_POST['namamhs']);
$jk = $connection->conn->real_escape_string($_POST['jk']);
$alamat = $connection->conn->real_escape_string($_POST['alamat']);
$kota = $connection->conn->real_escape_string($_POST['kota']);
$email = $connection->conn->real_escape_string($_POST['email']);

$pict = $_FILES['foto']['name'];
$extensi = explode(".", $_FILES['foto']['name']);
$foto = "mhs-" .round(microtime(true)).".".end($extensi);
$sumber = $_FILES['foto']['tmp_name'];

if($pict == '') {
    $mhs->edit("UPDATE tbl_mhs SET nim = '$nim', namamhs = '$namamhs', jk = '$jk', alamat = '$alamat', kota = '$kota', email = '$email' WHERE id ='$id' ");
    echo "<script>window.location='?page=mahasiswa';</script>";
}else {
    $foto_awal = $mhs->tampil($id)->fetch_object()->foto;
    unlink("../assets/img/mahasiswa/".$foto_awal);

    $upload = move_uploaded_file($sumber, "../assets/img/mahasiswa/".$foto);
    if ($upload) {
        $mhs->edit("UPDATE tbl_mhs SET nim = '$nim', namamhs = '$namamhs', jk = '$jk', alamat = '$alamat', kota = '$kota', email = '$email', foto = '$foto' WHERE id ='$id' ");
        echo "<script>window.location='?page=mahasiswa';</script>";
    
                  
    } else {
        echo "<script>alert('Upload gambar gagal!)</script>";
    }

}

?>