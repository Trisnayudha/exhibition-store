<section id="delegate-pass">
    <h4>Delegate Pass</h4>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        You Have {{ $access['delegate_pass'] }} Delegate Pass
        <p>Access to: </p>
        <ul>
            <li>Conference</li>
            <li>Exhibition</li>
            <li>Networking Functions</li>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Please Note: Company, Name and Position will be printed on the badge
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="logger-delegate"></div>
    <button class="btn btn-primary mb-2" onclick="tambahDelegate()" id="delegateButton">Add</button>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tabelDelegate">
                <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="delegateModal" tabindex="-1" role="dialog" aria-labelledby="addDelegateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDelegateModalLabel">Add Delegate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="delegateForm">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_typeDelegate" id="company_typeDelegate"
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
                                <input type="text" name="companyDelegate" id="companyDelegate"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyDelegate') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_codeDelegate" id="phone_codeDelegate"
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
                                <input type="number" name="phoneDelegate" id="phoneDelegate"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneDelegate') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameDelegate" name="nameDelegate">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailDelegate" name="emailDelegate">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionDelegate"
                                    name="positionDelegate">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressDelegate"
                                    name="addressDelegate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityDelegate" name="cityDelegate">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryDelegate"
                                    name="countryDelegate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeDelegate"
                                    name="postalCodeDelegate">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanDelegate()">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="delegateEditModal" tabindex="-1" role="dialog"
    aria-labelledby="addDelegateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDelegateModalLabel">Update Delegate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="delegateForm">
                    <input type="hidden" name="delegate_id" id="delegate_id">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_EdittypeDelegate" id="company_EdittypeDelegate"
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
                                <input type="text" name="companyEditDelegate" id="companyEditDelegate"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyEditDelegate') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_EditcodeDelegate" id="phone_EditcodeDelegate"
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
                                <input type="number" name="phoneEditDelegate" id="phoneEditDelegate"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneDelegate') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameEditDelegate"
                                    name="nameEditDelegate">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailEditDelegate"
                                    name="emailEditDelegate">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionEditDelegate"
                                    name="positionEditDelegate">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressEditDelegate"
                                    name="addressEditDelegate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityEditDelegate"
                                    name="cityEditDelegate">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryEditDelegate"
                                    name="countryEditDelegate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalEditCodeDelegate"
                                    name="postalEditCodeDelegate">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateDelegate()">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Load data on page load
    $(document).ready(function() {
        loadDelegate();
        loadLogDelegate();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editDelegate(id) {
        // Retrieve data for the selected delegate using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/delegate') }}/' + id,
            success: function(response) {
                var delegate = response.data;

                // Populate the fields in the edit modal with existing data
                $('#delegate_id').val(delegate.id);
                $('#company_EdittypeDelegate').val(delegate.ms_company_type_id);
                $('#companyEditDelegate').val(delegate.company_name);
                $('#phone_EditcodeDelegate').val(delegate.ms_phone_code_id);
                $('#phoneEditDelegate').val(delegate.phone);
                $('#nameEditDelegate').val(delegate.name);
                $('#emailEditDelegate').val(delegate.email);
                $('#positionEditDelegate').val(delegate.job_title);
                $('#addressEditDelegate').val(delegate.company_address);
                $('#cityEditDelegate').val(delegate.city);
                $('#countryEditDelegate').val(delegate.country);
                $('#postalEditCodeDelegate').val(delegate.post_code);

                // Open the edit modal
                $('#delegateEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateDelegate() {
        var id = $('#delegate_id').val();
        var companyType = $('#company_EdittypeDelegate').val();
        var companyName = $('#companyEditDelegate').val();
        var phoneCode = $('#phone_EditcodeDelegate').val();
        var phoneNumber = $('#phoneEditDelegate').val();
        var name = $('#nameEditDelegate').val();
        var email = $('#emailEditDelegate').val();
        var position = $('#positionEditDelegate').val();
        var address = $('#addressEditDelegate').val();
        var city = $('#cityEditDelegate').val();
        var country = $('#countryEditDelegate').val();
        var postalCode = $('#postalEditCodeDelegate').val();

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
            url: '{{ url('/delegate') }}/' + id,
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadDelegate(); // Aktifkan fungsi untuk memuat data delegate
                loadLogDelegate(); // Aktifkan fungsi untuk memuat data log delegate
                $('#delegateEditModal').modal('hide');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    // Function to open the input modal
    function tambahDelegate() {
        console.log('tambah');
        $('#delegateModal').modal('show');
    }

    function hapusDelegate(index) {
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
                    url: '{{ url('/delegate') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadDelegate();
                        loadLogDelegate();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanDelegate() {
        var companyType = $('#company_typeDelegate').val();
        var companyName = $('#companyDelegate').val();
        var phoneCode = $('#phone_codeDelegate').val();
        var phoneNumber = $('#phoneDelegate').val();
        var name = $('#nameDelegate').val();
        var email = $('#emailDelegate').val();
        var position = $('#positionDelegate').val();
        var address = $('#addressDelegate').val();
        var city = $('#cityDelegate').val();
        var country = $('#countryDelegate').val();
        var postalCode = $('#postalCodeDelegate').val();

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
            url: '{{ url('/delegate') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadDelegate();
                loadLogDelegate();
                $('#delegateModal').modal('hide');

                // Membersihkan inputan modal
                $('#company_typeDelegate').val('');
                $('#companyDelegate').val('');
                $('#phone_codeDelegate').val('');
                $('#phoneDelegate').val('');
                $('#nameDelegate').val('');
                $('#emailDelegate').val('');
                $('#positionDelegate').val('');
                $('#addressDelegate').val('');
                $('#cityDelegate').val('');
                $('#countryDelegate').val('');
                $('#postalCodeDelegate').val('');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function loadDelegate() {
        // Clear existing table rows
        $('#tabelDelegate').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/delegate') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = '{{ config('app.image_base_url') }}';
                var accessData = {{ $access['delegate_pass'] }}
                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var representative = data[i];
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + representative.name + '</td>' +
                        '<td>' + representative.job_title + '</td>' +
                        '<td>' + representative.email + '</td>' +
                        '<td>' + representative.phone + '</td>' +
                        // '<td>' + representative.status + '</td>' +
                        '<td>' +
                        '<button class="btn btn-info" onclick="editDelegate(' + representative.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusDelegate(' + representative
                        .payment_id +
                        ')">Hapus</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelDelegate').append(row);
                }
                if (accessData <= data.length) {
                    console.log(data.length);
                    // Disable the button or show a notification
                    $('#delegateButton').prop('disabled', true);
                    // You can also display a notification here
                    // Example: $('#notification').text('You cannot add more data.').show();
                } else {
                    $('#delegateButton').prop('disabled', false);

                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogDelegate() {
        $.ajax({
            type: 'GET',
            url: '{{ url('delegate/log') }}', // Ganti dengan URL API yang sesuai
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

                    // Tampilkan elemen div dalam elemen dengan class "logger-delegate"
                    $('.logger-delegate').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
