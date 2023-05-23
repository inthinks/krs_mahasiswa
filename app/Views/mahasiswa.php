<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
                border: 1px solid black;
                padding: 8px;
        }
        .hint {
            font-style: italic;
        }
        .center-text {
            text-align: center;
        }
    </style>
  <title>List Mahasiswa</title>
  <?php var_dump(session()->getFlashdata('message')) ?>
</head>
<body>
  <h2>List Mahasiswa</h2>

  Kata Kunci: <input name="text" type="text" id="searchInput" placeholder="Cari mahasiswa...">
  <button onclick="search()">Cari</button>
  <br />
  <span class="hint">
    *kata kunci berdasarkan nama, jenis kelamin, dan alamat
  </span>
  <br /><br /><br />
  <button onclick="add()">Tambah Data</button>
  <br/>
  <br/>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Jumlah Mata Kuliah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="mahasiswaTable">
      <!-- Data mahasiswa akan ditampilkan di sini -->
    </tbody>
  </table>

  <script>
    // data mahasiswa
    var dataMahasiswa = <?php echo $data ?>

    // Fungsi untuk menampilkan data mahasiswa
    function showMahasiswa() {
      var table = document.getElementById('mahasiswaTable');
      table.innerHTML = '';

      for (var i = 0; i < dataMahasiswa.length; i++) {
        var row = table.insertRow(i);

        var cellNo = row.insertCell(0);
        var cellNama = row.insertCell(1);
        var cellJenisKelamin = row.insertCell(2);
        var cellAlamat = row.insertCell(3);
        var cellMatkul = row.insertCell(4);
        var cellAksi = row.insertCell(5);

        cellNo.innerHTML = i + 1;
        cellNo.className = "center-text";
        cellNama.innerHTML = dataMahasiswa[i].nama;
        cellJenisKelamin.innerHTML = dataMahasiswa[i].jenis_kelamin;
        cellMatkul.innerHTML = dataMahasiswa[i].jumlah_matkul;
        cellMatkul.className = "center-text";
        cellAlamat.innerHTML = dataMahasiswa[i].alamat;
        cellAksi.innerHTML = '<button onclick="editMahasiswa('+ dataMahasiswa[i].id + ')">Ubah</button> ' +
                             '<button onclick="hapusMahasiswa('+(i) + ', ' + dataMahasiswa[i].id + ')">Hapus</button>';
      }
    }

    async function getSearch(){
      var input = document.getElementById('searchInput').value;
      const res = await fetch('/mahasiswa/search?query='+input);
      console.log(res,'resssssss')
      return res.json();
    }

    // Fungsi untuk mencari mahasiswa
    function search() {
      getSearch().then(res => {
        dataMahasiswa = res
        console.log(res,'aaaaaaa');
        showMahasiswa();
      })
    }

    function add() {
      location.href = '/krs';
    }

    // Fungsi untuk mengubah data mahasiswa
    function editMahasiswa(id) {
      console.log('Ubah mahasiswa dengan index: ' + id);
      location.href = '/krs/edit/'+id;
    }

    // Fungsi untuk menghapus data mahasiswa
    function hapusMahasiswa(id, index) {
      console.log('Hapus mahasiswa dengan index: ' + index);
      fetch('/mahasiswa/delete/'+index,
        {
          method: 'GET'
        })
        .then(res => res.text()) 
        .then(res => console.log(res))

        dataMahasiswa.splice(dataMahasiswa.findIndex(item => item.id === id), 1);
        console.log(dataMahasiswa);
        showMahasiswa();
        
    }

    showMahasiswa();
  </script>
</body>
</html>