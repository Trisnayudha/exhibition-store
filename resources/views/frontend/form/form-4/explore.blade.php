<section id="delegate-pass">
    <h4>Explore Pass</h4>
    <div class="alert alert-info" role="alert">
        <p>Planning to bring someone from your network such as a business partner, agent, or principal to the Indonesia
            Miner Conference & Exhibition 2026?
        </p>

        <p>Provide their details here. We'll issue them an Explore Pass, which provides 3-day access to the exhibition
            area only. This pass does not include entry to conference sessions or networking functions such as coffee
            breaks and lunch.
        </p>
    </div>
    <div class="alert alert-danger" role="alert">
        Please Note: Company, Name and Job Title will be printed on the badge
    </div>
    <div class="logger-explore"></div>
    <button class="btn btn-primary mb-2" onclick="tambahExplore()">Upload Data</button>
    <div class="table-responsive">

        <table class="table">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody id="tabelExplore">
                <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
            </tbody>
        </table>
    </div>
    @if (!empty($progress))
        <div class="mt-5">
            <h2>Progress Reporting Explore Pass</h2>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Last update :
                <strong>
                    {{ optional($progress->updated_at)->format('d F Y, g:i A') }} GMT + 7
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! $progress->link !!}
        </div>
    @endif
    {{-- <div class="mt-5">
        <p>Progress Reporting Mining Pass</p>
        <iframe id="myIframe"
            src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRtK2jJn6iCoJ9-g9GnUO0WXg6mBpBjLhBAXVh6vKhMhI_BMmOIOni19KKmSm-rsycDAE_2PVJgUcmB/pubhtml?widget=true&amp;headers=false"></iframe>
    </div> --}}
    <!-- Tempelkan kode HTML dari Google Maps di sini -->
</section>


<!-- Modal Part 1 -->
<div class="modal fade" id="exploreModal" tabindex="-1" role="dialog" aria-labelledby="addexploreModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addexploreModalLabel">Add Explore Pass</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="workingForm">
                    <div class="alert alert-danger" role="alert">
                        <p>Please Note: Before uploading an Excel file, make sure to use the provided Excel file
                            template.</p>

                        <a href="{{ asset('form4/IM2026_Explore_Invitation.xlsx') }}" class="btn btn-info text-white"
                            download>EXCEL TEMPLATE: access here</a>
                    </div>
                    <div class="form-group">
                        <input type="file" name="file_excel" id="file_excel" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanMining()">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Load data on page load
    $(document).ready(function() {
        loadExplore();
        loadLogExplore();
    });

    // Function to open the input modal
    function tambahExplore() {
        $('#exploreModal').modal('show');
    }

    function hapusExplore(index) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Konfirmasi pengguna sebelum menghapus
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data representative akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan penghapusan ke server menggunakan Ajax
                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('/explore') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadExplore();
                        loadLogExplore();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanExplore() {
        // File Excel yang dipilih
        var fileInput = $('#file_excel')[0].files[0];

        // Validasi file Excel harus dipilih
        if (!fileInput) {
            // Menampilkan swal menggunakan Swal 2
            Swal.fire({
                title: 'Peringatan',
                text: 'Harap pilih file Excel yang akan diunggah!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        var formData = new FormData();
        formData.append('file_excel', fileInput); // Menambahkan file Excel

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/explore') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadExplore();
                loadLogExplore();
                $('#miningModal').modal('hide');

                // Membersihkan inputan modal
                $('#file_excel').val(''); // Menghapus file input
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }



    function loadExplore() {
        // Clear existing table rows
        $('#tabelExplore').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/explore') }}', // Replace with the correct API URL
            success: function(response) {
                var data = response.data;

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var fileData = data[i];

                    // Extract the filename by splitting the path and getting the last part
                    var fileNameParts = fileData.file.split(
                        '/'); // assuming the file path is separated by '/'
                    var fileName = fileNameParts[fileNameParts.length - 1]; // get the last part after split

                    // Convert created_at to a Date object
                    var date = new Date(fileData.created_at);

                    // Format date into a human-readable format
                    var formattedDate = date.toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });

                    // Create download URL by concatenating base URL and filename
                    var downloadUrl = '{{ url('storage/excel_company') }}/' + fileName;

                    // Create table row with the desired file name and formatted date
                    var row = '<tr>' +
                        '<td><a href="' + downloadUrl + '" download>' + fileName +
                        '</a></td>' +
                        '<td>' + formattedDate + '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelExplore').append(row);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }





    function loadLogMining() {
        $.ajax({
            type: 'GET',
            url: '{{ url('mining/log') }}', // Ganti dengan URL API yang sesuai
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

                    // Tampilkan elemen div dalam elemen dengan class "logger-mining"
                    $('.logger-mining').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
