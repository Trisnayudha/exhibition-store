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
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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
    <style>
        .quantity-selector button {
            width: 35px;
            /* Lebar tombol */
            height: 35px;
            /* Tinggi tombol */
            line-height: 35px;
            /* Posisi vertikal teks di tombol */
            padding: 0;
            margin: 0 5px;
            /* Jarak antar tombol */
        }

        .quantity-number {
            display: inline-block;
            width: 50px;
            /* Lebar area jumlah */
            text-align: center;
            /* Teks jumlah di tengah */
        }

        .cart-item img {
            width: 50%;
            /* Membuat gambar responsif */
            height: auto;
            /* Mempertahankan rasio aspek */
        }

        .price {
            font-size: 1.2em;
            /* Ukuran font harga */
            font-weight: bold;
            /* Kegemukan font harga */
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
            <span class="navbar-text mr-4">
                <button class="btn btn-outline-primary position-relative" type="button" data-toggle="modal"
                    data-target="#shoppingCartModal">
                    <i class="fas fa-shopping-cart"></i>
                    <!-- Badge indikator jumlah item di keranjang -->
                    <span class="badge badge-pill badge-danger position-absolute" style="top: -10px; right: -10px;"
                        id="cartItemCount">0</span>
                </button>
            </span>
            <span class="navbar-text">
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </span>

        </div>
    </nav>

    <div class="container-fluid mt-5">
        <div class="row">
            @if (Request::is('form'))
                <div class="col-sm-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <div
                                class="card text-white {{ $type == 'company-information' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                                <div class="card-body">
                                    <h8 class="card-title">FORM {{ $form_number++ }} - Company Information</h8>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div
                                class="card text-white {{ $type == 'indonesia-miner-directory' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                                <div class="card-body">
                                    <h7 class="card-title">FORM {{ $form_number++ }} - Indonesia Miner Directory</h7>
                                </div>
                            </div>
                        </li>
                        @if ($access['promotional_access'] == 1)
                            <li class="nav-item">
                                <div
                                    class="card text-white {{ $type == 'promotional' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                                    <div class="card-body">
                                        <h7 class="card-title">FORM {{ $form_number++ }} - Promotional</h7>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if ($access['eventpass_access'] == 1)
                            <li class="nav-item">
                                <div
                                    class="card text-white {{ $type == 'event-pass' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                                    <div class="card-body">
                                        <h7 class="card-title">FORM {{ $form_number++ }} - Event Pass</h7>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if ($access['exhibition_access'] == 1)
                            <li class="nav-item">
                                <div
                                    class="card text-white {{ $type == 'exhibition' ? ' bg-info ' : ' bg-secondary ' }} mb-3">
                                    <div class="card-body">
                                        <h7 class="card-title">FORM {{ $form_number++ }} - Exhibition</h7>
                                    </div>
                                </div>
                            </li>
                        @endif

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
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24"
                        height="24">
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
        CKEDITOR.replace('.ckeditor', {
            allowedContent: true
        });

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

    {{-- script Cart --}}
    <script>
        $(document).ready(function() {
            getListCart();
            getCountCart();
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan keluar dari akun Anda.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mengirim form logout jika pengguna mengkonfirmasi
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        function loadCart() {
            console.log('load-cart')
            getCountCart();
            getListCart();
        }

        function getListCart() {
            $('#item-delegate').empty();
            $.ajax({
                type: 'GET',
                url: '{{ url('/cart') }}',
                success: function(response) {
                    var itemsHtml = '';

                    response.data.forEach(function(item) {
                        // Format harga dengan pemisah ribuan
                        var formattedPrice = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(item.price);

                        itemsHtml += `
                    <div class="cart-item my-2 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ asset('assets/img/users.png') }}" alt="${item.name_product}"
                                    class="img-fluid" width="50" height="50">
                            </div>
                            <div class="col-md-4">
                                <h5>${item.name_product}</h5>
                                <h7>${item.section_product}</h7>
                            </div>
                            <div class="col-md-2">
                                <span class="price">${formattedPrice}</span>
                            </div>
                            <div class="col-md-3">
                                <div class="quantity-selector d-flex align-items-center">
                                    <span class="mx-2 quantity-number">${item.quantity}</span>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-danger btn-sm" onclick="removeDelegate('${item.id}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>`;
                    });

                    $('#item-delegate').html(itemsHtml);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function getCountCart() {
            $.ajax({
                type: 'GET',
                url: '{{ url('/cart-count') }}',
                success: function(response) {
                    // asumsikan response.data mengandung jumlah item di keranjang
                    var itemCount = response.data;

                    // Mengupdate angka pada elemen dengan id cartItemCount
                    $('#cartItemCount').text(itemCount);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }


        function delegateCart(payment, user) {
            console.log(payment);
            // console.log(user);

            var name_product = user.name;
            var section_product = payment.type;
            var price = payment.event_price;
            var total_price = payment.total_price;
            var quantity = '1';
            var delegate_id = payment.id;

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var formData = new FormData();
            formData.append('name_product', name_product);
            formData.append('section_product', section_product);
            formData.append('price', price);
            formData.append('total_price', total_price);
            formData.append('quantity', quantity);
            formData.append('delegate_id', delegate_id);

            console.log(formData)
            // Kirim data ke server menggunakan Ajax dengan FormData

            $.ajax({
                type: 'POST',
                url: '{{ url('/cart') }}',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Added delegate to cart",
                        showConfirmButton: false,
                        timer: 1500,
                    });

                    loadCart();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });

        }

        function removeDelegate(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'cart-item/' + id,
                        type: 'DELETE',
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(result) {
                            // Handle the success scenario
                            console.log('Item removed successfully');
                            loadCart();
                            loadExhibitor();
                            loadAdditional();
                            // Display SweetAlert confirmation
                            Swal.fire({
                                title: 'Success!',
                                text: 'Item removed successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            console.log('Error in removal: ' + error);

                            // Optionally, display an error message using SweetAlert
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to remove the item: ' + error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                }
            });

        }
    </script>
    @stack('bottom')
    <!-- Modal Keranjang Belanja -->
    <div class="modal fade" id="shoppingCartModal" tabindex="-1" role="dialog"
        aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shoppingCartModalLabel">Keranjang Belanja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="item-delegate">

                    </div>
                    <div class="item-exhibition">
                        {{-- <div class="cart-item my-2 p-3 border rounded">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{ asset('assets/img/users.png') }}" alt="Nama Produk"
                                        class="img-fluid" width="50" height="50">

                                </div>
                                <div class="col-md-4">
                                    <h5>Trisnayudha - IT Office</h5>
                                    <h7>Upgrade Delegate</h7>
                                </div>
                                <div class="col-md-2">
                                    <span class="price">Rp605.000</span>
                                </div>
                                <div class="col-md-3">
                                    <div class="quantity-selector d-flex align-items-center">
                                        <button class="btn btn-outline-secondary"
                                            onclick="changeQuantity('item1', -1)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <span id="item1-quantity" class="mx-2 quantity-number">1</span>
                                        <button class="btn btn-outline-secondary"
                                            onclick="changeQuantity('item1', 1)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-danger btn-sm" onclick="removeDelegate('item1')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Checkout</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
