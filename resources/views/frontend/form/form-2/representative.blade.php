<div class="container mt-5">
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tambahRepresentative()">Tambah</button>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Job Title</th>
                <th>Email</th>
                <th>Short Bio</th>
                <th>LinkedIn</th>
                <th>Foto</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabelRepresentative">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</div>
<script>
    // Fungsi untuk menambahkan baris baru ke tabel
    function tambahRepresentative() {
        // Ambil elemen tbody
        var tbody = document.getElementById('tabelRepresentative');

        // Hitung jumlah baris saat ini
        var rowCount = tbody.rows.length;

        // Buat elemen baris baru
        var row = tbody.insertRow(rowCount);

        // Tambahkan sel-sel ke dalam baris
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);
        var cell8 = row.insertCell(7);

        // Isi sel-sel dengan formulir input
        cell1.innerHTML = rowCount + 1;
        cell2.innerHTML = '<input type="text" class="form-control" name="nama[]">';
        cell3.innerHTML = '<input type="text" class="form-control" name="job_title[]">';
        cell4.innerHTML = '<input type="email" class="form-control" name="email[]">';
        cell5.innerHTML = '<input type="text" class="form-control" name="short_bio[]">';
        cell6.innerHTML = '<input type="text" class="form-control" name="linkedin[]">';
        cell7.innerHTML = '<input type="file" class="form-control" name="foto[]">';
        cell8.innerHTML = '<button class="btn btn-danger" onclick="hapusBaris(this)">Hapus</button> ' +
            '<button class="btn btn-success" onclick="simpanData(this.parentNode.parentNode)">Save</button>';
    }

    // Fungsi untuk menghapus baris
    function hapusBaris(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    // Fungsi untuk menyimpan data menggunakan Ajax
    function simpanData(row) {
        var data = {};

        // Ambil nilai input dari setiap kolom pada baris tertentu
        data.nama = row.cells[1].getElementsByTagName('input')[0].value;
        data.jobTitle = row.cells[2].getElementsByTagName('input')[0].value;
        data.email = row.cells[3].getElementsByTagName('input')[0].value;
        data.shortBio = row.cells[4].getElementsByTagName('input')[0].value;
        data.linkedin = row.cells[5].getElementsByTagName('input')[0].value;

        // (Opsional) Lakukan validasi data di sini sebelum dikirim ke server

        // Kirim data ke server menggunakan Ajax (contoh dummy)
        $.ajax({
            type: 'POST',
            url: 'simpan_data.php', // Ganti dengan URL penyimpanan data di server
            data: {
                data: JSON.stringify(data)
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                // Tambahkan logika atau tindakan setelah data disimpan di sini
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
