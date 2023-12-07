@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-event-pass-tab" data-toggle="pill" href="#pills-event-pass"
                            role="tab" aria-controls="pills-event-pass" aria-selected="true">Event Pass</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-wishlist-tab" data-toggle="pill" href="#pills-wishlist" role="tab"
                            aria-controls="pills-wishlist" aria-selected="false">Mining Pass</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-event-pass" role="tabpanel"
                        aria-labelledby="pills-event-pass-tab">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-delegate-tab" data-toggle="pill"
                                        href="#v-pills-delegate" role="tab" aria-controls="v-pills-delegate"
                                        aria-selected="true">Delegate Pass</a>

                                    <a class="nav-link" id="v-pills-exhibitor-tab" data-toggle="pill"
                                        href="#v-pills-exhibitor" role="tab" aria-controls="v-pills-exhibitor"
                                        aria-selected="false">Exhibitor Pass</a>

                                    <a class="nav-link" id="v-pills-working-tab" data-toggle="pill" href="#v-pills-working"
                                        role="tab" aria-controls="v-pills-working" aria-selected="false">Working
                                        Pass</a>

                                    <a class="nav-link" id="v-pills-additional-tab" data-toggle="pill"
                                        href="#v-pills-additional" role="tab" aria-controls="v-pills-additional"
                                        aria-selected="false">Additional Delegate
                                        Pass</a>

                                </div>
                            </div>
                            <div class="col-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-delegate" role="tabpanel"
                                        aria-labelledby="v-pills-delegate-tab">
                                        @include('frontend.form.form-4.delegate')
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-exhibitor" role="tabpanel"
                                        aria-labelledby="v-pills-exhibitor-tab">
                                        @include('frontend.form.form-4.exhibitor')
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-working" role="tabpanel"
                                        aria-labelledby="v-pills-working-tab">
                                        @include('frontend.form.form-4.working')
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-additional" role="tabpanel"
                                        aria-labelledby="v-pills-additional-tab">
                                        @include('frontend.form.form-4.additional')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-wishlist" role="tabpanel" aria-labelledby="pills-wishlist-tab">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-visitor-tab" data-toggle="pill"
                                        href="#v-pills-visitor" role="tab" aria-controls="v-pills-visitor"
                                        aria-selected="true">Mining Pass</a>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-visitor" role="tabpanel"
                                        aria-labelledby="v-pills-visitor-tab">
                                        @include('frontend.form.form-4.visitor')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ url('form?type=promotional') }}" class="btn btn-secondary mr-2">Previous</a>
                <a href="{{ url('form?type=exhibition') }}" class="btn btn-info">Next</a>
            </div>
        </div>
    </div>
@endsection

