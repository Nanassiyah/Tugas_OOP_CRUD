<?php
class Mahasiswa {

    private $mysqli;

    function __construct($conn) {
        $this->mysqli = $conn;
    }
    public function tampil ($id = null) {
        $db = $this->mysqli->conn;
        $sql = "SELECT * FROM tbl_mhs";
        if ($id != null) {
            $sql .= " WHERE id = $id";
        }
        $query = $db->query($sql) or die ($db->error);
        return $query;
    }

    public function tambah($nim, $namamhs, $jk, $alamat, $kota, $email, $foto) {
        $db = $this->mysqli->conn;
        $db->query("INSERT INTO tbl_mhs VALUES ('', '$nim', '$namamhs', '$jk', '$alamat', '$kota', '$email', '$foto' )") or die ($db->error);


    }

    public function edit($sql) {
        $db = $this->mysqli->conn;
        $db->query($sql) or die ($db->error);
    }

    public function hapus($id) {
        $db = $this->mysqli->conn;
        $db->query("DELETE FROM tbl_mhs WHERE id= '$id' ") or die ($db->error);
    }

    function __destruct() {
        $db = $this->mysqli->conn;
        $db->close();
    }
}
?>