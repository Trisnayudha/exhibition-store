<div class="container mt-5">
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tampilkanProducts()">Tambah</button>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabelBody">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="modalProducts">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form input untuk setiap kolom -->
                <div class="form-group">
                    <label for="imageInput">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="imageInput" accept="image/jpeg, image/png">
                </div>
                <div class="form-group">
                    <label for="fileInput">File (PDF, max 10MB)</label>
                    <input type="file" class="form-control" id="fileInput" accept=".pdf">
                </div>
                <div class="form-group">
                    <label for="titleInput">Title</label>
                    <input type="text" class="form-control" id="titleInput">
                </div>
                <div class="form-group">
                    <label for="categoryInput">Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="categoryInput">
                        <option value="Category 1">Category 1</option>
                        <option value="Category 2">Category 2</option>
                        <!-- Tambahkan opsi kategori lainnya sesuai kebutuhan -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="locationInput">Location</label>
                    <input type="text" class="form-control" id="locationInput">
                </div>
                <div class="form-group">
                    <label for="">Video URL</label>
                    <input type="text" name="video" id="video">
                </div>
                <div class="form-group">
                    <label for="descriptionInput">Deskripsi</label>
                    <textarea class="form-control" id="descriptionInput"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="tambahProducts()">Tambah</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<script>
    function dataTabelProducts() {
        $.ajax({
            type: 'GET',
            url: 'muat_data_tabel.php', // Ganti dengan URL yang sesuai untuk memuat data dari server
            success: function(response) {
                // Isi tabel dengan data yang diterima dari server
                $('#tabelBody').html(response);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    // Panggil fungsi dataTabelProducts saat halaman dimuat
    $(document).ready(function() {
        dataTabelProducts();
    });

    function tampilkanProducts() {
        // Tampilkan modal
        $('#modalProducts').modal('show');
    }

    function tambahProducts() {
        // Validasi gambar
        var imageInput = document.getElementById('imageInput');
        var fileInput = document.getElementById('fileInput');

        var imageFile = imageInput.files[0];
        var file = fileInput.files[0];

        if (imageFile) {
            var imageSize = imageFile.size;
            var imageType = imageFile.type;

            if (imageSize > 10000000) { // 10MB
                alert('Ukuran file gambar melebihi batas maksimum (10MB).');
                return;
            }

            if (imageType !== 'image/jpeg' && imageType !== 'image/png') {
                alert('Format file gambar tidak didukung. Gunakan format JPG atau PNG.');
                return;
            }
        }

        if (file) {
            var fileSize = file.size;

            if (fileSize > 10000000) { // 10MB
                alert('Ukuran file melebihi batas maksimum (10MB).');
                return;
            }

            if (file.type !== 'application/pdf') {
                alert('Format file tidak didukung. Gunakan format PDF.');
                return;
            }
        }

        // Lakukan penambahan baris seperti pada fungsi tambahProducts yang sudah ada
        // ...
        $.ajax({
            type: 'POST',
            url: 'simpan_data.php', // Ganti dengan URL penyimpanan data di server
            data: {
                // ... (kirim data sesuai kebutuhan)
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                // Muat ulang data tabel setelah data berhasil disimpan
                dataTabelProducts();
                // Tutup modal setelah penambahan baris
                $('#modalProducts').modal('hide');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
        // Tutup modal setelah penambahan baris
        $('#modalProducts').modal('hide');
    }
</script>
