<section id="delegate-pass">
    <h4>Working Pass (Only If Needed)</h4>
    <div class="alert alert-info" role="alert">
        Based on your
        {{ $data->level == 'exhibition' ? 'exhibiting' : ($data->level == 'sponsor' ? 'sponsorship' : 'exhibiting & sponsorship') }}
        package, you are entitled to
        {{ $access['working_pass'] }} working
        {{ $access['working_pass'] >= 2 ? 'passes' : 'pass' }}.
        This working {{ $access['working_pass'] >= 2 ? 'passes' : 'pass' }} includes:
        <ul>
            <li>Working pass is only valid during the setup and dismantling period</li>
            <li>Working pass can only be obtained by exchanging the ID Card (KTP/SIM/Passport)</li>
            <li>Please ensure that badges are returned to the registration area after the setup and dismantling days in
                order to get your ID card back</li>
        </ul>
    </div>
    <div class="alert alert-danger" role="alert">
        Please Note: Company, Name and Job Title will be printed on the badge
    </div>
    <div class="logger-working"></div>
    <button class="btn btn-primary mb-2" onclick="tambahWorking()" id="workingButton">Add</button>
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
            <tbody id="tabelWorking">
                <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
            </tbody>
        </table>
    </div>

</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="workingModal" tabindex="-1" role="dialog" aria-labelledby="addworkingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addworkingModalLabel">Add Working Pass</h5>
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
                                <select name="company_typeWorking" id="company_typeWorking"
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
                                <input type="text" name="companyWorking" id="companyWorking"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyWorking') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_codeWorking" id="phone_codeWorking" class="form-control validation"
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
                                <input type="number" name="phoneWorking" id="phoneWorking"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneWorking') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameWorking" name="nameWorking">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailWorking" name="emailWorking">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Job Title</label>
                                <input type="text" class="form-control" id="positionWorking" name="positionWorking">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressWorking" name="addressWorking">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityWorking" name="cityWorking">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryWorking"
                                    name="countryWorking">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeWorking"
                                    name="postalCodeWorking">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanWorking()">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="workingEditModal" tabindex="-1" role="dialog" aria-labelledby="addworkingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addworkingModalLabel">Update Working Pass</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="delegateForm">
                    <input type="hidden" name="working_id" id="working_id">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_EdittypeWorking" id="company_EdittypeWorking"
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
                                <input type="text" name="companyEditWorking" id="companyEditWorking"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyEditWorking') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_EditcodeWorking" id="phone_EditcodeWorking"
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
                                <input type="number" name="phoneEditWorking" id="phoneEditWorking"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneWorking') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameEditWorking"
                                    name="nameEditWorking">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailEditWorking"
                                    name="emailEditWorking">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Job Title</label>
                                <input type="text" class="form-control" id="positionEditWorking"
                                    name="positionEditWorking">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressEditWorking"
                                    name="addressEditWorking">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityEditWorking"
                                    name="cityEditWorking">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryEditWorking"
                                    name="countryEditWorking">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalEditCodeWorking"
                                    name="postalEditCodeWorking">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateWorking()">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Load data on page load
    $(document).ready(function() {
        loadWorking();
        loadLogWorking();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editWorking(id) {
        // Retrieve data for the selected delegate using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/working') }}/' + id,
            success: function(response) {
                var working = response.data;

                // Populate the fields in the edit modal with existing data
                $('#working_id').val(working.id);
                $('#company_EdittypeWokring').val(working.ms_company_type_id);
                $('#companyEditWorking').val(working.company_name);
                $('#phone_EditcodeWorking').val(working.ms_phone_code_id);
                $('#phoneEditWorking').val(working.phone);
                $('#nameEditWorking').val(working.name);
                $('#emailEditWorking').val(working.email);
                $('#positionEditWorking').val(working.job_title);
                $('#addressEditWorking').val(working.company_address);
                $('#cityEditWorking').val(working.city);
                $('#countryEditWorking').val(working.country);
                $('#postalEditCodeWorking').val(working.post_code);

                // Open the edit modal
                $('#workingEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateWorking() {
        var id = $('#working_id').val();
        var companyType = $('#company_EdittypeWorking').val();
        var companyName = $('#companyEditWorking').val();
        var phoneCode = $('#phone_EditcodeWorking').val();
        var phoneNumber = $('#phoneEditWorking').val();
        var name = $('#nameEditWorking').val();
        var email = $('#emailEditWorking').val();
        var position = $('#positionEditWorking').val();
        var address = $('#addressEditWorking').val();
        var city = $('#cityEditWorking').val();
        var country = $('#countryEditWorking').val();
        var postalCode = $('#postalEditCodeWorking').val();

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
            url: '{{ url('/working') }}/' + id,
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadWorking(); // Aktifkan fungsi untuk memuat data delegate
                loadLogWorking(); // Aktifkan fungsi untuk memuat data log delegate
                $('#workingEditModal').modal('hide');
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
    // Function to request edit for Working Pass
    function requestEditWorking(id) {
        requestEdit(id, 'working');
    }

    // Function to open the input modal
    function tambahWorking() {
        $('#workingModal').modal('show');
    }

    function hapusWorking(index) {
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
                    url: '{{ url('/working') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadWorking();
                        loadLogWorking();
                        $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanWorking() {
        var companyType = $('#company_typeWorking').val();
        var companyName = $('#companyWorking').val();
        var phoneCode = $('#phone_codeWorking').val();
        var phoneNumber = $('#phoneWorking').val();
        var name = $('#nameWorking').val();
        var email = $('#emailWorking').val();
        var position = $('#positionWorking').val();
        var address = $('#addressWorking').val();
        var city = $('#cityWorking').val();
        var country = $('#countryWorking').val();
        var postalCode = $('#postalCodeWorking').val();

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
        $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay

        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/working') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadWorking();
                loadLogWorking();
                $('#workingModal').modal('hide');

                // Membersihkan inputan modal
                $('#company_typeWorking').val('');
                $('#companyWorking').val('');
                $('#phone_codeWorking').val('');
                $('#phoneWorking').val('');
                $('#nameWorking').val('');
                $('#emailWorking').val('');
                $('#positionWorking').val('');
                $('#addressWorking').val('');
                $('#cityWorking').val('');
                $('#countryWorking').val('');
                $('#postalCodeWorking').val('');
                $('.loading-wrapper, .overlay').hide(); // Menampilkan loader dan overlay

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    /* ---------- Loading Functions with Conditional Button Rendering ---------- */

    // Function to load Working Passes
    function loadWorking() {
        // Clear existing table rows
        $('#tabelWorking').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/working') }}', // Replace with the actual API URL
            success: function(response) {
                var data = response.data;
                var accessData = {{ $access['working_pass'] }};

                // Iterate through the data and append rows to the table
                for (var i = 0; i < data.length; i++) {
                    var working = data[i];
                    var isEditApproved = working
                        .edit_approved; // Ensure 'edit_approved' is provided by backend

                    // Determine which buttons to show based on 'edit_approved' status
                    var buttons = '';

                    if (isEditApproved) {
                        // If edit is approved, show only the "Edit" button
                        buttons += '<button class="btn btn-info mr-2" onclick="editWorking(' + working.id +
                            ')">Edit</button>';
                    } else {
                        // If edit is not approved, show "Request Edit" and disable "Edit" button
                        buttons += '<button class="btn btn-warning mr-2" onclick="requestEditWorking(' +
                            working.id + ')">Request Edit</button>';
                        buttons += '<button class="btn btn-info mr-2" onclick="editWorking(' + working.id +
                            ')" disabled>Edit</button>';
                    }

                    // Add the "Delete" button
                    buttons += '<button class="btn btn-danger" onclick="hapusWorking(' + working.id +
                        ')">Delete</button>';

                    // Add status indicator
                    var statusIndicator = isEditApproved ?
                        '<span class="badge badge-success ml-2">Edit Approved</span>' :
                        '<span class="badge badge-warning ml-2">Edit Pending</span>';

                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + working.name + '</td>' +
                        '<td>' + working.job_title + '</td>' +
                        '<td>' + working.email + '</td>' +
                        '<td>' + working.phone + '</td>' +
                        '<td>' + working.status + '</td>' +
                        '<td>' + buttons + '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelWorking').append(row);
                }

                // Control the "Add" button based on working pass access
                if (accessData <= data.length) {
                    console.log(data.length);
                    $('#workingButton').prop('disabled', true);
                    Swal.fire({
                        title: 'Limit Reached',
                        text: 'You have reached the maximum number of Working Passes.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#workingButton').prop('disabled', false);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogWorking() {
        $.ajax({
            type: 'GET',
            url: '{{ url('working/log') }}', // Ganti dengan URL API yang sesuai
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

                    // Tampilkan elemen div dalam elemen dengan class "logger-working"
                    $('.logger-working').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    /* ---------- Unified Edit Request Function ---------- */

    // Unified Function to handle edit requests for Delegate, Additional Delegate, and Working Pass
    function requestEdit(id, type) {
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
                    url: '{{ url('/delegate/request-edit') }}', // Unified endpoint
                    data: {
                        delegate_id: id,
                        type: type, // Specify the type: 'delegate', 'additional', or 'working'
                        _token: csrfToken
                    },
                    success: function(response) {
                        Swal.fire(
                            'Request Sent!',
                            'Your edit request has been sent and is being processed.',
                            'success'
                        );
                        if (type === 'delegate') {
                            loadDelegate(); // Reload delegate table to update button statuses
                        } else if (type === 'additional') {
                            loadAdditional(); // Reload additional delegate table
                        } else if (type === 'working') {
                            loadWorking(); // Reload working pass table
                        }
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
