<div class="container mt-5">
    <div class="logger-project">

    </div>
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tambahProject()">Add</button>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabelProject">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="projectModal">
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
                    <label for="project_title">Project Name</label>
                    <input type="text" class="form-control" id="project_title">
                </div>
                <div class="form-group">
                    <label for="project_category">Project Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="project_category">
                        @foreach ($project_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="project_date">Date Project</label>
                    <input type="date" name="project_date" id="project_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="project_desc">Description</label>
                    <textarea class="form-control summernote" id="project_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="project_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="project_image" accept="image/jpeg, image/png">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanProject()">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal" id="projectEditModal">
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
                    <label for="project_edit_title">Project Name</label>
                    <input type="text" class="form-control" id="project_edit_title">
                    <input type="hidden" name="project_id" id="project_id">
                </div>
                <div class="form-group">
                    <label for="project_edit_category">Project Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="project_edit_category">
                        @foreach ($project_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="project_edit_date">Date Project</label>
                    <input type="date" name="project_edit_date" id="project_edit_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="project_edit_desc">Description</label>
                    <textarea class="form-control summernote" id="project_edit_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="project_edit_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="project_edit_image" accept="image/jpeg, image/png">
                    <span><a href="" id="project_image_info" target="_blank"></a></span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateProject()">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    // Load data on page load
    $(document).ready(function() {
        loadLogProject();
        loadProject();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editProject(id) {
        // Retrieve data for the selected project using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/project') }}/' + id,
            success: function(response) {
                console.log(response.data);
                $('#project_edit_image').val('');
                var project = response.data;

                // Populate the fields in the edit modal with existing data
                $('#project_id').val(project.id);
                $('#project_edit_title').val(project.title);
                $('#project_edit_category').val(project.project_category_id).trigger('change');
                var date = response.data.date_project;
                // Konversi string tanggal ke objek tanggal JavaScript
                var dateObject = new Date(date);

                // Format tanggal sesuai dengan atribut type="date"
                var formattedDateString = dateObject.toISOString().split('T')[0];

                // Set nilai input tanggal
                $('#project_edit_date').val(formattedDateString);
                // $('#project_edit_date').val(formattedDateString);
                CKEDITOR.instances.project_edit_desc.setData(project.desc);
                var image = project.image;
                if (image) {
                    $('#project_image_info').attr('href', 'https://indonesiaminer.com/' +
                        project
                        .image);
                    $('#project_image_info').text('open link')
                } else {
                    $('#project_image_info').text('')
                }

                // Open the edit modal
                $('#projectEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function updateProject() {
        var id = $('#project_id').val();
        var title = $('#project_edit_title').val();
        var category = $('#project_edit_category').val();
        var dateProject = $('#project_edit_date').val();
        var description = CKEDITOR.instances.project_edit_desc.getData();
        var imageInput = $('#project_edit_image')[0];

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
        formData.append('id', id);
        formData.append('title', title);
        formData.append('category', category);
        formData.append('description', description);
        formData.append('date', dateProject);

        // Add image data to the form data if present
        if (imageInput.files[0]) {
            formData.append('image', imageInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax
        $.ajax({
            type: 'POST',
            url: '{{ url('/project') }}/' + id,
            data: formData,
            processData: false, // Penting: mengatur ini ke false sehingga jQuery tidak memproses data
            contentType: false, // Penting: mengatur ini ke false sehingga jQuery tidak menetapkan contentType
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadLogProject();
                loadProject();
                $('#projectEditModal').modal('hide');
                $('#project_edit_image').val('');
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    // Function to open the input modal
    function tambahProject() {
        $('#projectModal').modal('show');
    }

    function hapusProject(index) {
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
                $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

                // Kirim permintaan penghapusan ke server menggunakan Ajax
                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('/project') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadLogProject();
                        loadProject();
                        $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanProject() {
        var imageInput = $('#project_image')[0];
        var title = $('#project_title').val();
        var category = $('#project_category').val();
        var projectDate = $('#project_date').val();
        var desc = CKEDITOR.instances.project_desc.getData();

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
        formData.append('project_date', projectDate);
        formData.append('desc', desc);

        // Check if the image field is filled
        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/project') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadProject();
                loadLogProject();
                $('#projectModal').modal('hide');

                // Membersihkan inputan modal
                $('#project_title').val('');
                $('#project_category').val('').trigger('change'); // Reset Select2 value
                $('#project_date').val('');
                CKEDITOR.instances.project_desc.setData(''); // Mengosongkan CKEditor
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadProject() {
        // Clear existing table rows
        $('#tabelProject').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/project') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = '{{ config('app.image_base_url') }}';

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var project = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + project.title + '</td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editProject(' + project.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusProject(' + project.id +
                        ')">Delete</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelProject').append(row);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogProject() {
        $.ajax({
            type: 'GET',
            url: '{{ url('project/log') }}', // Ganti dengan URL API yang sesuai
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

                    // Tampilkan elemen div dalam elemen dengan class "logger-project"
                    $('.logger-project').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
