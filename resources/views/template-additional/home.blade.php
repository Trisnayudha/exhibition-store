@extends('layouts.master')
@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="#">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" placeholder="What do yo u need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>+62 8329 314 436</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <li data-filter=".furniture">Furniture</li>
                            <li data-filter=".lighting">Lighting Service and Other Tools</li>
                            <li data-filter=".electrical">Electrical Services</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <div class="col-lg-3 col-md-4 col-sm-6 mix furniture">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://www.sprintexpo.com/uploads/1423944889.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Rack Brochure ZigZag</a></h6>
                            <h5>IDR 600.000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix electrical">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://cdn.pixabay.com/photo/2019/09/27/08/06/electricity-4507838_1280.png">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">2A / 1ph 440 watt</a></h6>
                            <h5>IDR 1.650.000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix lighting">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://i.pinimg.com/736x/9c/29/93/9c2993d52e25b02e5287cef5f384f4e0.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Long Arm Spot Light White</a></h6>
                            <h5>IDR 675.000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix furniture">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://images.tokopedia.net/img/cache/700/hDjmkQ/2021/2/19/e653e789-ac84-4e20-acdf-cf3ce1513f2b.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Fish Bowl</a></h6>
                            <h5>IDR 225.000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix lighting">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://image1ws.indotrading.com/s3/productimages/webp/co170930/p1108732/w425-h425/45b3f586-e193-471f-b28e-e4e4a5ac7a6f.png">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">LED TV 43 Inch + Standing</a></h6>
                            <h5>IDR 4.500.000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix electrical">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://cdn.pixabay.com/photo/2019/09/27/08/06/electricity-4507838_1280.png">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">60A / 3 ph / 22800 watt</a></h6>
                            <h5>IDR 56.400.000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix furniture">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://images.thdstatic.com/productImages/e7870b4a-02d0-456e-b673-df6d310fe11e/svn/beige-folding-chairs-sc004x001a-64_1000.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Folding Chair</a></h6>
                            <h5>IDR 225.000</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix lighting">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            data-setbg="https://5.imimg.com/data5/ANDROID/Default/2021/9/DQ/DV/AL/6856367/img-20210909-082830-jpg-500x500.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Halogen LED 100 watt</a></h6>
                            <h5>IDR 935.000</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="https://indonesiaminer.com/uploads/2/2022-10/directory_homepage_1500_750_px.png"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="https://indonesiaminer.com/uploads/2/2023-07/im2023_mobileapps_banner_ii.png"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->
@endsection
