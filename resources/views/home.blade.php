@extends('layouts.app')
@section('css')

@endsection
@section('content')


    <!-- banner section -->
    <section id="home" class="w3l-banner py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12 mt-lg-0 mt-4">
                    <span class="title-small">Hello</span>
                    <h1 class="mb-2 title"> <span>I'm</span> Alexander </h1>
                    <h1 class="mb-4 title"> a <span class="typed-text"></span><span class="cursor">&nbsp</span></h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, excepturi.
                        Distinctio accusantium fugit odit? Fugit ipsam. Sed ac fringilla ex. Nam mauris velit, ac
                        cursus quis, non leo.</p>
                    <div class="mt-sm-5 mt-4">
                        <a class="btn btn-primary btn-style mr-2" href="contact.html"> Hire Me </a>
                        <a class="btn btn-outline-primary btn-style mr-2" href="#portfolio"> Portfolio </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-10 mt-lg-0 mt-4">
                    <div class="img-effect text-lg-center">
                        <img src="{{ asset('mycss/qiantai/assets/images/photo.png') }}" alt="myphoto" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //banner section -->

    <!-- home page about section -->
    <section class="w3l-index3" id="about">
        <div class="midd-w3 py-5">
            <div class="container py-lg-5 py-md-3">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="position-relative">
                            <img src="assets/images/myphoto.jpg" alt="" class="radius-image img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-8 mt-lg-0 mt-5">
                        <h5 class="title-small mb-2">Who am i?</h5>
                        <h3 class="title-big">I'm Alexander Smith, a visual UI/UX Designer and Web Developer</h3>
                        <p class="mt-4">Lorem ipsum viverra feugiat. Pellen tesque libero ut justo,
                            ultrices in ligula. Semper at tempufddfel. Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Non quae, fugiat consequatur voluptatem nihil ad. Lorem ipsum dolor sit amet. Lorem ipsum
                            dolor sit, amet consectetur adipisicing elit. Dolor ipsum non velit reprehenderit, molestias
                            culpa!</p>
                        <a href="#download" class="btn btn-style btn-primary mt-lg-5 mt-4">Download CV</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //home page about section -->

    <!-- home page second section -->
    <div class="py-5 w3l-resume">
        <div class="container py-lg-5 py-3">
            <h5 class="title-small mb-2"> My resume</h5>
            <h3 class="title-big mb-4">I Would Love to make your Ideas real </h3>
            <p>I love graphic design and photography and have been working on my portfolio since 2016. You can download my
                resume in order to learn the details of my professional life as a designer and photographer. Contact me and
                we will discuss your projects!</p>
            <div class="mt-5">
                <a href="#download" class="btn btn-style btn-primary">Download resume</a>
            </div>
        </div>
    </div>
    <!-- //home page second section -->

    <!-- home page services section -->
    <section class="w3l-services">
        <div class="blog py-5" id="services">
            <div class="container py-lg-5">
                <h5 class="title-small text-center">Services</h5>
                <h3 class="title-big text-center mb-sm-5 mb-4">What I do for you</h3>
                <div class="row">
                    <div class="col-md-12 mx-auto pr-2">
                        <div class="owl-two owl-carousel owl-theme">
                            <div class="item">
                                <div class="card">
                                    <div class="box-wrap">
                                        <div class="icon">
                                            <span class="fa fa-pencil-square-o"></span>
                                        </div>
                                        <h4 class="number">01</h4>
                                        <h4><a href="#url">UI/UX Design</a></h4>
                                        <p>Lorem ipsum dolor sit amet sed consectetur adipisicing elit.
                                            doloret quas saepe autem, dolor set.</p>
                                        <a href="#read" class="read">Read more</a>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="box-wrap">
                                        <div class="icon">
                                            <span class="fa fa-laptop"></span>
                                        </div>
                                        <h4 class="number">02</h4>
                                        <h4><a href="#url">Web Development</a></h4>
                                        <p>Lorem ipsum dolor sit amet sed consectetur adipisicing elit.
                                            doloret quas saepe autem, dolor set.</p>
                                        <a href="#read" class="read">Read more</a>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="box-wrap">
                                        <div class="icon">
                                            <span class="fa fa-area-chart"></span>
                                        </div>
                                        <h4 class="number">03</h4>
                                        <h4><a href="#url">Research & Analysis</a></h4>
                                        <p>Lorem ipsum dolor sit amet sed consectetur adipisicing elit.
                                            doloret quas saepe autem, dolor set.</p>
                                        <a href="#read" class="read">Read more</a>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="box-wrap">
                                        <div class="icon">
                                            <span class="fa fa-pencil-square-o"></span>
                                        </div>
                                        <h4 class="number">04</h4>
                                        <h4><a href="#url">UI/UX Design</a></h4>
                                        <p>Lorem ipsum dolor sit amet sed consectetur adipisicing elit.
                                            doloret quas saepe autem, dolor set.</p>
                                        <a href="#read" class="read">Read more</a>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="box-wrap">
                                        <div class="icon">
                                            <span class="fa fa-laptop"></span>
                                        </div>
                                        <h4 class="number">05</h4>
                                        <h4><a href="#url">Web Development</a></h4>
                                        <p>Lorem ipsum dolor sit amet sed consectetur adipisicing elit.
                                            doloret quas saepe autem, dolor set.</p>
                                        <a href="#read" class="read">Read more</a>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="card">
                                    <div class="box-wrap">
                                        <div class="icon">
                                            <span class="fa fa-area-chart"></span>
                                        </div>
                                        <h4 class="number">06</h4>
                                        <h4><a href="#url">Research & Analysis</a></h4>
                                        <p>Lorem ipsum dolor sit amet sed consectetur adipisicing elit.
                                            doloret quas saepe autem, dolor set.</p>
                                        <a href="#read" class="read">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-more">
                    <p class="mt-4 pt-3 sample text-center">
                        <a href="services.html">View All Services <span class="pl-2 fa fa-long-arrow-right"></span></a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- //home page services section -->

    <!-- stats -->
    <section class="w3l-stats py-lg-5 py-4" id="stats">
        <div class="gallery-inner container py-md-5 py-4">
            <div class="row stats-con">
                <div class="col-sm-3 col-6 stats_info counter_grid">
                    <span class="fa fa-laptop"></span>
                    <p class="counter">700</p>
                    <h4>Completed projects</h4>
                </div>
                <div class="col-sm-3 col-6 stats_info counter_grid1">
                    <span class="fa fa-hourglass-end"></span>
                    <p class="counter">120</p>
                    <h4>In processes</h4>
                </div>
                <div class="col-sm-3 col-6 stats_info counter_grid mt-sm-0 mt-5">
                    <span class="fa fa-gift"></span>
                    <p class="counter">12</p>
                    <h4>Awards Received</h4>
                </div>
                <div class="col-sm-3 col-6 stats_info counter_grid2 mt-sm-0 mt-5">
                    <span class="fa fa-smile-o"></span>
                    <p class="counter">1050</p>
                    <h4>Happy Clients</h4>
                </div>
            </div>
        </div>
    </section>
    <!-- //stats -->
    <!-- testimonials -->
    <section class="w3l-clients" id="clients">
        <!-- /grids -->
        <div class="cusrtomer-layout py-5">
            <div class="container py-lg-5 py-md-4">
                <div class="heading text-center mx-auto">
                    <h6 class="title-small text-center">Testimonials</h6>
                    <h3 class="title-big mb-md-5 mb-4">What my clients think about Me </h3>
                </div>
                <!-- /grids -->
                <div class="testimonial-width">
                    <div id="owl-demo1" class="owl-carousel owl-theme mb-4">
                        <div class="item">
                            <div class="testimonial-content">
                                <div class="testimonial">
                                    <blockquote>
                                        <q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
                                            voluptate rem ullam dolore nisi voluptatibus esse quasi, doloribus tempora.
                                            Dolores molestias adipisci dolor sit amet!.</q>
                                    </blockquote>
                                    <div class="testi-des">
                                        <div class="test-img"><img src="assets/images/team1.jpg" class="img-fluid" alt="client-img">
                                        </div>
                                        <div class="peopl align-self">
                                            <h3>John wilson</h3>
                                            <p class="indentity">Seattle, Washington</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-content">
                                <div class="testimonial">
                                    <blockquote>
                                        <q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
                                            voluptate rem ullam dolore nisi voluptatibus esse quasi, doloribus tempora.
                                            Dolores molestias adipisci dolor sit amet!.</q>
                                    </blockquote>
                                    <div class="testi-des">
                                        <div class="test-img"><img src="assets/images/team2.jpg" class="img-fluid" alt="client-img">
                                        </div>
                                        <div class="peopl align-self">
                                            <h3>Julia sakura</h3>
                                            <p class="indentity">Seattle, Washington</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-content">
                                <div class="testimonial">
                                    <blockquote>
                                        <q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
                                            voluptate rem ullam dolore nisi voluptatibus esse quasi, doloribus tempora.
                                            Dolores molestias adipisci dolor sit amet!.</q>
                                    </blockquote>
                                    <div class="testi-des">
                                        <div class="test-img"><img src="assets/images/team3.jpg" class="img-fluid" alt="client-img">
                                        </div>
                                        <div class="peopl align-self">
                                            <h3>Roy Linderson</h3>
                                            <p class="indentity">Seattle, Washington</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-content">
                                <div class="testimonial">
                                    <blockquote>
                                        <q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
                                            voluptate rem ullam dolore nisi voluptatibus esse quasi, doloribus tempora.
                                            Dolores molestias adipisci dolor sit amet!.</q>
                                    </blockquote>
                                    <div class="testi-des">
                                        <div class="test-img"><img src="assets/images/team4.jpg" class="img-fluid" alt="client-img">
                                        </div>
                                        <div class="peopl align-self">
                                            <h3>Mike Thyson</h3>
                                            <p class="indentity">Seattle, Washington</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-content">
                                <div class="testimonial">
                                    <blockquote>
                                        <q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
                                            voluptate rem ullam dolore nisi voluptatibus esse quasi, doloribus tempora.
                                            Dolores molestias adipisci dolor sit amet!.</q>
                                    </blockquote>
                                    <div class="testi-des">
                                        <div class="test-img"><img src="assets/images/team2.jpg" class="img-fluid" alt="client-img">
                                        </div>
                                        <div class="peopl align-self">
                                            <h3>Laura gill</h3>
                                            <p class="indentity">Seattle, Washington</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-content">
                                <div class="testimonial">
                                    <blockquote>
                                        <q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
                                            voluptate rem ullam dolore nisi voluptatibus esse quasi, doloribus tempora.
                                            Dolores molestias adipisci dolor sit amet!.</q>
                                    </blockquote>
                                    <div class="testi-des">
                                        <div class="test-img"><img src="assets/images/team3.jpg" class="img-fluid" alt="client-img">
                                        </div>
                                        <div class="peopl align-self">
                                            <h3>Smith Johnson</h3>
                                            <p class="indentity">Seattle, Washington</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /grids -->
        </div>
        <!-- //grids -->
    </section>
    <!-- //testimonials -->

    <!-- home page video popup section -->
    <section class="w3l-index5" id="about">
        <div class="new-block py-5">
            <div class="container py-lg-5">
                <div class="middle-section text-center">
                    <div class="section-width">
                        <h3 class="title-big">I can give your business a new creative start right away! Hire me for your
                            Awesome project</h3>
                        <p class="mt-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. At, corrupti odit? At iure
                            facere,
                            porro repellat officia quas, dolores magnam assumenda soluta odit
                            harum
                            voluptate inventore ipsa maiores fugiat accusamus eos nulla. Iure voluptatibus explicabo
                            officia.</p>
                    </div>
                    <div class="history-info mt-5">
                        <div class="position-relative">
                            <img src="assets/images/bg.jpg" class="img-fluid radius-image video-popup-image"
                                 alt="video-popup">

                            <a href="#small-dialog" class="popup-with-zoom-anim play-view text-center position-absolute">
                            <span class="video-play-icon">
                                <span class="fa fa-play"></span>
                            </span>
                            </a>

                            <!-- dialog itself, mfp-hide class is required to make dialog hidden -->
                            <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
                                <iframe src="#" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- dialog itself, mfp-hide class is required to make dialog hidden -->
                    <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
                        <iframe src="#" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //home page video popup section -->

    <!-- freelance hire me -->
    <section class="w3l-grid-quote text-center py-5">
        <div class="container py-3">
            <h6 class="title-small">Get in touch</h6>
            <h3 class="title-big mb-md-5 mb-4">Let's start a Project! Hire Me.</h3>
            <a href="contact.html" class="btn btn-style btn-primary mr-2">Hire Me </a>
            <a href="contact.html" class="btn btn-style btn-outline-primary">Get in touch</a>
        </div>
    </section>
    <!-- //freelance hire me -->

    <!-- Footer -->
    <section class="w3l-footer py-sm-5 py-4">
        <div class="container">
            <div class="footer-content">
                <div class="row">
                    <div class="col-lg-8 footer-left">
                        <p class="m-0">Copyright &copy; 2021.Company name All rights reserved.<a target="_blank" href="https://sc.chinaz.com/moban/">&#x7F51;&#x9875;&#x6A21;&#x677F;</a></p>
                    </div>
                    <div class="col-lg-4 footer-right text-lg-right text-center mt-lg-0 mt-3">
                        <ul class="social m-0 p-0">
                            <li><a href="#facebook"><span class="fa fa-facebook-official"></span></a></li>
                            <li><a href="#linkedin"><span class="fa fa-linkedin-square"></span></a></li>
                            <li><a href="#instagram"><span class="fa fa-instagram"></span></a></li>
                            <li><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- move top -->
        <button onclick="topFunction()" id="movetop" title="Go to top">
            <span class="fa fa-angle-up"></span>
        </button>
        <!-- /move top -->
    </section>
