<div class="row">
    <div class="col-lg-3">
        <div class="header__logo">
            <a href="{{ url('/') }}"><img src="img/logo.png" alt=""></a>
        </div>
    </div>
    <div class="col-lg-6">
        <nav class="header__menu">
            <ul>
                <li class="active"><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('shop') }}">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                        <li><a href="./checkout.html">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.html">Blog</a></li>
                <li><a href="./contact.html">Contact</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-lg-3">
        <div class="header__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i>
                        {{-- <span>1</span> --}}
                    </a></li>
                <li><a href="{{ url('/shoping/cart') }}"><i class="fa fa-shopping-bag"></i> <span>1</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>IDR 2.000.000</span></div>
        </div>
    </div>
</div>
<div class="humberger__open">
    <i class="fa fa-bars"></i>
</div>