@push('bottom')
    {{-- Script load table --}}
    <script>
        function loadDataDelegate() {
            $.ajax({
                type: 'GET', // or 'POST' based on your backend
                url: 'your_backend_get_data_url', // Replace with your backend endpoint to get data
                success: function(data) {
                    // Clear existing table rows
                    $('#tabel-delegate').empty();

                    // Iterate through the data and append rows to the table
                    $.each(data, function(index, delegate) {
                        $('#tabel-delegate').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${delegate.company}</td>
                            <td>${delegate.name}</td>
                            <td>${delegate.position}</td>
                            <td>${delegate.email}</td>
                            <td>${delegate.mobile}</td>
                            <td>${delegate.address}</td>
                            <td>${delegate.city}</td>
                            <td>${delegate.country}</td>
                            <td>${delegate.postalCode}</td>
                            <td>${delegate.phone}</td>
                            <td>Action buttons here</td>
                        </tr>
                    `);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function loadDataExhibitor() {
            $.ajax({
                type: 'GET', // or 'POST' based on your backend
                url: 'your_backend_get_data_url', // Replace with your backend endpoint to get data
                success: function(data) {
                    // Clear existing table rows
                    $('#tabel-exhibitor').empty();

                    // Iterate through the data and append rows to the table
                    $.each(data, function(index, exhibitor) {
                        $('#tabel-exhibitor').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${exhibitor.company}</td>
                            <td>${exhibitor.name}</td>
                            <td>${exhibitor.position}</td>
                            <td>${exhibitor.email}</td>
                            <td>${exhibitor.mobile}</td>
                            <td>${exhibitor.address}</td>
                            <td>${exhibitor.city}</td>
                            <td>${exhibitor.country}</td>
                            <td>${exhibitor.postalCode}</td>
                            <td>${exhibitor.phone}</td>
                            <td>titik</td>
                            <td>Action buttons here</td>
                        </tr>
                    `);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function loadDataWorking() {
            $.ajax({
                type: 'GET', // or 'POST' based on your backend
                url: 'your_backend_get_data_url', // Replace with your backend endpoint to get data
                success: function(data) {
                    // Clear existing table rows
                    $('#tabel-working').empty();

                    // Iterate through the data and append rows to the table
                    $.each(data, function(index, working) {
                        $('#tabel-working').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${working.company}</td>
                            <td>${working.name}</td>
                            <td>${working.position}</td>
                            <td>${working.email}</td>
                            <td>${working.mobile}</td>
                            <td>${working.address}</td>
                            <td>${working.city}</td>
                            <td>${working.country}</td>
                            <td>${working.postalCode}</td>
                            <td>${working.phone}</td>
                            <td>Action buttons here</td>
                        </tr>
                    `);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function loadDataAdditional() {
            $.ajax({
                type: 'GET', // or 'POST' based on your backend
                url: 'your_backend_get_data_url', // Replace with your backend endpoint to get data
                success: function(data) {
                    // Clear existing table rows
                    $('#tabel-additional').empty();

                    // Iterate through the data and append rows to the table
                    $.each(data, function(index, additional) {
                        $('#tabel-additional').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${additional.company}</td>
                            <td>${additional.name}</td>
                            <td>${additional.position}</td>
                            <td>${additional.email}</td>
                            <td>${additional.mobile}</td>
                            <td>${additional.address}</td>
                            <td>${additional.city}</td>
                            <td>${additional.country}</td>
                            <td>${additional.postalCode}</td>
                            <td>${additional.phone}</td>
                            <td>Action buttons here</td>
                        </tr>
                    `);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function loadDataVisitor() {
            $.ajax({
                type: 'GET', // or 'POST' based on your backend
                url: 'your_backend_get_data_url', // Replace with your backend endpoint to get data
                success: function(data) {
                    // Clear existing table rows
                    $('#tabel-visitor').empty();

                    // Iterate through the data and append rows to the table
                    $.each(data, function(index, visitor) {
                        $('#tabel-visitor').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${visitor.company}</td>
                            <td>${visitor.name}</td>
                            <td>${visitor.position}</td>
                            <td>${visitor.email}</td>
                            <td>${visitor.mobile}</td>
                            <td>${visitor.address}</td>
                            <td>${visitor.city}</td>
                            <td>${visitor.country}</td>
                            <td>${visitor.postalCode}</td>
                            <td>${visitor.phone}</td>
                            <td>Action buttons here</td>
                        </tr>
                    `);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        // Load the table data on page load
        $(document).ready(function() {
            loadDataDelegate();
            loadDataExhibitor();
            loadDataWorking();
            loadDataAdditional();
            loadDataVisitor();
        });
    </script>

    {{-- Script Save --}}
    <script>
        function saveDelegate() {
            // Get form data
            var formData = $('#delegateForm').serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST', // You can change it to 'GET' if needed
                url: 'your_backend_endpoint_url', // Replace with your backend endpoint
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#addDelegateModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Delegate saved successfully!',
                    });
                    loadDataDelegate();
                    console.log(response); // Log the response from the server
                },
                error: function(error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to save delegate. Please try again.',
                    });
                    console.error(error);
                }
            });
        }

        function saveExhibitor() {
            // Get form data
            var formData = $('#exhibitorForm').serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST', // You can change it to 'GET' if needed
                url: 'your_backend_endpoint_url', // Replace with your backend endpoint
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#addExhibitorModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Exhibitor saved successfully!',
                    });
                    console.log(response); // Log the response from the server
                },
                error: function(error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to save Exhibitor. Please try again.',
                    });
                    console.error(error);
                }
            });
        }

        function saveWorking() {
            // Get form data
            var formData = $('#WorkingForm').serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST', // You can change it to 'GET' if needed
                url: 'your_backend_endpoint_url', // Replace with your backend endpoint
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#addWorkingModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Working saved successfully!',
                    });
                    console.log(response); // Log the response from the server
                },
                error: function(error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to save Working. Please try again.',
                    });
                    console.error(error);
                }
            });
        }

        function saveAdditional() {
            // Get form data
            var formData = $('#additionalForm').serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST', // You can change it to 'GET' if needed
                url: 'your_backend_endpoint_url', // Replace with your backend endpoint
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#addAdditionalModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'additional saved successfully!',
                    });
                    console.log(response); // Log the response from the server
                },
                error: function(error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to save additional. Please try again.',
                    });
                    console.error(error);
                }
            });
        }

        function saveVisitor() {
            // Get form data
            var formData = $('#visitorForm').serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST', // You can change it to 'GET' if needed
                url: 'your_backend_endpoint_url', // Replace with your backend endpoint
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#addVisitorModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Visitor saved successfully!',
                    });
                    console.log(response); // Log the response from the server
                },
                error: function(error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to save Visitor. Please try again.',
                    });
                    console.error(error);
                }
            });
        }
    </script>
@endpush
