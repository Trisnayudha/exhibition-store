<div class="container mt-5">
    <div class="logger-media">

    </div>
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tambahMedia()">Add</button>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabelMedia">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="mediaModal">
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
                    <label for="media_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="media_image" accept="image/jpeg, image/png">
                </div>

                <div class="form-group">
                    <label for="media_title">Title</label>
                    <input type="text" class="form-control" id="media_title">
                </div>
                <div class="form-group">
                    <label for="media_category">Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="media_category">
                        @foreach ($media_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="media_location">Location</label>
                    <input type="text" class="form-control" id="media_location">
                </div>
                <div class="form-group">
                    <label for="media_desc">Description</label>
                    <textarea class="form-control ckeditor" id="media_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="media_file">File (PDF, max 10MB)</label>
                    <input type="file" class="form-control" id="media_file" accept=".pdf">
                </div>
                <div class="form-group">
                    <label for="media_document_name">Document Name</label>
                    <input type="text" class="form-control" id="media_document_name">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanMedia()">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal" id="mediaEditModal">
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
                <input type="hidden" name="media_id" id="media_id">
                <div class="form-group">
                    <label for="media_edit_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="media_edit_image" accept="image/jpeg, image/png">
                    <span><a href="" id="media_image_info" target="_blank"></a></span>
                    <!-- Ini adalah elemen tambahan untuk menampilkan teks -->
                </div>

                <div class="form-group">
                    <label for="media_edit_title">Title</label>
                    <input type="text" class="form-control" id="media_edit_title">
                </div>
                <div class="form-group">
                    <label for="media_edit_category">Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="media_edit_category">
                        @foreach ($media_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="media_edit_location">Location</label>
                    <input type="text" class="form-control" id="media_edit_location">
                </div>
                <div class="form-group">
                    <label for="media_edit_desc">Description</label>
                    <textarea class="form-control ckeditor" id="media_edit_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="media_edit_file">File (PDF, max 10MB)</label>
                    <input type="file" class="form-control" id="media_edit_file" accept=".pdf">
                    <span><a href="" id="media_file_info" target="_blank"></a></span>
                </div>
                <div class="form-group">
                    <label for="media_edit_document_name">Document Name</label>
                    <input type="text" class="form-control" id="media_edit_document_name">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateMedia()">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>




<script>
    // Load data on page load
    $(document).ready(function() {
        loadMedia();
        loadLogMedia();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editMedia(id) {
        // Retrieve data for the selected representative using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/media') }}/' + id,
            success: function(response) {
                console.log(response.data)
                $('#media_edit_file').val('');
                $('#media_edit_image').val('');
                var media = response.data;

                // Populate the fields in the edit modal with existing data
                $('#media_id').val(media.id);
                $('#media_edit_title').val(media.title);
                $('#media_edit_location').val(media.location);
                // Set the value of the category select
                $('#media_edit_category').val(media.media_category_id);
                // Set the value of CKEditor
                CKEDITOR.instances.media_edit_desc.setData(media.desc);
                $('#media_edit_document_name').val(media.document_name);

                var image = media.image;
                if (image) {
                    $('#media_image_info').attr('href', 'https://indonesiaminer.com/' +
                        media
                        .image);
                    $('#media_image_info').text('open link')
                } else {
                    $('#media_image_info').text('')
                }

                var file = media.file;
                if (file) {
                    $('#media_file_info').attr('href', 'https://indonesiaminer.com/' +
                        media
                        .file);
                    $('#media_file_info').text('open link')
                } else {
                    $('#media_file_info').text('')
                }

                // Open the edit modal
                $('#mediaEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateMedia() {
        var id = $('#media_id').val();
        var title = $('#media_edit_title').val();
        var category = $('#media_edit_category').val();
        var location = $('#media_edit_location').val();
        var description = CKEDITOR.instances.media_edit_desc.getData();
        var fileInput = $('#media_edit_file')[0];
        var imageInput = $('#media_edit_image')[0];
        var documentName = $('#media_edit_document_name').val();

        // Validasi input
        if (!title || !category || !location || !description) {
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
        formData.append('image', imageInput.files[0]);
        formData.append('title', title);
        formData.append('category', category);
        formData.append('location', location);
        formData.append('description', description);
        formData.append('file', fileInput.files[0]);
        formData.append('document_name', documentName);
        console.log(formData)
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax
        $.ajax({
            type: 'POST', // Gunakan POST untuk upload file
            url: '{{ url('/media') }}/' + id,
            data: formData,
            processData: false, // Penting: mengatur ini ke false sehingga jQuery tidak memproses data
            contentType: false, // Penting: mengatur ini ke false sehingga jQuery tidak menetapkan contentType
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                loadLogMedia();
                loadMedia();
                $('#mediaEditModal').modal('hide');
                $('#media_edit_file').val('');
                $('.loading-wrapper, .overlay').hide();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }




    // Function to open the input modal
    function tambahMedia() {
        $('#mediaModal').modal('show');
    }

    function hapusMedia(index) {
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
                    url: '{{ url('/media') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadLogMedia();
                        loadMedia();
                        $('.loading-wrapper, .overlay').hide();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanMedia() {
        var imageInput = $('#media_image')[0];
        var title = $('#media_title').val();
        var category = $('#media_category').val();
        var location = $('#media_location').val();
        var desc = CKEDITOR.instances.media_desc.getData();
        var fileInput = $('#media_file')[0];
        var documentName = $('#media_document_name').val();

        // Validasi input
        if (!title || !category || !location || !desc) {
            // Menampilkan swal menggunakan Swal 2
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
        formData.append('image', imageInput.files[0]);
        formData.append('title', title);
        formData.append('category', category);
        formData.append('location', location);
        formData.append('desc', desc);
        formData.append('file', fileInput.files[0]);
        formData.append('document_name', documentName);
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay
        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/media') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadLogMedia();
                loadMedia();
                $('#mediaModal').modal('hide');

                // Membersihkan inputan modal
                $('#media_title').val('');
                $('#media_category').val('').trigger('change'); // Reset Select2 value
                $('#media_location').val('');
                CKEDITOR.instances.media_desc.setData(''); // Mengosongkan CKEditor
                $('#media_file').val(''); // Reset file input
                $('#media_document_name').val('');
                $('.loading-wrapper, .overlay').hide(); // Menghide loader dan overlay
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadMedia() {
        // Clear existing table rows
        $('#tabelMedia').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/media') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = '{{ config('app.image_base_url') }}';

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var media = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + media.title + '</td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editMedia(' + media.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusMedia(' + media.id +
                        ')">Delete</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelMedia').append(row);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogMedia() {
        $.ajax({
            type: 'GET',
            url: '{{ url('media/log') }}', // Ganti dengan URL API yang sesuai
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

                    // Tampilkan elemen div dalam elemen dengan class "logger-media"
                    $('.logger-media').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
