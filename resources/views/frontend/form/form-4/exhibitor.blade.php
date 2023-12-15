<section id="exhibitor-pass">
    <h4>Exhibitor Pass</h4>
    <div class="alert alert-info" role="alert">
        You Have 4 Exhibitor Pass
        <p>Access to</p>
        <ul>
            <li>Exhibition</li>
            <li>Online Networking Platform</li>
        </ul>
    </div>
    <div class="alert alert-danger" role="alert">
        <p>Upgrade your Exhibitor Pass to Delegate Pass for USD 280 / Pax / 3 Days with the inclusion access to:
            Conference, Exhibition, Networking Functions</p>
        Please Note: Company, Name and Position will be printed on the badge
    </div>
    <div class="logger-exhibitor"></div>
    <button class="btn btn-primary mb-2" onclick="tambahExhibitor()">Tambah</button>
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
            <tbody id="tabelExhibitor">
                <!-- Isi tabel akan ditambahkan secara dinamis di sini -->
            </tbody>
        </table>
    </div>

</section>

<!-- Modal Part 1 -->
<div class="modal fade" id="exhibitorModal" tabindex="-1" role="dialog" aria-labelledby="addExhibitorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExhibitorModalLabel">Tambah Exhibitor</h5>
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
                                <select name="company_typeExhibitor" id="company_typeExhibitor"
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
                                <input type="text" name="companyExhibitor" id="companyExhibitor"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyExhibitor') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_codeExhibitor" id="phone_codeExhibitor"
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
                                <input type="number" name="phoneExhibitor" id="phoneExhibitor"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneExhibitor') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameExhibitor" name="nameExhibitor">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailExhibitor" name="emailExhibitor">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="positionExhibitor"
                                    name="positionExhibitor">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressExhibitor"
                                    name="addressExhibitor">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityExhibitor" name="cityExhibitor">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryExhibitor"
                                    name="countryExhibitor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalCodeExhibitor"
                                    name="postalCodeExhibitor">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="upgradeExhibitor">Upgrade Exhibition </label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="upgradeExhibitor">
                            <label class="custom-control-label" for="upgradeExhibitor">Click to upgrade</label>
                            <p><small>Upgrade your Exhibitor Pass to
                                    Delegate Pass for USD 280 / Pax / 3 Days with the inclusion access to: Conference,
                                    Exhibition, Networking Functions</small></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="simpanExhibitor()">Tambah</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="exhibitorEditModal" tabindex="-1" role="dialog"
    aria-labelledby="addexhibitorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addexhibitorModalLabel">Update Exhibitor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal for input -->
                <form id="delegateForm">
                    <input type="hidden" name="exhibitor_id" id="exhibitor_id">
                    <div class="form-group">
                        <label>Company Type <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="company_EdittypeExhibitor" id="company_EdittypeExhibitor"
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
                                <input type="text" name="companyeditExhibitor" id="companyEditExhibitor"
                                    class="form-control validation" placeholder="Input company name"
                                    value="{{ old('companyEditExhibitor') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger" title="This field is required">*</i></label>
                        <div class="row">
                            <div class="col-lg-2 col-sm-12">
                                <select name="phone_EditcodeExhibitor" id="phone_EditcodeExhibitor"
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
                                <input type="number" name="phoneEditExhibitor" id="phoneEditExhibitor"
                                    class="form-control validation" placeholder="Input mobile number"
                                    value="{{ old('phoneExhibitor') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameEditExhibitor"
                                    name="nameEditExhibitor">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="emailEditExhibitor"
                                    name="emailEditExhibitor">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="job_titleEditExhibitor"
                                    name="job_titleEditExhibitor">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="addressEditExhibitor"
                                    name="addressEditExhibitor">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="cityEditExhibitor"
                                    name="cityEditExhibitor">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="countryEditExhibitor"
                                    name="countryEditExhibitor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postalCode">Postal Code</label>
                                <input type="text" class="form-control" id="postalEditCodeExhibitor"
                                    name="postalEditCodeExhibitor">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="upgradeEditExhibitor">Upgrade Exhibition </label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="upgradeEditExhibitor">
                            <label class="custom-control-label" for="upgradeEditExhibitor">Click to upgrade</label>
                            <p><small>Upgrade your Exhibitor Pass to
                                    Delegate Pass for USD 280 / Pax / 3 Days with the inclusion access to: Conference,
                                    Exhibition, Networking Functions</small></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateExhibitor()">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Load data on page load
    $(document).ready(function() {
        loadExhibitor();
        loadLogExhibitor();
    });
    // Fungsi untuk menambahkan baris baru ke tabel
    function editExhibitor(id) {
        // Retrieve data for the selected delegate using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/exhibitor') }}/' + id,
            success: function(response) {
                var exhibitor = response.data;
                console.log(exhibitor)
                // Populate the fields in the edit modal with existing data
                $('#exhibitor_id').val(exhibitor.id);
                $('#company_EdittypeExhibitor').val(exhibitor.ms_company_type_id);
                $('#companyEditExhibitor').val(exhibitor.company_name);
                $('#phone_EditcodeExhibitor').val(exhibitor.ms_phone_code_id);
                $('#phoneEditExhibitor').val(exhibitor.phone);
                $('#nameEditExhibitor').val(exhibitor.name);
                $('#emailEditExhibitor').val(exhibitor.email);
                $('#job_titleEditExhibitor').val(exhibitor.job_title);
                $('#addressEditExhibitor').val(exhibitor.company_address);
                $('#cityEditExhibitor').val(exhibitor.city);
                $('#countryEditExhibitor').val(exhibitor.country);
                $('#postalEditCodeExhibitor').val(exhibitor.post_code);
                if (exhibitor.type == 'Exhibition Upgrade') {
                    $('#upgradeEditExhibitor').prop('checked', true);
                } else {
                    $('#upgradeEditExhibitor').prop('checked', false);
                }
                // Open the edit modal
                $('#exhibitorEditModal').modal('show');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function updateExhibitor() {
        var id = $('#exhibitor_id').val();
        var companyType = $('#company_EdittypeExhibitor').val();
        var companyName = $('#companyEditExhibitor').val();
        var phoneCode = $('#phone_EditcodeExhibitor').val();
        var phoneNumber = $('#phoneEditExhibitor').val();
        var name = $('#nameEditExhibitor').val();
        var email = $('#emailEditExhibitor').val();
        var job_title = $('#job_titleEditExhibitor').val();
        var address = $('#addressEditExhibitor').val();
        var city = $('#cityEditExhibitor').val();
        var country = $('#countryEditExhibitor').val();
        var postalCode = $('#postalEditCodeExhibitor').val();
        var upgradeExhibitor = $('#upgradeEditExhibitor').is(':checked');
        console.log('update:' + upgradeExhibitor)
        // Validasi input
        if (!companyType || !companyName || !phoneCode || !phoneNumber || !name || !email || !job_title) {
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
            job_title: job_title,
            company_address: address,
            city: city,
            country: country,
            post_code: postalCode,
            upgrade_edit_exhibitor: upgradeExhibitor
        };

        // Send data to the server using Ajax
        $.ajax({
            type: 'PUT',
            url: '{{ url('/exhibitor') }}/' + id,
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil diupdate:', response);
                loadExhibitor(); // Aktifkan fungsi untuk memuat data delegate
                loadLogExhibitor(); // Aktifkan fungsi untuk memuat data log delegate
                $('#exhibitorEditModal').modal('hide');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    // Function to open the input modal
    function tambahExhibitor() {
        $('#exhibitorModal').modal('show');
    }

    function hapusExhibitor(index) {
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
                    url: '{{ url('/exhibitor') }}/' + index,
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Data berhasil dihapus:', response);
                        loadExhibitor();
                        loadLogExhibitor();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }

    function simpanExhibitor() {
        var companyType = $('#company_typeExhibitor').val();
        var companyName = $('#companyExhibitor').val();
        var phoneCode = $('#phone_codeExhibitor').val();
        var phoneNumber = $('#phoneExhibitor').val();
        var name = $('#nameExhibitor').val();
        var email = $('#emailExhibitor').val();
        var position = $('#positionExhibitor').val();
        var address = $('#addressExhibitor').val();
        var city = $('#cityExhibitor').val();
        var country = $('#countryExhibitor').val();
        var postalCode = $('#postalCodeExhibitor').val();
        var upgradeExhibitor = $('#upgradeExhibitor').is(':checked');
        console.log(upgradeExhibitor)
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
        formData.append('upgrade_exhibitor', upgradeExhibitor);


        // Kirim data ke server menggunakan Ajax dengan FormData
        $.ajax({
            type: 'POST',
            url: '{{ url('/exhibitor') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                loadExhibitor();
                loadLogExhibitor();
                $('#exhibitorModal').modal('hide');

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
                $('#upgradeExhibitor').prop('checked', false);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }


    function loadExhibitor() {
        // Clear existing table rows
        $('#tabelExhibitor').empty();

        // Retrieve data from the server using Ajax
        $.ajax({
            type: 'GET',
            url: '{{ url('/exhibitor') }}', // Replace with the actual API URL
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
                        '<button class="btn btn-info" onclick="editExhibitor(' + representative.id +
                        ')">Edit</button> ' +
                        '<button class="btn btn-danger" onclick="hapusExhibitor(' + representative
                        .payment_id +
                        ')">Hapus</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the row to the table body
                    $('#tabelExhibitor').append(row);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function loadLogExhibitor() {
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

                    // Tampilkan elemen div dalam elemen dengan class "logger-delegate"
                    $('.logger-exhibitor').html(logDiv);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>
