<footer class="site-footer">
    <div class="site-footer-shape-1" style="background-image: url({{ asset('assets/images/shapes/site-footer-shape-1.png') }});">
    </div>
    <div class="site-footer-shape-two">
        <img src="{{ asset('assets/images/shapes/site-footer-shape-2.png') }}" alt="">
    </div>
    <div class="site-footer__top">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="footer-widget__column footer-widget__about">
                        <h3 class="footer-widget__title">Explore</h3>
                        <div class="footer-widget__about-text-box">
                            <p class="footer-widget__about-text">Quality cleaning services for your home and business. Professional and reliable.</p>
                        </div>
                        <div class="site-footer__social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="footer-widget__column footer-widget__links clearfix">
                        <h3 class="footer-widget__title">Links</h3>
                        <ul class="footer-widget__links-list list-unstyled clearfix">
                            <li><a href="{{ url('/about') }}">About</a></li>
                            <li><a href="{{ url('/services') }}">Services</a></li>
                            <li><a href="{{ url('/products') }}">Products</a></li>
                            <li><a href="{{ url('/team') }}">Our Team</a></li>
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="footer-widget__column footer-widget__articles clearfix">
                        <h3 class="footer-widget__title">Articles</h3>
                        <ul class="footer-widget__articles-list list-unstyled clearfix">
                            <li>
                                <div class="footer-widget__articles-img">
                                    <img src="{{ asset('assets/images/resources/footer-widget-articles-img-1.jpg') }}" alt="">
                                    <a href="#"><span class="fa fa-link"></span></a>
                                </div>
                                <div class="footer-widget__articles-content">
                                    <p class="footer-widget__articles-date">{{ date('d M, Y') }}</p>
                                    <h5 class="footer-widget__articles-sub-title"><a href="#">6 Cleaning Hacks that will Blow your Mind!</a></h5>
                                </div>
                            </li>
                            <li>
                                <div class="footer-widget__articles-img">
                                    <img src="{{ asset('assets/images/resources/footer-widget-articles-img-2.jpg') }}" alt="">
                                    <a href="#"><span class="fa fa-link"></span></a>
                                </div>
                                <div class="footer-widget__articles-content">
                                    <p class="footer-widget__articles-date">{{ date('d M, Y') }}</p>
                                    <h5 class="footer-widget__articles-sub-title"><a href="#">How to Keep Your Home Clean All Week Long</a></h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="footer-widget__column footer-widget__newsletter">
                        <h3 class="footer-widget__title">Newsletter</h3>
                        <p class="footer-widget__newsletter-text">Subscribe our newsletter to get our latest update & news</p>
                        <form class="footer-widget__newsletter-form">
                            <div class="footer-widget__newsletter-input-box">
                                <input type="email" placeholder="Email address" name="email">
                                <button type="submit" class="footer-widget__newsletter-btn"><i class="far fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="site-footer__bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-footer__bottom-inner">
                        <p class="site-footer__bottom-text">© Copyright {{ date('Y') }} by <a href="#">yourcompany.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
