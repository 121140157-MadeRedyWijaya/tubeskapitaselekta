<!DOCTYPE html>
<html lang="en">
<head>
  <title>Form Pendataan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .form-control {
      width: 200px;
      padding: 10px 20px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-group {
      margin-bottom: 10px;
    }

    .btn {
      background-color: #00FF00;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .form-group-right {
      float: right;
    }
  </style>
</head>
<body>
  <header>
    <h1>Form Pendataan</h1>
  </header>
  <main>
    <form action="proses-data.php" method="post">
      <div class="form-group">
        <label for="nik">NIK</label>
        <input type="text" class="form-control" id="nik" name="nik" style="float: left;">
      </div>
      <div class="form-group form-group-right">
        <label for="upload-bukti-kk">Upload Bukti KK</label>
        <input type="file" class="form-control" id="upload-bukti-kk" name="upload-bukti-kk">
      </div>
      <div class="form-group">
        <label for="nama-lengkap">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama-lengkap" name="nama-lengkap" style="float: left;">
      </div>
      <div class="form-group form-group-right">
        <label for="upload-bukti-ktp">Upload Bukti KTP</label>
        <input type="file" class="form-control" id="upload-bukti-ktp" name="upload-bukti-ktp">
      </div>
      <div class="form-group">
        <label for="tanggal-lahir">Tanggal Lahir</label>
        <input type="date" class="form-control" id="tanggal-lahir" name="tanggal-lahir" style="float: left;">
      </div>
      <div class="form-group form-group-right">
        <label for="jenis-kelamin">Jenis Kelamin</label>
        <input type="radio" class="form-control" id="jenis-kelamin-laki-laki" name="jenis-kelamin" value="laki-laki" style="float: left;">
        <label for="jenis-kelamin-laki-laki">Laki-laki</label>
        <input type="radio" class="form-control" id="jenis-kelamin-perempuan" name="jenis-kelamin" value="perempuan" style="float: left;">
        <label for="jenis-kelamin-perempuan">Perempuan</label>
      </div>
      <div class="form-group">
        <label for="agama">Agama</label>
        <select class="form-control" id="agama" name="agama" style="float: left;">
          <option value="Islam">Islam</option>
          <option value="Kristen">Kristen</option>
          <option value="Hindu">Hindu</option>
          <option value="Buddha">Buddha</option>
          <option value="Konghucu">Konghucu</option>
        </select>
      </div>
      <div class="form-group form-group-right">
        <label for="pekerjaan">Pekerjaan</label>
        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"  style="float: left;">
        </div>
    <div class="form-group">
      <label for="alamat-tinggal">Alamat Tinggal</label>
      <input type="text" class="form-control" id="alamat-tinggal" name="alamat-tinggal" style="float: left;">
    </div>
    <div class="form-group form-group-right">
      <label for="alamat-ktp">Alamat KTP</label>
      <input type="text" class="form-control" id="alamat-ktp" name="alamat-ktp" style="float: left;">
    </div>
    <div class="form-group">
      <button type="submit" class="btn">Submit</button>
    </div>
  </form>
</main>
<footer>
    <p>Copyright &copy; 2023</p>
  </footer>
</body>
</html>