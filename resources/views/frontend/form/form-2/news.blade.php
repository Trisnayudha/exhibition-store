<div class="container mt-5">
    <div class="logger-news">

    </div>
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tambahNews()">Tambah</button>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tabelNews">
            <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="newsModal">
    <div class="modal-dialog modal-lg">
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
                    <label for="news_title">News Name</label>
                    <input type="text" class="form-control" id="news_title">
                </div>
                <div class="form-group">
                    <label for="news_category">News Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="news_category">
                        @foreach ($news_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="news_date">Date news</label>
                    <input type="date" name="news_date" id="news_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="news_desc">Deskripsi</label>
                    <textarea class="form-control ckeditor" id="news_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="news_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="news_image" accept="image/jpeg, image/png">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanNews()">Tambah</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal" id="newsEditModal">
    <div class="modal-dialog modal-lg">
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
                    <label for="news_edit_title">News Name</label>
                    <input type="text" class="form-control" id="news_edit_title">
                    <input type="hidden" name="news_id" id="news_id">
                </div>
                <div class="form-group">
                    <label for="news_edit_category">News Category</label>
                    <!-- Menggunakan Select2 untuk kategori -->
                    <select class="form-control" id="news_edit_category">
                        @foreach ($news_category as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="news_edit_date">Date news</label>
                    <input type="date" name="news_edit_date" id="news_edit_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="news_edit_desc">Deskripsi</label>
                    <textarea class="form-control ckeditor" id="news_edit_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="news_edit_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="news_edit_image" accept="image/jpeg, image/png">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateNews()">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<script>
    // Load data on page load
    $(document).ready(function() {
        loadLogNews();
        loadNews();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editNews(id) {
        // Retrieve data for the selected project using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/news') }}/' + id,
            success: function(response) {
                console.log(response.data);
                var news = response.data;

                // Populate the fields in the edit modal with existing data
                $('#news_id').val(news.id);
                $('#news_edit_title').val(news.title);
                $('#news_edit_category').val(news.news_category_id).trigger('change');
                var date = response.data.date_news;
                // Konversi string tanggal ke objek tanggal JavaScript
                var dateObject = new Date(date);

                // Format tanggal sesuai dengan atribut type="date"
                var formattedDateString = dateObject.toISOString().split('T')[0];

                // Set nilai input tanggal
                $('#news_edit_date').val(formattedDateString);
                // $('#news_edit_date').val(formattedDateString);
                CKEDITOR.instances.news_edit_desc.setData(news.desc);

                // Open the edit modal
                $('#newsEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function updateNews() {
        var id = $('#news_id').val();
        var title = $('#news_edit_title').val();
        var category = $('#news_edit_category').val();
        var dateNews = $('#news_edit_date').val();
        var description = CKEDITOR.instances.news_edit_desc.getData();
        var imageInput = $('#news_edit_image')[0];
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

        // Create a JSON object
        var jsonData = {
            id: id,
            title: title,
            category: category,
            description: description,
            date: dateNews
        };

        // Add image data to the JSON object if present
        if (imageInput.files[0]) {
            jsonData.image = imageInput.files[0];
        }
        console.log(jsonData)

        // Send data to the server using Ajax
        $.ajax({
            type: 'PUT',
            url: '{{ url('/news') }}/' + id,
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadLogNews();
                loadNews();
                $('#newsEditModal').modal('hide');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    // Function to open the input modal
    function tambahNews() {
        $('#newsModal').modal('show');
    }

    function hapusNews(index) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Konfirmasi pengguna sebelum menghapus
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data product akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan penghapusan ke server menggunakan Ajax
                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('/news') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadLogNews();
                        loadNews();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanNews() {
        var imageInput = $('#news_image')[0];
        var title = $('#news_title').val();
        var category = $('#news_category').val();
        var newsDate = $('#news_date').val();
        var desc = CKEDITOR.instances.news_desc.getData();

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
        formData.append('news_date', newsDate);
        formData.append('desc', desc);

        // Check if the image field is filled
        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        }

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/news') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadNews();
                loadLogNews();
                $('#newsModal').modal('hide');

                // Membersihkan inputan modal
                $('#news_title').val('');
                $('#news_category').val('').trigger('change'); // Reset Select2 value
                $('#news_date').val('');
                CKEDITOR.instances.news_desc.setData(''); // Mengosongkan CKEditor
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadNews() {
        // Clear existing table rows
        $('#tabelNews').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/news') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = '{{ config('app.image_base_url') }}';

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var news = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + news.title + '</td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editNews(' + news.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusNews(' + news.id +
                        ')">Hapus</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelNews').append(row);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogNews() {
        $.ajax({
            type: 'GET',
            url: '{{ url('news/log') }}', // Ganti dengan URL API yang sesuai
            success: function(response) {
                if (response) {
                    // Parse tanggal dari format ISO
                    var updatedAt = new Date(response.updated_at);
                    console.log(updatedAt);
                    // Buat elemen div untuk menampilkan log
                    var logDiv = $(
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert">');

                    // Tambahkan konten log ke dalam elemen div
                    logDiv.html('Already updated at <strong>' +
                        updatedAt.toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true
                        }) +
                        '</strong>' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>');

                    // Tampilkan elemen div dalam elemen dengan class "logger-news"
                    $('.logger-news').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
