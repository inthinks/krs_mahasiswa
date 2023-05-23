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
    span {
      color: red;
    }
    
  </style>
</head>
<body>
  <h1>Form Mahasiswa</h1>
  <form enctype="multipart/form-data" method="post" action="/krs/create">
    <table id="form">
        <tbody>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td> <input required type="text" id="nama" name="nama"></td>
          </tr>
          <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td> <input required type="radio" id="laki-laki" name="jenisKelamin" value="laki-laki">
                <label for="laki-laki">Laki-Laki</label>
                <input required type="radio" id="perempuan" name="jenisKelamin" value="perempuan">
                <label for="laki-laki">Perempuan</label>
            </td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>
                <textarea required name="alamat"></textarea>
            </td>
          </tr>
        </tbody>
      </table><br>
      <span><?php echo isset($validation) ? $validation->listErrors() : '' ?></span>
   
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
            <button type="button" onclick="tambahMataKuliah()">Tambah</button>
            <button type="button" onclick="hapusMataKuliah(this)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table><br>

    <label for="krs">Upload File KRS:</label><br>
    <input type="file" id="krs" name="file"><br><br>

    <button type="submit">Simpan</button>
  </form>

  <script>
    function tambahMataKuliah() {
      var table = document.getElementById("mataKuliahBody");
      var rowCount = table.rows.length;
      var row = table.insertRow(rowCount);
      var noCell = row.insertCell(0);
      var mataKuliahCell = row.insertCell(1);
      var aksiCell = row.insertCell(2);

      noCell.innerHTML = rowCount+1;
      mataKuliahCell.innerHTML = '<input type="text" name="mataKuliah[]">';
      aksiCell.innerHTML = '<button type="button" onclick="tambahMataKuliah()">Tambah</button> <button type="button" onclick="hapusMataKuliah(this)">Hapus</button>';
      return;
    }

    function hapusMataKuliah(button) {
      var row = button.parentNode.parentNode;
      
      var table = row.parentNode;
      table.removeChild(row);

      // Update nomor urut
      var rows = table.getElementsByTagName("tr");
      console.log(rows,'rows');
      for (var i = 0; i < rows.length; i++) {
        rows[i].getElementsByTagName("td")[0].innerHTML = i + 1;
      }
    }
  </script>
</body>
</html>
