<!DOCTYPE html>
<html>
<head>
  <title>Form Mahasiswa</title>
  <style>
    table {
      border-collapse: collapse;
      width: 50%;
    }

    th, tr, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }

    #form td, 
    #form tr {
        border: none;
    }

    td > input[type="text"],
    td > textarea {
        width: 100%;
        box-sizing: border-box;
    }
    
  </style>
</head>
<body>
  <h1>Form Mahasiswa</h1>
  <!-- <pre><?php //print_r($mahasiswa); ?> </pre>
  <pre><?php //print_r($krs); ?> </pre> -->
  <form enctype="multipart/form-data" method="post" action="/krs/edit/<?= $mahasiswa['id']?>">
    <table id="form">
        <tbody>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td> <input required type="text" id="nama" name="nama" value="<?= $mahasiswa['nama']; ?>"</td>
          </tr>
          <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td> <input required <?= $mahasiswa['jenis_kelamin'] == 'laki-laki' ? "checked" : ""; ?> type="radio" id="laki-laki" name="jenisKelamin" value="laki-laki">
                <label for="laki-laki">Laki-Laki</label>
                <input required <?= $mahasiswa['jenis_kelamin'] == 'perempuan' ? "checked" : ""; ?> type="radio" id="perempuan" name="jenisKelamin" value="perempuan">
                <label for="laki-laki">Perempuan</label>
            </td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>
                <textarea  name="alamat"><?= $mahasiswa['alamat']; ?></textarea>
            </td>
          </tr>
        </tbody>
      </table><br>
   
    <table id="matkul">
      <thead>
        <tr>
          <th>No</th>
          <th>Mata Kuliah</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="mataKuliahBody">
        <tr>
          <td>1</td>
          <td><input type="text" name="mataKuliah[]"></td>
          <td>
            <button type="button" onclick="tambahMataKuliah(); return false;">Tambah</button>
            <button type="button" onclick="hapusMataKuliah(this)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table><br>

    <label for="krs">Upload File KRS:</label><br><br>
    <input type="file" id="krs" name="file"><br><br>
    <?php 
      if($mahasiswa['image']){
        echo '<img width="200px" height="200px" src=' . base_url().'assets/images/' . $mahasiswa['image'] . '>';
      }
    ?>
    <br>
    <button type="submit">Simpan</button>
  </form>

  <script>
    let dataMataKuliah = <?php echo $krs ?>;
    function showMataKuliah() {
      var table = document.getElementById('mataKuliahBody');
      table.innerHTML = '';

      for (var i = 0; i < dataMataKuliah.length; i++) {
        var row = table.insertRow(i);

        var cellNo = row.insertCell(0);
        var cellMataKuliah = row.insertCell(1);
        var cellAksi = row.insertCell(2);

        cellNo.innerHTML = i + 1;
        cellNo.className = "center-text";
        cellMataKuliah.innerHTML = `<input value="${dataMataKuliah[i].nama_matkul}"type="text" name="mataKuliah[]">`;
        cellAksi.innerHTML = '<button onclick="tambahMataKuliah()">Tambah</button> ' +
                             '<button type="button" onclick="hapusMataKuliah(this)">Hapus</button>';
      }
    }

    function tambahMataKuliah() {
      event.preventDefault();
      var table = document.getElementById("mataKuliahBody");
      var rowCount = table.rows.length;
      var row = table.insertRow(rowCount);
      var noCell = row.insertCell(0);
      var mataKuliahCell = row.insertCell(1);
      var aksiCell = row.insertCell(2);

      noCell.innerHTML = rowCount+1;
      mataKuliahCell.innerHTML = '<input type="text" name="mataKuliah[]">';
      aksiCell.innerHTML = '<button type="button" onclick="tambahMataKuliah()">Tambah</button> <button type="button" onclick="hapusMataKuliah(this)">Hapus</button>';
    }

    function hapusMataKuliah(button) {
      var row = button.parentNode.parentNode;
      
      var table = row.parentNode;
      table.removeChild(row);

      // Update nomor urut
      var rows = table.getElementsByTagName("tr");
      for (var i = 0; i < rows.length; i++) {
        rows[i].getElementsByTagName("td")[0].innerHTML = i + 1;
      }
    }

    showMataKuliah();
  </script>
</body>
</html>
