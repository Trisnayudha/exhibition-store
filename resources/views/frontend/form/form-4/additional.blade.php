<section id="delegate-pass">
    <h4>Additional Delegate Pass</h4>
    <div class="alert alert-info" role="alert">
        <p>
            We are offering a special rate for additional delegate passes at USD 400 per person for 3 days. This
            delegate
            pass includes access to the Conference, Exhibition, Networking Functions (Coffee Break & Lunch), and the
            Online
            Networking Function.
        </p>
        <p>
            Please note: this special price applies only to representatives of sponsor/exhibitor companies. and valid
            until
            May 2, 2025. Full payment must be made within 7 days of receiving the invoice.
        </p>
    </div>
    <div class="alert alert-danger" role="alert">
        Please Note: Company, Name and Job Title will be printed on the badge
    </div>
    <div class="logger-additional"></div>
    <button class="btn btn-primary mb-2" onclick="tambahAdditional()">Add</button>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Job Title</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tabelAdditional">
                <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
            </tbody>
        </table>
    </div>

</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="additionalModal" tabindex="-1" role="dialog" aria-labelledby="addadditionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addadditionalModalLabel">Insert additional Delegate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="exhibitorForm">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_typeAdditional" id="company_typeAdditional"
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
                                <input type="text" name="companyAdditional" id="companyAdditional"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyAdditional') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_codeAdditional" id="phone_codeAdditional"
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
                                <input type="number" name="phoneAdditional" id="phoneAdditional"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneAdditional') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameAdditional" name="nameAdditional">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailAdditional" name="emailAdditional">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Job Title</label>
                                <input type="text" class="form-control" id="positionAdditional"
                                    name="positionAdditional">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressAdditional"
                                    name="addressAdditional">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityAdditional" name="cityAdditional">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryAdditional"
                                    name="countryAdditional">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeAdditional"
                                    name="postalCodeAdditional">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanAdditional()">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="additionalEditModal" tabindex="-1" role="dialog"
    aria-labelledby="addadditionalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addadditionalModalLabel">Update additional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="delegateForm">
                    <input type="hidden" name="additional_id" id="additional_id">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_EdittypeAdditional" id="company_EdittypeAdditional"
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
                                <input type="text" name="companyeditAdditional" id="companyEditAdditional"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyEditAdditional') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_EditcodeAdditional" id="phone_EditcodeAdditional"
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
                                <input type="number" name="phoneEditAdditional" id="phoneEditAdditional"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneAdditional') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameEditAdditional"
                                    name="nameEditAdditional">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailEditAdditional"
                                    name="emailEditAdditional">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Job Title</label>
                                <input type="text" class="form-control" id="job_titleEditAdditional"
                                    name="job_titleEditAdditional">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressEditAdditional"
                                    name="addressEditAdditional">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityEditAdditional"
                                    name="cityEditAdditional">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryEditAdditional"
                                    name="countryEditAdditional">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalEditCodeAdditional"
                                    name="postalEditCodeAdditional">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateAdditional()">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Load data on page load
    $(document).ready(function() {
        loadAdditional();
        loadLogAdditional();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editAdditional(id) {
        // Retrieve data for the selected delegate using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/additional') }}/' + id,
            success: function(response) {
                var additional = response.data;

                // Populate the fields in the edit modal with existing data
                $('#additional_id').val(additional.id);
                $('#company_EdittypeAdditional').val(additional.ms_company_type_id);
                $('#companyEditAdditional').val(additional.company_name);
                $('#phone_EditcodeAdditional').val(additional.ms_phone_code_id);
                $('#phoneEditAdditional').val(additional.phone);
                $('#nameEditAdditional').val(additional.name);
                $('#emailEditAdditional').val(additional.email);
                $('#job_titleEditAdditional').val(additional.job_title);
                $('#addressEditAdditional').val(additional.company_address);
                $('#cityEditAdditional').val(additional.city);
                $('#countryEditAdditional').val(additional.country);
                $('#postalEditCodeAdditional').val(additional.post_code);

                // Open the edit modal
                $('#additionalEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateAdditional() {
        var id = $('#additional_id').val();
        var companyType = $('#company_EdittypeAdditional').val();
        var companyName = $('#companyEditAdditional').val();
        var phoneCode = $('#phone_EditcodeAdditional').val();
        var phoneNumber = $('#phoneEditAdditional').val();
        var name = $('#nameEditAdditional').val();
        var email = $('#emailEditAdditional').val();
        var position = $('#job_titleEditAdditional').val();
        var address = $('#addressEditAdditional').val();
        var city = $('#cityEditAdditional').val();
        var country = $('#countryEditAdditional').val();
        var postalCode = $('#postalEditCodeAdditional').val();

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
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Send data to the server using Ajax
        $.ajax({
            type: 'PUT',
            url: '{{ url('/additional') }}/' + id,
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadAdditional(); // Aktifkan fungsi untuk memuat data delegate
                loadLogAdditional(); // Aktifkan fungsi untuk memuat data log delegate
                $('#additionalEditModal').modal('hide');
                loadCart();
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    /* ---------- Additional Delegate Pass Functions ---------- */

    // Function to request edit for Additional Delegate Pass
    function requestEditAdditional(id) {
        requestEdit(id, 'additional');
    }
    // Function to open the input modal
    function tambahAdditional() {
        console.log('tambah');
        $('#additionalModal').modal('show');
    }

    function hapusAdditional(index) {
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
                    url: '{{ url('/additional') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadCart();
                        loadAdditional();
                        loadLogAdditional();
                        $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanAdditional() {
        const companyType = $('#company_typeAdditional').val();
        const companyName = $('#companyAdditional').val();
        const phoneCode = $('#phone_codeAdditional').val();
        const phoneNumber = $('#phoneAdditional').val();
        const name = $('#nameAdditional').val();
        const email = $('#emailAdditional').val();
        const position = $('#positionAdditional').val();
        const address = $('#addressAdditional').val();
        const city = $('#cityAdditional').val();
        const country = $('#countryAdditional').val();
        const postalCode = $('#postalCodeAdditional').val();
        // Optional: if you send events_id from the form
        const eventsId = $('#eventsIdAdditional')
            .val(); // e.g. <input type="hidden" id="eventsIdAdditional" value="14" />

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
        if (eventsId) formData.append('events_id', eventsId);

        $('.loading-wrapper, .overlay').show();

        $.ajax({
                type: 'POST',
                url: '/additional',
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
                    text: res?.message || 'The additional delegate has been added successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });

                loadAdditional();
                loadLogAdditional();
                $('#additionalModal').modal('hide');

                // Clear inputs (Additional form)
                $('#company_typeAdditional').val('');
                $('#companyAdditional').val('');
                $('#phone_codeAdditional').val('');
                $('#phoneAdditional').val('');
                $('#nameAdditional').val('');
                $('#emailAdditional').val('');
                $('#positionAdditional').val('');
                $('#addressAdditional').val('');
                $('#cityAdditional').val('');
                $('#countryAdditional').val('');
                $('#postalCodeAdditional').val('');

                // If backend returns payment & user, keep this
                if (typeof delegateCart === 'function') {
                    try {
                        delegateCart(res?.data?.payment || res?.payment, res?.data?.user || res?.user);
                    } catch (e) {}
                }
            })
            .fail(function(xhr) {
                const status = xhr.status;
                let msg = 'An unexpected error occurred. Please try again later.';

                if (status === 0) {
                    msg = 'Network error. Please check your internet connection.';
                } else if (status === 422) {
                    const r = xhr.responseJSON || {};
                    if (r.errors && typeof r.errors === 'object') {
                        const messages = Object.values(r.errors).flat().slice(0, 3).join(' ');
                        msg = messages || r.message || 'Some fields are invalid. Please review your input.';
                    } else {
                        msg = r.message || 'Some fields are invalid. Please review your input.';
                    }
                } else if (status === 409) {
                    msg = (xhr.responseJSON && xhr.responseJSON.message) ||
                        'This email is already associated with an active delegate for this event under your company.';
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


    // Function to load Additional Delegates
    function loadAdditional() {
        // Clear existing table rows
        $('#tabelAdditional').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/additional') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;

                // Get the image base URL from the configuration
                var imageBaseUrl = '{{ config('app.image_base_url') }}';
                var accessData = {{ $access['delegate_pass'] }}; // Adjust if necessary

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var additional = data[i];
                    var isEditApproved = additional.edit_approved; // Ensure backend provides this field

                    // Determine which buttons to show based on 'edit_approved' status
                    var buttons = '';

                    if (isEditApproved) {
                        // If edit is approved, show only the "Edit" button
                        buttons += '<button class="btn btn-info mr-2" onclick="editAdditional(' + additional
                            .id + ')">Edit</button>';
                    } else {
                        // If edit is not approved, show "Request Edit" and disable "Edit" button
                        buttons += '<button class="btn btn-warning mr-2" onclick="requestEditAdditional(' +
                            additional.id + ')">Request Edit</button>';
                        buttons += '<button class="btn btn-info mr-2" onclick="editAdditional(' + additional
                            .id + ')" disabled>Edit</button>';
                    }

                    // Add the "Delete" button
                    buttons += '<button class="btn btn-danger" onclick="hapusAdditional(' + additional.id +
                        ')">Delete</button>';

                    // Optional: Add status indicator
                    var statusIndicator = isEditApproved ?
                        '<span class="badge badge-success ml-2">Edit Approved</span>' :
                        '<span class="badge badge-warning ml-2">Edit Pending</span>';

                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + additional.name + '</td>' +
                        '<td>' + additional.job_title + '</td>' +
                        '<td>' + additional.email + '</td>' +
                        '<td>' + additional.phone + '</td>' +
                        '<td>' + additional.status + '</td>' +
                        '<td>' + buttons + '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelAdditional').append(row);
                }

                // Control the "Add" button based on additional delegate pass access
                if (accessData <= data.length) {
                    console.log(data.length);
                    $('#additionalButton').prop('disabled',
                        true); // Ensure you have an 'additionalButton' if needed
                } else {
                    $('#additionalButton').prop('disabled', false);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function loadLogAdditional() {
        $.ajax({
            type: 'GET',
            url: '{{ url('additional/log') }}', // Ganti dengan URL API yang sesuai
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
                    $('.logger-additional').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function requestEditAdditional(id) {
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
                        loadAdditional(); // Reload the additional table to update button statuses
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
