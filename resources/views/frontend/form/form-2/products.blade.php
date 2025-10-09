<div class="container mt-5">
    <p>
        <small>
            <i>
                Add your product details here by listing and describing the key products or services your company offers
            </i>
        </small>
    </p>
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
                    <textarea class="form-control summernote" id="product_desc"></textarea>
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
                    <textarea class="form-control summernote" id="product_edit_desc"></textarea>
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
        // Inisialisasi Summernote
        $('.summernote').summernote();
        loadLogProduct();
        loadProduct();
    });

    // Fungsi untuk menambahkan baris baru ke tabel
    function editProduct(id) {
        // Mengambil data untuk produk yang dipilih menggunakan Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/product') }}/' + id,
            success: function(response) {
                console.log(response.data);
                $('#product_edit_file').val('');
                $('#product_edit_image').val('');
                var product = response.data;

                // Mengisi field dalam modal edit dengan data yang ada
                $('#product_id').val(product.id);
                $('#product_edit_title').val(product.title);
                $('#product_edit_category').val(product.product_category_id).trigger('change');
                $('#product_edit_video').val(product.video);
                $('#product_edit_document_name').val(product.document_name);

                // Mengisi Summernote dengan deskripsi produk
                $('#product_edit_desc').summernote('code', product.desc);

                var image = product.image;
                if (image) {
                    $('#product_image_info').attr('href', 'https://indonesiaminer.com/' + product.image);
                    $('#product_image_info').text('open link');
                } else {
                    $('#product_image_info').text('');
                }

                var file = product.file;
                if (file) {
                    $('#product_file_info').attr('href', 'https://indonesiaminer.com/' + product.file);
                    $('#product_file_info').text('open link');
                } else {
                    $('#product_file_info').text('');
                }

                // Membuka modal edit
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
        var description = $('#product_edit_desc').summernote('code'); // Mengambil konten Summernote
        var fileInput = $('#product_edit_file')[0];
        var imageInput = $('#product_edit_image')[0];

        // Validasi input
        if (!title || !category || !description) {
            Swal.fire({
                title: 'Alert',
                text: 'Please input all data',
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

        if (videoUrl) {
            formData.append('video_url', videoUrl);
        }

        if (documentName) {
            formData.append('document_name', documentName);
        }

        if (fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }

        if (imageInput.files[0]) {
            formData.append('image', imageInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show();

        $.ajax({
            type: 'POST',
            url: '{{ url('/product') }}/' + id,
            data: formData,
            processData: false,
            contentType: false,
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
                $('.loading-wrapper, .overlay').hide();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function tambahProduct() {
        $('#productModal').modal('show');
    }

    function hapusProduct(index) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Are you sure you want to delete this?',
            text: 'This action cannot be undone',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loading-wrapper, .overlay').show();

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
                        $('.loading-wrapper, .overlay').hide();
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
        var desc = $('#product_desc').summernote('code'); // Mengambil konten Summernote

        // Validasi input
        if (!title || !category || !desc) {
            Swal.fire({
                title: 'Alert',
                text: 'Please input all data',
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

        if (videoUrl) {
            formData.append('video_url', videoUrl);
        }

        if (documentName) {
            formData.append('document_name', documentName);
        }

        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        }

        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show();

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

                // Reset form
                $('#product_title').val('');
                $('#product_category').val('').trigger('change');
                $('#product_video').val('');
                $('#product_document_name').val('');
                $('#product_file').val('');
                $('#product_desc').summernote('code', '');
                $('.loading-wrapper, .overlay').hide();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadProduct() {
        $('#tabelProduct').empty();

        $.ajax({
            type: 'GET',
            url: '{{ url('/product') }}',
            success: function(response) {
                var data = response.data;

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
            url: '{{ url('product/log') }}',
            success: function(response) {
                if (response) {
                    var updatedAt = new Date(response.updated_at);
                    var logDiv = $(
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert">');
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
                    $('.logger-product').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
