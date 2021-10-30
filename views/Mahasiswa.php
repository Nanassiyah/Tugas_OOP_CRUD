<?php
include "models/m_mahasiswa.php";

$mhs = new Mahasiswa($connection);

if (@$_GET['act'] == ''){
?>

<div class="row">
          <div class="col-lg-12">
            <h1>Mahasiswa<small> Data Mahasiswa</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="icon-dashboard"></i>Mahasiswa</a></li>
            </ol>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            

          <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>No.</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Email</th>
                        <th>Foto</th>
                        <th>Opsi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = $mhs->tampil();
                    while ($data = $tampil->fetch_object()){
                    ?>
                    <tr>
                      <td align="center"><?php echo $no++."."; ?></td>
                      <td><?php echo $data->nim; ?></td>
                      <td><?php echo $data->namamhs; ?></td>
                      <td><?php echo $data->jk;?></td>
                      <td><?php echo $data->alamat; ?></td>
                      <td><?php echo $data->kota; ?></td>
                      <td><?php echo $data->email; ?></td>
                      <td align="center">
                        <img src="assets/img/mahasiswa/<?php echo $data->foto; ?>" width = "70px">
                      </td>
                      <td align="center">
                        <a id="edit_mhs" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id; ?>"  data-nim="<?php echo $data->nim; ?>"  data-namamhs="<?php echo $data->namamhs; ?>" data-jk="<?php echo $data->jk; ?>" data-alamat="<?php echo $data->alamat; ?>" data-kota="<?php echo $data->kota; ?>" data-email="<?php echo $data->email; ?>" data-foto="<?php echo $data->foto; ?>">
                          <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i>Edit</button></a>
                        <a href="?page=Mahasiswa&act=del&id=<?php echo $data->id;?>" onclick= "return confirm('Yakin Akan Menghapus Data Ini?')">
                          <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>Hapus</button>
                        </a>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
          </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah">Tambah Data</button>

            <div id="tambah" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-tittle">Tambah Data Mahasiswa</h4>
                  </div>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="form-group">
                        <label class="control-label" for="nim">NIM</label>
                        <input type="text" name="nim" class="form-control" id="nim" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="namamhs">Nama</label>
                        <input type="text" name="namamhs" class="form-control" id="namamhs" required>
                      </div>
                      <div>
                      <label class="control-label" for="jk">Jenis Kelamin</label><br>
                      <input type="radio" name="jk"  value="L" > L <br>
                      <input type="radio" name="jk"  value="P" > P
                      
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="kota">Kota</label>
                        <input type="text" name="kota" class="form-control" id="kota" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="email">Email</label>
                        <input type="text" name="email" class="form-control" id="email" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control" id="foto" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="reset" class="btn btn-danger">Reset</button>
                      <input type="submit" class="btn btn-success" name="tambah" valeu="Simpan">
                    </div>
                  </form>
                  <?php
                  if(@$_POST['tambah']) {
                    $nim = $connection->conn->real_escape_string($_POST['nim']);
                    $namamhs = $connection->conn->real_escape_string($_POST['namamhs']);
                    $jk = $connection->conn->real_escape_string($_POST['jk']);
                    $alamat = $connection->conn->real_escape_string($_POST['alamat']);
                    $kota = $connection->conn->real_escape_string($_POST['kota']);
                    $email = $connection->conn->real_escape_string($_POST['email']);

                    $extensi = explode(".", $_FILES['foto']['name']);
                    $foto = "mhs-" .round(microtime(true)).".".end($extensi);
                    $sumber = $_FILES['foto']['tmp_name'];
                    
                    $upload = move_uploaded_file($sumber, "assets/img/mahasiswa/".$foto);
                    if ($upload) {
                      $mhs->tambah($nim, $namamhs, $jk, $alamat, $kota, $email, $foto);
                      header("location: ?page=Mahasiswa");
                  
                    } else {
                      echo "<script>alert('Upload gambar gagal!)</script>";
                    }
                  }
                  ?>
                </div>
              </div>
          </div>

          <div id="edit" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-tittle">Edit Data Mahasiswa</h4>
                  </div>
                  <form id="form"  enctype="multipart/form-data">
                    <div class="modal-body" id="modal-edit">
                      <div class="form-group">
                        <label class="control-label" for="nim">NIM</label>
                        <input type= "hidden" name="id" id="id">
                        <input type="text" name="nim" class="form-control" id="nim" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="namamhs">Nama</label>
                        <input type="text" name="namamhs" class="form-control" id="namamhs" required>
                      </div>
                      <div>
                      <label class="control-label" for="jk">Jenis Kelamin</label><br>
                      <input type="radio" name="jk"  value="L" > L <br>
                      <input type="radio" name="jk"  value="P" > P
                      
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="kota">Kota</label>
                        <input type="text" name="kota" class="form-control" id="kota" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="email">Email</label>
                        <input type="text" name="email" class="form-control" id="email" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="foto">Foto</label>
                        <div style="padding-bottom: 5px">
                          <img src="" width="80px" id="pict">
                        </div>
                        <input type="file" name="foto" class="form-control" id="foto" >
                      </div>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-success" name="edit" valeu="Simpan">
                    </div>
                  </form>
                  
                </div>
              </div>
          </div>
          <script src="assets/sb-admin/js/jquery-1.10.2.js"></script>
          <script type = "text/javascript">
          $(document).on("click", "#edit_mhs", function(){
            var idm = $(this).data('id');
            var nimm = $(this).data('nim');
            var namamhsm = $(this).data('namamhs');
            var jkm = $(this).data('jk');
            var alamatm = $(this).data('alamat');
            var kotam = $(this).data('kota');
            var emailm = $(this).data('email');
            var fotom = $(this).data('foto');
            $("#modal-edit #id").val(idm);
            $("#modal-edit #nim").val(nimm);
            $("#modal-edit #nim").val(nimm);
            $("#modal-edit #namamhs").val(namamhsm);
            $("#modal-edit #jk").val(jkm);
            $("#modal-edit #alamat").val(alamatm);
            $("#modal-edit #kota").val(kotam);
            $("#modal-edit #email").val(emailm);
            $("#modal-edit #pict").attr("src", "assets/img/mahasiswa/"+fotom);
          })

          $(document).ready(function(e) {
            $("#form").on("submit", (function(e){
              e.preventDefault();
              $.ajax({
                url : 'models/proses_edit.php',
                type : 'POST',
                data : new FormData(this),
                contentType : false,
                cache : false,
                processData : false,
                success : function(msg) {
                  $('.table').html(msg);
                }
              });
            }));
          })
          </script>
        </div>
 </div> 
 
<?php
} else if (@$_GET['act'] == 'del') {
  $foto_awal = $mhs->tampil($_GET['id'])->fetch_object()->foto;
  unlink("assets/img/mahasiswa/".$foto_awal);

  $mhs->hapus($_GET['id']);
  header("location: ?page=Mahasiswa");
}             