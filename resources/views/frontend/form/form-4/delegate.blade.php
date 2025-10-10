<section id="delegate-pass">
    <h4>Delegate Pass</h4>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        Based on your
        {{ $data->level == 'exhibition' ? 'exhibiting' : ($data->level == 'sponsor' ? 'sponsorship' : 'exhibiting & sponsorship') }}
        package, you are entitled to
        {{ $access['delegate_pass'] }} delegate
        {{ $access['delegate_pass'] >= 2 ? 'passes' : 'pass' }}.
        This delegate {{ $access['delegate_pass'] >= 2 ? 'passes' : 'pass' }} includes:
        <ul>
            <li>Conference</li>
            <li>Exhibition</li>
            <li>Networking Functions (Coffee Break & Lunch)</li>
            <li>Online Networking Function</li>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Please Note: Company, Name and Job Title will be printed on the badge
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
                    <th>Job Title</th>
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
                                <label for="position">Job Title</label>
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
                                <label for="position">Job Title</label>
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
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

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
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

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
                $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

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
                        $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanDelegate() {
        const companyType = $('#company_typeDelegate').val();
        const companyName = $('#companyDelegate').val();
        const phoneCode = $('#phone_codeDelegate').val();
        const phoneNumber = $('#phoneDelegate').val();
        const name = $('#nameDelegate').val();
        const email = $('#emailDelegate').val();
        const position = $('#positionDelegate').val();
        const address = $('#addressDelegate').val();
        const city = $('#cityDelegate').val();
        const country = $('#countryDelegate').val();
        const postalCode = $('#postalCodeDelegate').val();

        // Basic validation (client-side)
        if (!companyType || !companyName || !phoneCode || !phoneNumber || !name || !email || !position) {
            Swal.fire({
                title: 'Incomplete Information',
                text: 'Please fill out all required fields before submitting.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        const formData = new FormData();
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

        $('.loading-wrapper, .overlay').show();

        $.ajax({
                type: 'POST',
                url: '/delegate',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'json'
            })
            .done(function(res) {
                Swal.fire({
                    title: 'Saved Successfully',
                    text: res?.message || 'The delegate has been added successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });

                loadDelegate();
                loadLogDelegate();
                $('#delegateModal').modal('hide');

                // Clear inputs only on success
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
            })
            .fail(function(xhr) {
                const status = xhr.status;
                let msg = 'An unexpected error occurred. Please try again later.';

                if (status === 0) {
                    msg = 'Network error. Please check your internet connection.';
                } else if (status === 422) {
                    // Laravel validation error
                    const r = xhr.responseJSON || {};
                    if (r.errors && typeof r.errors === 'object') {
                        // Combine first few messages for clarity
                        const messages = Object.values(r.errors)
                            .flat()
                            .slice(0, 3)
                            .join(' ');
                        msg = messages || r.message || 'Some fields are invalid. Please review your input.';
                    } else {
                        msg = r.message || 'Some fields are invalid. Please review your input.';
                    }
                } else if (status === 409) {
                    // Conflict: duplicate email/payment etc.
                    msg = (xhr.responseJSON && xhr.responseJSON.message) ||
                        'This email is already associated with an existing delegate. Please use a different email.';
                } else if (status === 401 || status === 403) {
                    msg = 'You are not authorized to perform this action. Please sign in again.';
                } else if (status >= 500) {
                    msg = (xhr.responseJSON && xhr.responseJSON.message) ||
                        'A server error occurred. Please contact support if the issue persists.';
                } else {
                    msg = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) || msg;
                }

                Swal.fire({
                    title: 'Save Failed',
                    text: msg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            })
            .always(function() {
                $('.loading-wrapper, .overlay').hide();
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
                var accessData = {{ $access['delegate_pass'] }};

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var representative = data[i];
                    var isEditApproved = representative
                        .edit_approved; // Asumsikan ada field 'edit_approved' dari backend

                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + representative.name + '</td>' +
                        '<td>' + representative.job_title + '</td>' +
                        '<td>' + representative.email + '</td>' +
                        '<td>' + representative.phone + '</td>' +
                        // '<td>' + representative.status + '</td>' +
                        '<td>' +
                        '<button class="btn btn-warning mr-2" onclick="requestEditDelegate(' +
                        representative.id + ')">Request Edit</button>' +
                        '<button class="btn btn-info" onclick="editDelegate(' + representative.id + ')" ' +
                        (isEditApproved ? '' : 'disabled') + '>Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusDelegate(' + representative.id +
                        ')">Hapus</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelDelegate').append(row);
                }
                if (accessData <= data.length) {
                    console.log(data.length);
                    // Disable the add button or show a notification
                    $('#delegateButton').prop('disabled', true);
                } else {
                    $('#delegateButton').prop('disabled', false);
                }
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
                var accessData = {{ $access['delegate_pass'] }};

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var representative = data[i];
                    var isEditApproved = representative.edit_approved;

                    // Determine which buttons to show based on 'edit_approved' status
                    var buttons = '';

                    if (isEditApproved) {
                        // If edit is approved, show only the "Edit" button
                        buttons += '<button class="btn btn-info" onclick="editDelegate(' + representative
                            .id + ')">Edit</button> ';
                    } else {
                        // If edit is not approved, show "Request Edit" and disable "Edit" button
                        buttons += '<button class="btn btn-warning mr-2" onclick="requestEditDelegate(' +
                            representative.id + ')">Request Edit</button>';
                        buttons += '<button class="btn btn-info" onclick="editDelegate(' + representative
                            .id + ')" disabled>Edit</button> ';
                    }

                    // Add the "Delete" button
                    buttons += '<button class="btn btn-danger" onclick="hapusDelegate(' + representative
                        .id + ')">Delete</button>';



                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + representative.name + '</td>' +
                        '<td>' + representative.job_title + '</td>' +
                        '<td>' + representative.email + '</td>' +
                        '<td>' + representative.phone + '</td>' +
                        '<td>' + buttons + '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelDelegate').append(row);
                }

                // Control the "Add" button based on delegate pass access
                if (accessData <= data.length) {
                    console.log(data.length);
                    $('#delegateButton').prop('disabled', true);
                } else {
                    $('#delegateButton').prop('disabled', false);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function requestEditDelegate(id) {
        Swal.fire({
            title: 'Do you want to send an edit request?',
            text: "Your request will be sent for approval.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, send it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Send the edit request to the server using Ajax
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/delegate/request-edit') }}', // Endpoint to send the edit request
                    data: {
                        delegate_id: id,
                        _token: csrfToken
                    },
                    success: function(response) {
                        Swal.fire(
                            'Request Sent!',
                            'Your edit request has been sent and is being processed.',
                            'success'
                        );
                        loadDelegate(); // Reload the delegate table to update button statuses
                    },
                    error: function(error) {
                        Swal.fire(
                            'Failed!',
                            'An error occurred while sending the edit request.',
                            'error'
                        );
                        console.error('Error:', error);
                    }
                });
            }
        });
    }
</script>
