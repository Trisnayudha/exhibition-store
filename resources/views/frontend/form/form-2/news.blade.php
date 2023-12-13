<div class="container mt-5">
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tampilkanNews()">Tambah</button>

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
<div class="modal" id="modalNews">
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
                    <label for="imageInput">Image <small>(800x300 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="imageInput" accept="image/jpeg, image/png">
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
                    <label for="descriptionInput">Deskripsi</label>
                    <textarea class="form-control" id="descriptionInput"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="tambahNews()">Tambah</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
