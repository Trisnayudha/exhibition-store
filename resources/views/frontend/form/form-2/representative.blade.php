<div class="container mt-5">
    <div class="logger-representative">

    </div>
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tambahRepresentative()">Add</button>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Job Title</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabelRepresentative">
            <!-- Table content will be dynamically added here -->
        </tbody>
    </table>

</div>
<!-- Modal for Input -->
<div class="modal fade" id="representativeModal" tabindex="-1" role="dialog" aria-labelledby="representativeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="representativeModalLabel">Add Representative</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input fields for representative data -->
                <div class="form-group">
                    <label for="inputNama">Name</label>
                    <input type="text" class="form-control" id="representative_name">
                </div>
                <div class="form-group">
                    <label for="inputJobTitle">Job Title</label>
                    <input type="text" class="form-control" id="representative_job_title">
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="representative_email">
                </div>
                <div class="form-group">
                    <label for="inputShortBio">Short Bio</label>
                    <input type="text" class="form-control" id="representative_short_bio">
                </div>
                <div class="form-group">
                    <label for="inputLinkedIn">LinkedIn</label>
                    <input type="text" class="form-control" id="representative_linkedin">
                </div>
                <div class="form-group">
                    <label for="inputFoto">Image</label>
                    <input type="file" class="form-control" id="representative_image">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpanRepresentative()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Edit -->
<div class="modal fade" id="representativeEditModal" tabindex="-1" role="dialog"
    aria-labelledby="representativeEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="representativeEditModalLabel">Edit Representative</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input fields for editing representative data -->
                <div class="form-group">
                    <label for="editNama">Name</label>
                    <input type="text" class="form-control" id="representative_edit_name">
                    <input type="hidden" class="form-control" id="representative_id">
                </div>
                <div class="form-group">
                    <label for="editJobTitle">Job Title</label>
                    <input type="text" class="form-control" id="representative_edit_job_title">
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" class="form-control" id="representative_edit_email">
                </div>
                <div class="form-group">
                    <label for="editShortBio">Short Bio</label>
                    <input type="text" class="form-control" id="representative_edit_short_bio">
                </div>
                <div class="form-group">
                    <label for="editLinkedIn">LinkedIn</label>
                    <input type="text" class="form-control" id="representative_edit_linkedin">
                </div>
                <div class="form-group">
                    <label for="editFoto">Image</label>
                    <input type="file" class="form-control" id="representative_edit_image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateRepresentative()">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Load data on page load
    $(document).ready(function() {
        loadRepresentative();
        loadLogRepresentative();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editRepresentative(id) {
        // Retrieve data for the selected representative using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/representative') }}/' + id,
            success: function(response) {
                var representative = response.data;

                // Populate the fields in the edit modal with existing data
                $('#representative_id').val(representative.id);
                $('#representative_edit_name').val(representative.name);
                $('#representative_edit_job_title').val(representative.position);
                $('#representative_edit_email').val(representative.email);
                $('#representative_edit_short_bio').val(representative.bio);
                $('#representative_edit_linkedin').val(representative.linkedin);
                // $('#representative_edit_image').val(representative.image);

                // Open the edit modal
                $('#representativeEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateRepresentative() {
        var id = $('#representative_id').val();
        var name = $('#representative_edit_name').val();
        var position = $('#representative_edit_job_title').val();
        var email = $('#representative_edit_email').val();
        var short_bio = $('#representative_edit_short_bio').val();
        var linkedin = $('#representative_edit_linkedin').val();
        var imageInput = $('#representative_edit_image')[0];

        // Validasi input
        if (!name || !position || !email || !short_bio || !linkedin) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Harap isi semua kolom dan pilih gambar!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Create a JSON object
        var jsonData = {
            id: id,
            name: name,
            position: position,
            email: email,
            short_bio: short_bio,
            linkedin: linkedin
        };

        // Append image data if present
        if (imageInput.files[0]) {
            jsonData.image = imageInput.files[0];
        }
        // Send data to the server using Ajax
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        $.ajax({
            type: 'PUT',
            url: '{{ url('/representative') }}/' + id,
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadRepresentative();
                loadLogRepresentative();
                $('#representativeEditModal').modal('hide');
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    // Function to open the input modal
    function tambahRepresentative() {
        $('#representativeModal').modal('show');
    }

    function hapusRepresentative(index) {
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
                    url: '{{ url('/representative') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadRepresentative();
                        loadLogRepresentative();
                        $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanRepresentative() {
        var nama = $('#representative_name').val();
        var position = $('#representative_job_title').val();
        var email = $('#representative_email').val();
        var short_bio = $('#representative_short_bio').val();
        var linkedin = $('#representative_linkedin').val();
        var imageInput = $('#representative_image')[0];

        // Validasi input
        if (!nama || !position || !email || !short_bio || !linkedin) {
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
        formData.append('name', nama);
        formData.append('position', position);
        formData.append('email', email);
        formData.append('short_bio', short_bio);
        formData.append('linkedin', linkedin);

        // Cek apakah gambar diisi
        if (imageInput.files[0]) {
            formData.append('image', imageInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/representative') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Menutup swal loading ketika respons diterima
                Swal.close();

                console.log('Data berhasil disimpan:', response);
                loadRepresentative();
                loadLogRepresentative();
                $('#representativeModal').modal('hide');

                // Membersihkan inputan modal
                $('#representative_name').val('');
                $('#representative_job_title').val('');
                $('#representative_email').val('');
                $('#representative_short_bio').val('');
                $('#representative_linkedin').val('');
                $('#representative_image').val(''); // Jika menggunakan input type file
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                // Menutup swal loading ketika ada kesalahan
                Swal.close();

                console.error('Error:', error);
            }
        });
    }

    function simpanRepresentative() {
        var nama = $('#representative_name').val();
        var position = $('#representative_job_title').val();
        var email = $('#representative_email').val();
        var short_bio = $('#representative_short_bio').val();
        var linkedin = $('#representative_linkedin').val();
        var imageInput = $('#representative_image')[0];

        // Validasi input
        if (!nama || !position || !email || !short_bio || !linkedin) {
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
        formData.append('name', nama);
        formData.append('position', position);
        formData.append('email', email);
        formData.append('short_bio', short_bio);
        formData.append('linkedin', linkedin);

        // Cek apakah gambar diisi
        if (imageInput.files[0]) {
            formData.append('image', imageInput.files[0]);
        }

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/representative') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadRepresentative();
                loadLogRepresentative();
                $('#representativeModal').modal('hide');

                // Membersihkan inputan modal
                $('#representative_name').val('');
                $('#representative_job_title').val('');
                $('#representative_email').val('');
                $('#representative_short_bio').val('');
                $('#representative_linkedin').val('');
                $('#representative_image').val(''); // Jika menggunakan input type file
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadRepresentative() {
        // Clear existing table rows
        $('#tabelRepresentative').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/representative') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = 'https://indonesiaminer.com/';

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var representative = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + representative.name + '</td>' +
                        '<td>' + representative.position + '</td>' +
                        '<td><img src="' + imageBaseUrl + representative.image +
                        '" alt="Foto" style="width:50px;height:50px;"></td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editRepresentative(' + representative.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusRepresentative(' + representative.id +
                        ')">Delete</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelRepresentative').append(row);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogRepresentative() {
        $.ajax({
            type: 'GET',
            url: '{{ url('representative/log') }}', // Ganti dengan URL API yang sesuai
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

                    // Tampilkan elemen div dalam elemen dengan class "logger-representative"
                    $('.logger-representative').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
