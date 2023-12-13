<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js">
    </script>
    <!-- Tambahkan ini ke dalam bagian head HTML Anda -->
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.min.css">
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
    @stack('top')
    <title>Exhibition Portal</title>
    <style>
        body {
            padding-top: 56px;
            /* Adjust based on the height of your fixed navbar */
        }

        .sidebar {
            top: 56px;
            /* Adjust based on the height of your fixed navbar */
            bottom: 0;
            overflow-y: auto;
            /* Enable scrolling if the content exceeds the viewport height */
        }

        @media (min-width: 768px) {
            body {
                padding-top: 56px;
                /* Adjust based on the height of your fixed navbar */
            }

            .sidebar {
                top: 56px;
                /* Adjust based on the height of your fixed navbar */
                bottom: 0;
                overflow-y: auto;
                /* Enable scrolling if the content exceeds the viewport height */
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">Portal Exhibition</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('form?type=company-information') }}">Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Travel Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
            </ul>
            <span class="navbar-text">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </span>
        </div>
    </nav>

    <div class="container-fluid mt-5"></div>
    <div class="row">
        @if (Request::is('form'))
            <div class="col-sm-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <div
                            class="card text-white {{ $type == 'company-information' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                            <div class="card-body">
                                <h8 class="card-title">FORM 1 - Company Information</h8>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div
                            class="card text-white {{ $type == 'indonesia-miner-directory' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                            <div class="card-body">
                                <h7 class="card-title">FORM 2 - Indonesia Miner Directory</h7>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="card text-white {{ $type == 'promotional' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                            <div class="card-body">
                                <h7 class="card-title">FORM 3 - Promotional</h7>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="card text-white {{ $type == 'event-pass' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                            <div class="card-body">
                                <h7 class="card-title">FORM 4 - Event Pass</h7>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="card text-white {{ $type == 'exhibition' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                            <div class="card-body">
                                <h7 class="card-title">FORM 5 - Exhibition</h7>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        @endif
        @yield('content')

    </div>
    </div>



    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-muted">© 2024 PT Media Mitra Karya Indonesia</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#twitter"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#instagram"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24"
                        height="24">
                        <use xlink:href="#facebook"></use>
                    </svg></a></li>
        </ul>
    </footer>
    <!-- Alert Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="deviceAlertModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restricted Access</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>This website is optimized for desktop use. Please switch to a desktop or laptop for a better
                        experience.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        // Detect device type
        function isMobileDevice() {
            return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
        }

        // Show alert modal for mobile devices
        if (isMobileDevice()) {
            $(document).ready(function() {
                $('#deviceAlertModal').modal('show');
            });

            // Close the website after showing the alert
            setTimeout(function() {
                window.close();
            }, 5000); // Auto-close after 5 seconds (adjust as needed)
        }
    </script>

    @stack('bottom')

</body>

</html>
