@extends('layouts.app')

@section('title', 'About Us - Cleaning Services')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('assets/images/safaraz/company1.jpg') }})">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('client.dashboard') }}">Home</a></li>
                    <li><span>/</span></li>
                    <li>About</li>
                </ul>
                <h2>About Us</h2>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="get-to-know">
            <div class="get-to-know-bubble float-bob-x">
                <img src="assets/images/shapes/get-to-know-bubble.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="get-to-know__left">
                            <div class="get-to-know__img wow slideInLeft" data-wow-delay="100ms"
                                data-wow-duration="2500ms">
                                <img src="assets/images/safaraz/agus.jpg" alt="">
                                <div class="get-to-know-shape-1"></div>
                                <div class="get-to-know-shape-2"></div>
                            </div>
                        </div>
                    </div>
                <div class="col-xl-6">
                    <div class="about-two__right">
                        <div class="section-title text-left">
                            <span class="section-title__tagline">Our Introduction</span>
                            <h2 class="section-title__title">Professional Cleaning Services in Your Area</h2>
                        </div>
                        <p class="about-two__text-1">We are dedicated to providing top-quality cleaning services for both residential and commercial clients. With 25 years of experience, we've built a reputation for excellence and reliability.</p>
                        <p class="about-two__text-2">Our team of trained professionals uses the latest techniques and environmentally friendly products to ensure your space is not only clean but also healthy. We believe in delivering personalized service that meets your specific needs.</p>
                        <div class="about-two__progress-wrap">
                            <div class="about-two__progress">
                                <div class="about-two__progress-box">
                                    <div class="circle-progress"
                                        data-options='{ "value": 0.9,"thickness": 3,"emptyFill": "#eef3f7","lineCap": "round", "size": 138, "fill": { "color": "#28dbd1" } }'>
                                    </div><!-- /.circle-progress -->
                                    <span>90%</span>
                                </div>
                                <div class="about-two__progress-content">
                                    <h3>Residential Cleaning</h3>
                                </div>
                            </div>
                            <div class="about-two__progress">
                                <div class="about-two__progress-box">
                                    <div class="circle-progress"
                                        data-options='{ "value": 0.8,"thickness": 3,"emptyFill": "#eef3f7","lineCap": "round", "size": 138, "fill": { "color": "#28dbd1" } }'>
                                    </div><!-- /.circle-progress -->
                                    <span>80%</span>
                                </div>
                                <div class="about-two__progress-content">
                                    <h3>Commercial Cleaning</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="feature-two">
        <div class="container">
            <div class="feature-two__inner">
                <div class="row">
                    <div class="col-xl-4 col-lg-4">
                        <div class="feature-two__single">
                            <div class="feature-two__icon">
                                <span class="icon-broom"></span>
                            </div>
                            <div class="feature-two__content">
                                <h3 class="feature-two__title">Professional Staff</h3>
                                <p class="feature-two__text">Our team consists of trained and experienced cleaning professionals who take pride in their work.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="feature-two__single">
                            <div class="feature-two__icon">
                                <span class="icon-clock"></span>
                            </div>
                            <div class="feature-two__content">
                                <h3 class="feature-two__title">Always On Time</h3>
                                <p class="feature-two__text">We value your time and always ensure our services are delivered promptly as scheduled.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="feature-two__single">
                            <div class="feature-two__icon">
                                <span class="icon-cleaning"></span>
                            </div>
                            <div class="feature-two__content">
                                <h3 class="feature-two__title">100% Satisfaction</h3>
                                <p class="feature-two__text">We guarantee your satisfaction with our services or we'll return to address any concerns.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-one team-page">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Our Professional Team</span>
                <h2 class="section-title__title">Meet the People Behind Our Success</h2>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="team-one__single">
                        <div class="team-one__img">
                            <img src="{{ asset('assets\images\safaraz\jessica.jpg') }}" alt="">
                            <ul class="list-unstyled team-one__social">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="team-one__content">
                            <div class="team-one__title-box">
                                <h3 class="team-one__name">Jessica Brown</h3>
                                <ul class="list-unstyled team-one__social-two">
                                    <li><a href="assets\images\safaraz\jessica.jpg"><i class="fas fa-share-alt"></i></a></li>
                                </ul>
                            </div>
                            <div class="team-one__sub-title-box">
                                <p class="team-one__sub-title">Founder & CEO</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="team-one__single">
                        <div class="team-one__img">
                            <img src="{{ asset('assets\images\safaraz\robert.jpg') }}" alt="">
                            <ul class="list-unstyled team-one__social">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="team-one__content">
                            <div class="team-one__title-box">
                                <h3 class="team-one__name">Robert Michael</h3>
                                <ul class="list-unstyled team-one__social-two">
                                    <li><a href="assets\images\safaraz\sarah.jpg"><i class="fas fa-share-alt"></i></a></li>
                                </ul>
                            </div>
                            <div class="team-one__sub-title-box">
                                <p class="team-one__sub-title">Operations Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="team-one__single">
                        <div class="team-one__img">
                            <img src="{{ asset('assets\images\safaraz\sarah.jpg') }}" alt="">
                            <ul class="list-unstyled team-one__social">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="team-one__content">
                            <div class="team-one__title-box">
                                <h3 class="team-one__name">Sarah Albert</h3>
                                <ul class="list-unstyled team-one__social-two">
                                    <li><a href="#"><i class="fas fa-share-alt"></i></a></li>
                                </ul>
                            </div>
                            <div class="team-one__sub-title-box">
                                <p class="team-one__sub-title">Team Lead</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="team-one__single">
                        <div class="team-one__img">
                            <img src="{{ asset('assets\images\safaraz\david.jpg') }}" alt="">
                            <ul class="list-unstyled team-one__social">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="team-one__content">
                            <div class="team-one__title-box">
                                <h3 class="team-one__name">David Cooper</h3>
                                <ul class="list-unstyled team-one__social-two">
                                    <li><a href="#"><i class="fas fa-share-alt"></i></a></li>
                                </ul>
                            </div>
                            <div class="team-one__sub-title-box">
                                <p class="team-one__sub-title">Customer Relations</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-one about-page-testimonial">
        <div class="testimonial-shape wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms"
            style="background-image: url({{ asset('assets\images\safaraz\sarah.jpg') }});">
        </div>
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Testimonials</span>
                <h2 class="section-title__title">What Our Clients Say</h2>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="testimonial-one__inner">
                        <div class="owl-carousel owl-theme thm-owl__carousel testimonial-one__carousel" data-owl-options='{
                            "loop": true,
                            "autoplay": true,
                            "margin": 30,
                            "nav": true,
                            "dots": false,
                            "smartSpeed": 500,
                            "autoplayTimeout": 10000,
                            "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                            "responsive": {
                                "0": {
                                    "items": 1
                                },
                                "768": {
                                    "items": 2
                                },
                                "992": {
                                    "items": 2
                                },
                                "1200": {
                                    "items": 2
                                }
                            }
                        }'>
                            <!-- Testimonial Item 1 -->
                            <div class="testimonial-one__single">
                                <p class="testimonial-one__text">Their cleaning service is exceptional. The team is thorough, professional, and always goes above and beyond. My home has never looked better!</p>
                                <div class="testimonial-one__client-details">
                                    <h3 class="testimonial-one__client-name">Kevin Martin</h3>
                                    <p class="testimonial-one__client-sub-title">Residential Client</p>
                                </div>
                                <div class="testimonial-one__client-img">
                                    <img src="{{ asset('assets\images\safaraz\sarah.jpg') }}" alt="">
                                    <div class="testimonial-one__client-img-boxs"></div>
                                </div>
                                <div class="testimonial-one__quote">
                                    <span class="icon-quote"></span>
                                </div>
                            </div>
                            
                            <!-- Testimonial Item 2 -->
                            <div class="testimonial-one__single">
                                <p class="testimonial-one__text">We've been using their commercial cleaning services for our office building for over 3 years. Consistently reliable and high-quality service every time.</p>
                                <div class="testimonial-one__client-details">
                                    <h3 class="testimonial-one__client-name">Jessica Brown</h3>
                                    <p class="testimonial-one__client-sub-title">Business Owner</p>
                                </div>
                                <div class="testimonial-one__client-img">
                                    <img src="{{ asset('assets\images\safaraz\sarah.jpg') }}" alt="">
                                    <div class="testimonial-one__client-img-boxs"></div>
                                </div>
                                <div class="testimonial-one__quote">
                                    <span class="icon-quote"></span>
                                </div>
                            </div>
                            
                            <!-- Testimonial Item 3 -->
                            <div class="testimonial-one__single">
                                <p class="testimonial-one__text">The attention to detail is what sets this cleaning service apart. They noticed and cleaned areas I didn't even think about. Highly recommended!</p>
                                <div class="testimonial-one__client-details">
                                    <h3 class="testimonial-one__client-name">Michael Johnson</h3>
                                    <p class="testimonial-one__client-sub-title">Homeowner</p>
                                </div>
                                <div class="testimonial-one__client-img">
                                    <img src="{{ asset('assets/images/testimonial/testimonial-1-3.jpg') }}" alt="">
                                    <div class="testimonial-one__client-img-boxs"></div>
                                </div>
                                <div class="testimonial-one__quote">
                                    <span class="icon-quote"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-one">
        <div class="container">
            <div class="cta-one__inner">
                <div class="cta-one-shape-1"></div>
                <div class="cta-one-shape-2"></div>
                <div class="cta-one-shape-3"></div>
                <div class="cta-one-shape-4"></div>
                <div class="cta-one-shape-5"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="cta-one__content">
                            <h2 class="cta-one__title">Ready to experience our professional cleaning services?</h2>
                            <div class="cta-one__btn-box">
                                <a href="{{ route('client.dashboard') }}" class="thm-btn cta-one__btn">Get Started Today <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Activate the About menu item
        $('.main-menu__list li').removeClass('current');
        $('.main-menu__list li:nth-child(2)').addClass('current');
    });
</script>
@endsection