@endsection
@section('js')

    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

    <!-- //Footer -->

    <!-- all js scripts and files here -->

    <script src="{{ asset('mycss/qiantai/assets/js/theme-change.js')}}"></script><!-- theme switch js (light and dark)-->

    <script  src="{{ asset('mycss/qiantai/assets/js/jquery-3.3.1.min.js')}}" ></script><!-- default jQuery -->

    <!-- /typig-text-->
    <script>
        const typedTextSpan = document.querySelector(".typed-text");
        const cursorSpan = document.querySelector(".cursor");

        const textArray = ["游戏开发者", "自由爱好者", "游戏设计爱好者"];
        const typingDelay = 200;
        const erasingDelay = 10;
        const newTextDelay = 100; // Delay between current and next text
        let textArrayIndex = 0;
        let charIndex = 0;

        function type() {
            if (charIndex < textArray[textArrayIndex].length) {
                if (!cursorSpan.classList.contains("typing")) cursorSpan.classList.add("typing");
                typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
                charIndex++;
                setTimeout(type, typingDelay);
            } else {
                cursorSpan.classList.remove("typing");
                setTimeout(erase, newTextDelay);
            }
        }

        function erase() {
            if (charIndex > 0) {
                // add class 'typing' if there's none
                if (!cursorSpan.classList.contains("typing")) {
                    cursorSpan.classList.add("typing");
                }
                typedTextSpan.textContent = textArray[textArrayIndex].substring(0, 0);
                charIndex--;
                setTimeout(erase, erasingDelay);
            } else {
                cursorSpan.classList.remove("typing");
                textArrayIndex++;
                if (textArrayIndex >= textArray.length) textArrayIndex = 0;
                setTimeout(type, typingDelay);
            }
        }

        document.addEventListener("DOMContentLoaded", function () { // On DOM Load initiate the effect
            if (textArray.length) setTimeout(type, newTextDelay + 250);
        });
    </script>
    <!-- //typig-text-->

    <!-- services owlcarousel -->
    <script src="{{ asset('mycss/qiantai/assets/js/owl.carousel.js')}}"></script>

    <!-- script for services -->
    <script>
        $(document).ready(function () {
            $('.owl-two').owlCarousel({
                loop: true,
                margin: 30,
                nav: false,
                responsiveClass: true,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplaySpeed: 1000,
                autoplayHoverPause: false,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    480: {
                        items: 1,
                        nav: false
                    },
                    700: {
                        items: 1,
                        nav: false
                    },
                    1090: {
                        items: 3,
                        nav: false
                    }
                }
            })
        })
    </script>
    <!-- //script for services -->

    <!-- script for tesimonials carousel slider -->
    <script>
        $(document).ready(function () {
            $("#owl-demo1").owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    736: {
                        items: 1,
                        nav: false
                    },
                    1000: {
                        items: 2,
                        nav: false,
                        loop: false
                    }
                }
            })
        })
    </script>
    <!-- //script for tesimonials carousel slider -->

    <!-- video popup -->
    <script src="{{ asset('mycss/qiantai/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.popup-with-zoom-anim').magnificPopup({
                type: 'inline',

                fixedContentPos: false,
                fixedBgPos: true,

                overflowY: 'auto',

                closeBtnInside: true,
                preloader: false,

                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            });

            $('.popup-with-move-anim').magnificPopup({
                type: 'inline',

                fixedContentPos: false,
                fixedBgPos: true,

                overflowY: 'auto',

                closeBtnInside: true,
                preloader: false,

                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-slide-bottom'
            });
        });
    </script>
    <!-- //video popup -->

    <!-- stats number counter-->
    <script src="{{ asset('mycss/qiantai/assets/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{ asset('mycss/qiantai/assets/js/jquery.countup.js')}}"></script>
    <script>
        $('.counter').countUp();
    </script>
    <!-- //stats number counter -->

    <!-- disable body scroll which navbar is in active -->
    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
            })
        });
    </script>
    <!-- disable body scroll which navbar is in active -->

@endsection
