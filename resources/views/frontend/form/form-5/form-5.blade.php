@extends('index')

@section('content')
    <div class="col-sm-9">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Please note that the Organizer will not be responsible for: </strong>
                        <ul>
                            <li>Any Information, material or data that is not included in the guarantee after the specified
                                time
                                limit</li>
                            <li>Lack of equipment or service caused by late return of the order form</li>
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="card-exhibition">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#pic-exhibition"
                                        aria-expanded="true" aria-controls="pic-exhibition">
                                        PIC Exhibition
                                    </button>
                                </h5>
                            </div>

                            <div id="pic-exhibition" class="collapse show" aria-labelledby="card-exhibition"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        @if (optional($log_pic)->updated_at != null)
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                Last update :
                                                <strong>
                                                    {{ optional($log_pic->updated_at)->format('d F Y, g:i A') }}
                                                    GMT + 7
                                                </strong>
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        <form action="{{ url('pic') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Contact Person</label>
                                                        <input type="text" name="pic_name" class="form-control"
                                                            value="{{ $data->pic_name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="text" name="pic_email" class="form-control"
                                                            value="{{ $data->pic_email }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Job Title</label>
                                                        <input type="text" name="pic_job_title" class="form-control"
                                                            value="{{ $data->pic_job_title }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""> Mobile</label>
                                                        <input type="text" name="pic_phone" class="form-control"
                                                            value="{{ $data->pic_phone }}" required>
                                                    </div>
                                                </div>
                                                @if ($data->exhibition_design == 1)
                                                    <div class="col-sm-12">
                                                        <label for="">Fascia Name</label>
                                                        <div class="alert alert-danger" role="alert">
                                                            <ul>
                                                                <li>Please write the Company Name below, based on what is
                                                                    needed
                                                                    in
                                                                    the
                                                                    fascia. Fill in block letters using the alphabet (
                                                                    maximum
                                                                    24
                                                                    letters).
                                                                    Fascia names longer than 24 letters will be displayed on
                                                                    2
                                                                    lines
                                                                    and
                                                                    the
                                                                    font size will be minimized accordingly</li>
                                                                <li>The fascia name will follow based on this form. If it
                                                                    passes
                                                                    the
                                                                    deadline, any changes to the fascia will incur an
                                                                    additional
                                                                    fee
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="form-group fascia-container">
                                                            <?php
                                                            $fascia_name = $fascia_name; // Mengakses properti fascia_name dari objek $data
                                                            if (is_array($fascia_name)) {
                                                                for ($i = 0; $i < 24; $i++) {
                                                                    // Modify the style of the fascia-box and set the value from the controller's data if it exists
                                                                    $value = isset($fascia_name[$i]) ? $fascia_name[$i] : '';
                                                                    echo '<input class="fascia-box" type="text" name="fascia_name[]" maxlength="1" oninput="moveToNext(this)" value="' . $value . '">';
                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                    </div>
                                                @endif

                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="home-tab" data-toggle="tab"
                                                                    href="#home" role="tab" aria-controls="home"
                                                                    aria-selected="true">Draw</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="profile-tab" data-toggle="tab"
                                                                    href="#profile" role="tab" aria-controls="profile"
                                                                    aria-selected="false">Upload Signature</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="home"
                                                                role="tabpanel" aria-labelledby="home-tab"> <canvas
                                                                    id="signatureCanvas" width="400"
                                                                    height="200"></canvas>
                                                            </div>
                                                            <div class="tab-pane fade" id="profile" role="tabpanel"
                                                                aria-labelledby="profile-tab"> <input type="file"
                                                                    id="uploadBtn" accept="image/*" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-warning mt-3"
                                                                id="clearBtn">Clear
                                                                Signature</button>
                                                            <button type="button" class="btn btn-success mt-3"
                                                                id="saveBtn">Save
                                                                Signature</button>

                                                        </div>
                                                        <div>
                                                            <img id="signatureImage" style="display:none;"
                                                                src="{{ env('IMAGE_BASE_URL') . $data->pic_signature }}">
                                                            <input type="hidden" name="pic_signature"
                                                                id="pic_signature">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block"> Save
                                                Contact</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse"
                                                data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Furniture
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            @include('frontend.form.form-5.furniture')
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                Lighting Service and Other Tools
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            @include('frontend.form.form-5.lighting')
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse"
                                                data-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree">
                                                Electrical Services
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            @include('frontend.form.form-5.electricity')

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-sm-3 col-md-3 order-md-2 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Your cart</span>
                                <span class="badge badge-secondary badge-pill">1</span>
                            </h4>
                            <ul id="cartList" class="list-group mb-3">
                                <!-- Cart items will be dynamically added here -->
                            </ul>
                            <div>Total (IDR): <strong id="totalPrice">0.00</strong></div>
                            <button id="checkoutBtn" class="btn btn-primary btn-lg btn-block" disabled>Checkout</button>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('bottom')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    {{-- signature --}}
    <script>
        $(document).ready(function() {
            var canvas = $('#signatureCanvas');
            var signaturePad = new SignaturePad(canvas[0]);
            var signatureImage = $('#signatureImage');
            // Set the display of the signature image based on whether it has a src attribute
            if (signatureImage.attr('src') === "" || signatureImage.attr('src') === undefined) {
                signatureImage.hide();
            } else {
                signatureImage.show();
            }
            // Clear signature
            $('#clearBtn').click(function() {
                signaturePad.clear();
            });

            // Save signature
            $('#saveBtn').click(function() {
                if (signaturePad.isEmpty()) {
                    alert("Tanda tangan kosong.");
                } else {
                    var dataURL = signaturePad.toDataURL();
                    signatureImage.attr('src', dataURL).show();

                    // Kirim dataURL ke server atau proses sesuai kebutuhan Anda
                    console.log(dataURL);
                    $("#pic_signature").val(dataURL)
                }
            });

            // Handle uploaded image
            $('#uploadBtn').change(function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var base64Data = event.target.result;
                        signatureImage.attr('src', base64Data).show();
                        // Clear the canvas or process the uploaded image
                        signaturePad.clear();
                        // Assuming #pic_signature is a hidden input field where you want to store the base64 string
                        $("#pic_signature").val(base64Data);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

        });
    </script>

    {{-- facia name --}}
    <script>
        function moveToNext(input) {
            var maxLength = parseInt(input.maxLength, 10);

            // Jika panjang input saat ini adalah 0, maka hapus teks dari input sebelumnya
            if (input.value.length === 0) {
                var prevInput = input.previousElementSibling;

                // Hapus teks dari input sebelumnya jika ada
                if (prevInput && prevInput.tagName === 'INPUT') {
                    prevInput.value = '';
                    prevInput.focus();
                }
            }

            // Memindahkan fokus ke elemen input berikutnya jika tersedia
            var nextInput = input.nextElementSibling;
            if (nextInput && nextInput.tagName === 'INPUT') {
                nextInput.focus();
            }
        }
    </script>


    {{-- to cart --}}
    <script>
        function exhibitionCart(name_product, section_product, price, total_price, quantity, image) {

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var formData = new FormData();
            formData.append('name_product', name_product);
            formData.append('section_product', section_product);
            formData.append('price', price);
            formData.append('total_price', total_price);
            formData.append('quantity', quantity);
            formData.append('image', image)

            console.log(formData)
            // Kirim data ke server menggunakan Ajax dengan FormData

            $.ajax({
                type: 'POST',
                url: '{{ url('/cart-exhibition') }}',
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
                        title: "Added item to cart",
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

        function removeExhibition(id) {
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
                        url: 'cart-item-exhibition/' + id,
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

        function changeQuantity(id, quantity) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var formData = new FormData();
            formData.append('id', id);
            formData.append('quantity', quantity);
            console.log(id)
            console.log(quantity)
            // Kirim data ke server menggunakan Ajax dengan FormData

            $.ajax({
                type: 'POST',
                url: '{{ url('/cart/change') }}',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log(response)
                    loadCart();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
@endpush

@push('top')
    <style>
        #signatureCanvas {
            border: 1px solid #ccc;
        }

        .fascia-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .fascia-box {
            width: 2em;
            height: 2em;
            border: 1px solid #000;
            text-align: center;
            line-height: 2em;
            margin: 0 2px;
        }

        .product-grid {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            transition: all 0.5s;
        }

        .product-grid:hover {
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.3);
        }

        .product-grid .product-image {
            position: relative;
            overflow: hidden;
        }

        .product-grid .product-image a.image {
            display: block;
        }

        .product-grid .product-image img {
            width: 100%;
            height: auto;
        }

        .product-image .pic-1 {
            opacity: 1;
            backface-visibility: hidden;
            transition: all 0.5s;
        }

        .product-grid:hover .product-image .pic-1 {
            opacity: 0;
        }

        .product-image .pic-2 {
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            transition: all 0.5s;
        }

        .product-grid:hover .product-image .pic-2 {
            opacity: 1;
        }

        .product-grid .product-sale-label {
            color: #fff;
            background: #6da84a;
            font-size: 14px;
            font-style: italic;
            text-transform: uppercase;
            width: 55px;
            height: 55px;
            line-height: 55px;
            border-radius: 50px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .product-grid .social {
            padding: 0;
            margin: 0;
            list-style: none;
            position: absolute;
            top: 15px;
            right: 7px;
        }

        .product-grid .social li {
            transform: translateX(60px);
            transition: all 0.3s ease 0.3s;
        }

        .product-grid .social li:nth-child(2) {
            transition: all 0.3s ease 0.4s;
        }

        .product-grid:hover .social li {
            transform: translateX(0);
        }

        .product-grid .social li a {
            color: #707070;
            background: #fff;
            font-size: 16px;
            line-height: 40px;
            width: 40px;
            height: 40px;
            margin: 0 0 7px;
            border-radius: 50px;
            display: block;
            transition: all 0.3s ease 0s;
        }

        .product-grid .social li a:hover {
            color: #6DA84A;
        }

        .product-grid .product-rating {
            background: rgba(255, 255, 255, 0.95);
            width: 100%;
            padding: 10px;
            opacity: 0;
            position: absolute;
            bottom: -60px;
            left: 0;
            transition: all .2s ease-in-out 0s;
        }

        .product-grid:hover .product-rating {
            opacity: 1;
            bottom: 0;
        }

        .product-grid .rating {
            padding: 0;
            margin: 0;
            list-style: none;
            float: left;
        }

        .product-grid .rating li {
            color: #6DA84A;
            font-size: 13px;
        }

        .product-grid .rating li.far {
            color: #999;
        }

        .product-grid .add-to-cart {
            color: #6DA84A;
            font-size: 14px;
            font-weight: 600;
            border-bottom: 1px solid #6DA84A;
            float: right;
            transition: all .2s ease-in-out 0s;
        }

        .product-grid .add-to-cart:hover {
            color: #000;
            border-color: #000;
        }

        .product-grid .product-content {
            background: #F5F5F5;
            padding: 15px;
        }

        .product-grid .title {
            font-size: 18px;
            text-transform: capitalize;
            margin: 0 0 5px;
        }

        .product-grid .title a {
            color: #111;
            transition: all 500ms;
        }

        .product-grid .title a:hover {
            color: #6DA84A;
        }

        .product-grid .price {
            color: #707070;
            font-size: 17px;
            text-decoration: underline;
        }

        .product-grid .price span {
            text-decoration: line-through;
            margin-right: 5px;
            display: inline-block;
            opacity: 0.6;
        }

        @media only screen and (max-width:990px) {
            .product-grid {
                margin-bottom: 40px;
            }
        }
    </style>
@endpush
