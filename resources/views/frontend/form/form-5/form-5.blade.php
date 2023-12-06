@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Please note that the Organizer will not be responsible for: </strong>
                    <ul>
                        <li>Any Information, material or data that is not included in the guarantee after the specified time
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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Contact Person</label>
                                            <input type="text" name="contact_person" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" name="contact_email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Job Title</label>
                                            <input type="text" name="contact_job_title" class="form-control"
                                                id="">
                                        </div>
                                        <div class="form-group">
                                            <label for=""> Mobile</label>
                                            <input type="text" name="contact_mobile" class="form-control" id="">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary"> Save Contact</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-9">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            Furniture
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
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
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Lighting Service and Other Tools
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
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
                                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        @include('frontend.form.form-5.electricity')

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Your cart</span>
                            <span class="badge badge-secondary badge-pill">1</span>
                        </h4>
                        <ul id="cartList" class="list-group mb-3">
                            <!-- Cart items will be dynamically added here -->
                        </ul>
                        <div>Total (IDR): <strong id="totalPrice">0.00</strong></div>
                        <button id="checkoutBtn" class="btn btn-primary btn-lg btn-block" disabled>Checkout</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('bottom')
    <script>
        $(document).ready(function() {
            // Initialize cart as an empty array
            var cart = [];
            // Event handler for deleting a product from the cart
            $(document).on('click', '.delete-item', function() {
                var index = $(this).data('index');
                cart.splice(index, 1); // Remove the item from the cart array
                updateCart(); // Update the cart and UI
            });
            // Function to update the cart and UI
            function updateCart() {
                // Update the cart total and enable/disable the checkout button
                var total = 0;
                for (var i = 0; i < cart.length; i++) {
                    total += cart[i].quantity * cart[i].price;
                }

                if (cart.length > 0) {
                    // Enable the checkout button
                    $('#checkoutBtn').prop('disabled', false);
                } else {
                    // Disable the checkout button
                    $('#checkoutBtn').prop('disabled', true);
                }

                // Update the UI with the cart items and total
                $('#cartList').empty();
                for (var i = 0; i < cart.length; i++) {
                    $('#cartList').append(
                        '<li class="list-group-item d-flex justify-content-between lh-condensed">' +
                        '<div class="col-10">' +
                        '<h6 class="my-0">' + cart[i].name + '</h6>' +
                        '<small class="text-muted">IDR ' + cart[i].price.toLocaleString('id-ID') + '</small>' +
                        '</div>' +
                        '<div class="input-group input-group-sm">' +
                        '<input type="number" class="form-control quantity" value="' + cart[i].quantity +
                        '" min="1" data-index="' + i + '">' +
                        '</div>' +
                        '<button type="button" class="btn btn-outline-danger btn-sm ml-2 delete-item" data-index="' +
                        i + '">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        '</button>' +
                        '</li>'
                    );
                }

                $('#totalPrice').text('IDR ' + total.toLocaleString('id-ID'));
            }

            // Event handler for adding a product to the cart
            $('.add-to-cart').click(function() {
                var productName = $(this).data('name');
                var productPrice = parseFloat($(this).data('price'));
                var existingItem = cart.find(item => item.name === productName);

                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push({
                        name: productName,
                        price: productPrice,
                        quantity: 1
                    });
                }

                updateCart();
            });

            // Event handler for changing quantity in the cart
            $(document).on('change', '.quantity', function() {
                var index = $(this).data('index');
                cart[index].quantity = parseInt($(this).val());
                updateCart();
            });


            // Initial cart update
            updateCart();
        });
    </script>
@endpush

@push('top')
    <style>
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
