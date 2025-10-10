<div class="container mt-5">
    <p>
        <small>
            <i>
                Use this section to share company news, press releases, and recent announcements, keeping participants
                informed about your latest developments, milestones, and important updates.
            </i>
        </small>
    </p>
    <div class="logger-news">

    </div>
    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" onclick="tambahNews()">Add</button>

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
                <h4 class="modal-title">Add Data</h4>
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
                    <label for="news_desc">Description</label>
                    <textarea class="form-control summernote" id="news_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="news_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="news_image" accept="image/jpeg, image/png">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanNews()">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                <h4 class="modal-title">Edit Data</h4>
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
                    <label for="news_edit_desc">Description</label>
                    <textarea class="form-control summernote" id="news_edit_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="news_edit_image">Image <small>(800x800 px, JPG/PNG, max 1MB) </small> </label>
                    <input type="file" class="form-control" id="news_edit_image" accept="image/jpeg, image/png">
                    <span><a href="" id="news_image_info" target="_blank"></a></span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateNews()">Update</button>
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
        loadLogNews();
        loadNews();
    });

    // Fungsi untuk menambahkan baris baru ke tabel
    function editNews(id) {
        // Mengambil data untuk berita yang dipilih menggunakan Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/news') }}/' + id,
            success: function(response) {
                $('#news_edit_image').val('');
                console.log(response.data);
                var news = response.data;

                // Mengisi field dalam modal edit dengan data yang ada
                $('#news_id').val(news.id);
                $('#news_edit_title').val(news.title);
                $('#news_edit_category').val(news.news_category_id).trigger('change');
                var date = news.date_news;

                // Format tanggal sesuai dengan atribut type="date"
                var formattedDate = new Date(date).toISOString().split('T')[0];
                $('#news_edit_date').val(formattedDate);

                // Mengatur nilai Summernote
                $('#news_edit_desc').summernote('code', news.desc);

                var image = news.image;
                if (image) {
                    $('#news_image_info').attr('href', 'https://s3.indonesiaminer.com/web/' + news.image);
                    $('#news_image_info').text('open link');
                } else {
                    $('#news_image_info').text('');
                }

                // Membuka modal edit
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
        var description = $('#news_edit_desc').summernote('code');
        var imageInput = $('#news_edit_image')[0];

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
        formData.append('id', id);
        formData.append('title', title);
        formData.append('category', category);
        formData.append('description', description);
        formData.append('date', dateNews);

        // Tambahkan data gambar ke formData jika ada
        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax
        $.ajax({
            type: 'POST',
            url: '{{ url('/news') }}/' + id,
            data: formData,
            processData: false, // Penting: mengatur ini ke false sehingga jQuery tidak memproses data
            contentType: false, // Penting: mengatur ini ke false sehingga jQuery tidak menetapkan contentType
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadLogNews();
                loadNews();
                $('#newsEditModal').modal('hide');
                $('.loading-wrapper, .overlay').hide(); // Menyembunyikan loader dan overlay
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function tambahNews() {
        $('#newsModal').modal('show');
    }

    function hapusNews(index) {
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
                    url: '{{ url('/news') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadLogNews();
                        loadNews();
                        $('.loading-wrapper, .overlay').hide();
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
        var desc = $('#news_desc').summernote('code');

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
        formData.append('news_date', newsDate);
        formData.append('desc', desc);

        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        }
        $('.loading-wrapper, .overlay').show();

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
                $('#news_title').val('');
                $('#news_category').val('').trigger('change');
                $('#news_date').val('');
                $('#news_desc').summernote('code', '');
                $('.loading-wrapper, .overlay').hide();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadNews() {
        $('#tabelNews').empty();

        $.ajax({
            type: 'GET',
            url: '{{ url('/news') }}',
            success: function(response) {
                var data = response.data;

                for (var i = 0; i < data.length; i++) {
                    var news = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + news.title + '</td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editNews(' + news.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusNews(' + news.id +
                        ')">Delete</button>' +
                        '</td>' +
                        '</tr>';
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
            url: '{{ url('news/log') }}',
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
                    $('.logger-news').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
