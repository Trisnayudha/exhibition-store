<section id="delegate-pass">
    <h4>Visitor Pass</h4>
    <div class="alert alert-info" role="alert">
        <p>Access to: </p>
        <ul>
            <li>Exhibition</li>
        </ul>
    </div>
    <div class="alert alert-danger" role="alert">
        <p>Only for Mining Companies (Coal & Minerals), Smelter Companies, Power Plant Companies & Mining Contractors
        </p>
        Please Note: Company, Name and Position will be printed on the badge
    </div>
    <div class="logger-mining"></div>
    <button class="btn btn-primary mb-2" onclick="tambahMining()">Add</button>
    <div class="table-responsive">

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tabelMining">
                <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
            </tbody>
        </table>
    </div>
    <!-- Tempelkan kode HTML dari Google Maps di sini -->
</section>


<!-- Modal Part 1 -->
<div class="modal fade" id="miningModal" tabindex="-1" role="dialog" aria-labelledby="addminingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addminingModalLabel">Tambah Working</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="workingForm">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_typeMining" id="company_typeMining"
                                    class="form-control validation" placeholder="Company Type">
                                    <option value="">Choose type</option>
                                    @foreach ($company_type as $c => $crow)
                                        <option @if ($crow->name == 'PT') selected @endif
                                            {{ old('company_type') == $crow->id ? 'selected' : '' }}
                                            value="{{ $crow->id }}">{{ $crow->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-10 col-sm-12">
                                <input type="text" name="companyMining" id="companyMining"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyMining') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_codeMining" id="phone_codeMining" class="form-control validation"
                                    placeholder="Phone code">
                                    <option alue="">Phone code</option>
                                    @foreach ($phone_code as $p => $prow)
                                        <option @if ($prow->code == '62') selected @endif
                                            {{ old('phone_code') == $prow->id ? 'selected' : '' }}
                                            value="{{ $prow->id }}">+{{ $prow->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-10 col-sm-12">
                                <input type="number" name="phoneMining" id="phoneMining"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneMining') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameMining" name="nameMining">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailMining" name="emailMining">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionMining" name="positionMining">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressMining" name="addressMining">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityMining" name="cityMining">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryMining" name="countryMining">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeMining"
                                    name="postalCodeMining">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanMining()">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="miningEditModal" tabindex="-1" role="dialog" aria-labelledby="addminingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addminingModalLabel">Update Mining</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="delegateForm">
                    <input type="hidden" name="mining_id" id="mining_id">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_EdittypeMining" id="company_EdittypeMining"
                                    class="form-control validation" placeholder="Company Type">
                                    <option value="">Choose type</option>
                                    @foreach ($company_type as $c => $crow)
                                        <option @if ($crow->name == 'PT') selected @endif
                                            {{ old('company_type') == $crow->id ? 'selected' : '' }}
                                            value="{{ $crow->id }}">{{ $crow->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-10 col-sm-12">
                                <input type="text" name="companyEditMining" id="companyEditMining"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyEditMining') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_EditcodeMining" id="phone_EditcodeMining"
                                    class="form-control validation" placeholder="Phone code">
                                    <option alue="">Phone code</option>
                                    @foreach ($phone_code as $p => $prow)
                                        <option @if ($prow->code == '62') selected @endif
                                            {{ old('phone_code') == $prow->id ? 'selected' : '' }}
                                            value="{{ $prow->id }}">+{{ $prow->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-10 col-sm-12">
                                <input type="number" name="phoneEditMining" id="phoneEditMining"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneMining') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameEditMining"
                                    name="nameEditMining">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailEditMining"
                                    name="emailEditMining">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionEditMining"
                                    name="positionEditMining">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressEditMining"
                                    name="addressEditMining">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityEditMining"
                                    name="cityEditMining">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryEditMining"
                                    name="countryEditMining">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalEditCodeMining"
                                    name="postalEditCodeMining">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateMining()">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Load data on page load
    $(document).ready(function() {
        loadMining();
        loadLogMining();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editMining(id) {
        // Retrieve data for the selected delegate using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/mining') }}/' + id,
            success: function(response) {
                var mining = response.data;

                // Populate the fields in the edit modal with existing data
                $('#mining_id').val(mining.id);
                $('#company_EdittypeMining').val(mining.ms_company_type_id);
                $('#companyEditMining').val(mining.company_name);
                $('#phone_EditcodeMining').val(mining.ms_phone_code_id);
                $('#phoneEditMining').val(mining.phone);
                $('#nameEditMining').val(mining.name);
                $('#emailEditMining').val(mining.email);
                $('#positionEditMining').val(mining.job_title);
                $('#addressEditMining').val(mining.company_address);
                $('#cityEditMining').val(mining.city);
                $('#countryEditMining').val(mining.country);
                $('#postalEditCodeMining').val(mining.post_code);

                // Open the edit modal
                $('#miningEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateMining() {
        var id = $('#mining_id').val();
        var companyType = $('#company_EdittypeMining').val();
        var companyName = $('#companyEditMining').val();
        var phoneCode = $('#phone_EditcodeMining').val();
        var phoneNumber = $('#phoneEditMining').val();
        var name = $('#nameEditMining').val();
        var email = $('#emailEditMining').val();
        var position = $('#positionEditMining').val();
        var address = $('#addressEditMining').val();
        var city = $('#cityEditMining').val();
        var country = $('#countryEditMining').val();
        var postalCode = $('#postalEditCodeMining').val();

        // Validasi input
        if (!companyType || !companyName || !phoneCode || !phoneNumber || !name || !email || !position) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Harap isi semua kolom yang diperlukan!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Create a JSON object
        var jsonData = {
            id: id,
            ms_company_type_id: companyType,
            company_name: companyName,
            ms_phone_code_id: phoneCode,
            phone: phoneNumber,
            name: name,
            email: email,
            job_title: position,
            company_address: address,
            city: city,
            country: country,
            post_code: postalCode
        };

        // Send data to the server using Ajax
        $.ajax({
            type: 'PUT',
            url: '{{ url('/mining') }}/' + id,
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadMining(); // Aktifkan fungsi untuk memuat data delegate
                loadLogMining(); // Aktifkan fungsi untuk memuat data log delegate
                $('#miningEditModal').modal('hide');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    // Function to open the input modal
    function tambahMining() {
        $('#miningModal').modal('show');
    }

    function hapusMining(index) {
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
                    url: '{{ url('/mining') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadMining();
                        loadLogMining();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanMining() {
        var companyType = $('#company_typeMining').val();
        var companyName = $('#companyMining').val();
        var phoneCode = $('#phone_codeMining').val();
        var phoneNumber = $('#phoneMining').val();
        var name = $('#nameMining').val();
        var email = $('#emailMining').val();
        var position = $('#positionMining').val();
        var address = $('#addressMining').val();
        var city = $('#cityMining').val();
        var country = $('#countryMining').val();
        var postalCode = $('#postalCodeMining').val();

        // Validasi input
        if (!companyType || !companyName || !phoneCode || !phoneNumber || !name || !email || !position) {
            // Menampilkan swal menggunakan Swal 2
            Swal.fire({
                title: 'Peringatan',
                text: 'Harap isi semua kolom yang diperlukan!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var formData = new FormData();
        formData.append('company_type', companyType);
        formData.append('company_name', companyName);
        formData.append('phone_code', phoneCode);
        formData.append('phone', phoneNumber);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('job_title', position);
        formData.append('address', address);
        formData.append('city', city);
        formData.append('country', country);
        formData.append('post_code', postalCode);

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/mining') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadMining();
                loadLogMining();
                $('#miningModal').modal('hide');

                // Membersihkan inputan modal
                $('#company_typeMining').val('');
                $('#companyMining').val('');
                $('#phone_codeMining').val('');
                $('#phoneMining').val('');
                $('#nameMining').val('');
                $('#emailMining').val('');
                $('#positionMining').val('');
                $('#addressMining').val('');
                $('#cityMining').val('');
                $('#countryMining').val('');
                $('#postalCodeMining').val('');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function loadMining() {
        // Clear existing table rows
        $('#tabelMining').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/mining') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = '{{ config('app.image_base_url') }}';

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var representative = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + representative.name + '</td>' +
                        '<td>' + representative.job_title + '</td>' +
                        '<td>' + representative.email + '</td>' +
                        '<td>' + representative.phone + '</td>' +
                        '<td>' + representative.status + '</td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editMining(' + representative.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusMining(' + representative
                        .payment_id +
                        ')">Hapus</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelMining').append(row);
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
