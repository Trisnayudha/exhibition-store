<div class="container mt-5">
    <div class="logger-product">

    </div>
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tambahProduct()">Add</button>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabelProduct">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="productModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form input untuk setiap kolom -->
                <div class="form-group">
                    <label for="product_title">Product Name</label>
                    <input type="text" class="form-control" id="product_title">
                </div>
                <div class="form-group">
                    <label for="product_category">Product Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="product_category">
                        @foreach ($product_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_video">Video URL</label>
                    <input type="text" name="product_video" id="product_video" class="form-control">
                </div>
                <div class="form-group">
                    <label for="product_document_name">Document Name</label>
                    <input type="text" name="product_document_name" id="product_document_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="product_file">File (PDF, max 2MB)</label>
                    <input type="file" class="form-control" id="product_file" accept=".pdf">
                </div>
                <div class="form-group">
                    <label for="product_desc">Description</label>
                    <textarea class="form-control ckeditor" id="product_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="product_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="product_image" accept="image/jpeg, image/png">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanProduct()">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal" id="productEditModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form input untuk setiap kolom -->
                <div class="form-group">
                    <label for="product_title">Product Name</label>
                    <input type="text" class="form-control" id="product_edit_title">
                    <input type="hidden" name="product_id" id="product_id">
                </div>
                <div class="form-group">
                    <label for="product_category">Product Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="product_edit_category">
                        @foreach ($product_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_edit_video">Video URL</label>
                    <input type="text" name="product_edit_video" id="product_edit_video" class="form-control">
                </div>
                <div class="form-group">
                    <label for="product_edit_document_name">Document Name</label>
                    <input type="text" name="product_edit_document_name" id="product_edit_document_name"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="product_edit_file">File (PDF, max 2MB)</label>
                    <input type="file" class="form-control" id="product_edit_file" accept=".pdf">
                    <span><a href="" id="product_file_info" target="_blank"></a></span>
                </div>
                <div class="form-group">
                    <label for="product_edit_desc">Description</label>
                    <textarea class="form-control ckeditor" id="product_edit_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="product_edit_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="product_edit_image"
                        accept="image/jpeg, image/png">
                    <span><a href="" id="product_image_info" target="_blank"></a></span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateProduct()">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    // Load data on page load
    $(document).ready(function() {
        loadLogProduct();
        loadProduct();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editProduct(id) {
        // Retrieve data for the selected representative using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/product') }}/' + id,
            success: function(response) {
                console.log(response.data);
                var product = response.data;

                // Populate the fields in the edit modal with existing data
                $('#product_id').val(product.id);
                $('#product_edit_title').val(product.title);
                $('#product_edit_location').val(product.location);

                // Set the value of the category select
                $('#product_category').val(product.product_category_id).trigger('change');

                $('#product_edit_video').val(product.video);
                $('#product_edit_document_name').val(product.document_name);
                var image = product.image;
                if (image) {
                    $('#product_image_info').attr('href', 'https://indonesiaminer.com/' +
                        product
                        .image);
                    $('#product_image_info').text('open link')
                } else {
                    $('#product_image_info').text('')
                }

                var file = product.file;
                if (file) {
                    $('#product_file_info').attr('href', 'https://indonesiaminer.com/' +
                        product
                        .file);
                    $('#product_file_info').text('open link')
                } else {
                    $('#product_file_info').text('')
                }
                // Set the value of CKEditor
                CKEDITOR.instances.product_edit_desc.setData(product.desc);

                // Open the edit modal
                $('#productEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function updateProduct() {
        var id = $('#product_id').val();
        var title = $('#product_edit_title').val();
        var category = $('#product_edit_category').val();
        var videoUrl = $('#product_edit_video').val();
        var documentName = $('#product_edit_document_name').val();
        var description = CKEDITOR.instances.product_edit_desc.getData();
        var fileInput = $('#product_edit_file')[0];
        var imageInput = $('#product_edit_image')[0];

        // Validasi input
        if (!title || !category || !description) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Harap isi semua kolom dan pilih file!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var formData = new FormData();
        formData.append('title', title);
        formData.append('category', category);
        formData.append('description', description);

        // Add optional fields to the form data if present
        if (videoUrl) {
            formData.append('video_url', videoUrl);
        }

        if (documentName) {
            formData.append('document_name', documentName);
        }

        // Add file data to the form data if present
        if (fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }

        // Add image data to the form data if present
        if (imageInput.files[0]) {
            formData.append('image', imageInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax
        $.ajax({
            type: 'POST',
            url: '{{ url('/product') }}/' + id,
            data: formData,
            processData: false, // Penting: mengatur ini ke false sehingga jQuery tidak memproses data
            contentType: false, // Penting: mengatur ini ke false sehingga jQuery tidak menetapkan contentType
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadLogProduct();
                loadProduct();
                $('#productEditModal').modal('hide');
                $('#product_edit_file').val('');
                $('#product_edit_image').val('');
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }





    // Function to open the input modal
    function tambahProduct() {
        $('#productModal').modal('show');
    }

    function hapusProduct(index) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Konfirmasi pengguna sebelum menghapus
        Swal.fire({
            title: 'Are you sure you want to delete this?',
            text: 'This action cannot be undone',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan penghapusan ke server menggunakan Ajax
                $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('/product') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadLogProduct();
                        loadProduct();
                        $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanProduct() {
        var imageInput = $('#product_image')[0];
        var title = $('#product_title').val();
        var category = $('#product_category').val();
        var videoUrl = $('#product_video').val();
        var documentName = $('#product_document_name').val();
        var fileInput = $('#product_file')[0];
        var desc = CKEDITOR.instances.product_desc.getData();
        var location = $('#product_location').val();

        // Validasi input
        if (!title || !category || !desc) {
            // Menampilkan swal menggunakan Swal 2
            Swal.fire({
                title: 'Peringatan',
                text: 'Harap isi semua kolom dan pilih gambar!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var formData = new FormData();
        formData.append('title', title);
        formData.append('category', category);
        formData.append('desc', desc);
        formData.append('location', location);

        // Check if the image field is filled
        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        }

        // Check if the file field is filled
        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
        }

        formData.append('document_name', documentName);

        // Check if the video URL field is filled
        if (videoUrl) {
            formData.append('video_url', videoUrl);
        }
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/product') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadProduct();
                loadLogProduct();
                $('#productModal').modal('hide');

                // Membersihkan inputan modal
                $('#product_title').val('');
                $('#product_category').val('').trigger('change'); // Reset Select2 value
                $('#product_video').val('');
                $('#product_document_name').val('');
                $('#product_file').val(''); // Reset file input
                CKEDITOR.instances.product_desc.setData(''); // Mengosongkan CKEditor
                $('#product_location').val('');
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }





    function loadProduct() {
        // Clear existing table rows
        $('#tabelProduct').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/product') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = '{{ config('app.image_base_url') }}';

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var product = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + product.title + '</td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editProduct(' + product.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusProduct(' + product.id +
                        ')">Delete</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelProduct').append(row);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogProduct() {
        $.ajax({
            type: 'GET',
            url: '{{ url('product/log') }}', // Ganti dengan URL API yang sesuai
            success: function(response) {
                if (response) {
                    // Parse tanggal dari format ISO
                    var updatedAt = new Date(response.updated_at);
                    console.log(updatedAt);
                    // Buat elemen div untuk menampilkan log
                    var logDiv = $(
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert">');

                    // Tambahkan konten log ke dalam elemen div
                    logDiv.html(' Last update : <strong>' +
                        updatedAt.toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true
                        }) +
                        '</strong> GMT + 7' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>');

                    // Tampilkan elemen div dalam elemen dengan class "logger-product"
                    $('.logger-product').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
