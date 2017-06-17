@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="{{ asset('public/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
<style media="screen">
  html, body{
    font-family: Raleway,sans-serif;
    font-size: 14px;
  }
</style>
@endsection

@section('content')
<!-- sub-header -->
    <div class="sub-header-nbc">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 hidden-sm hidden-xs trapezoid-container">
                  <div class="w3-content w3-sections">
                    <img class="mySlides w3-animate-left w3-animate-fading" src="{{ asset('images/homepage/1.jpg')}}">
                    <img class="mySlides w3-animate-left w3-animate-fading" src="{{ asset('images/homepage/2.jpg')}}">
                    <img class="mySlides w3-animate-left w3-animate-fading" src="{{ asset('images/homepage/3.jpg')}}">
                  </div>
                </div>
                <div class="col-md-7 pentagon-container hidden-sm hidden-xs">
                  <div class="col-md-12 pentagon">
                      <div class="sub-header-right-area">
                          <!-- <h1>RELIABLE-<span class="text-primary-nbc">QUALITY</span>-SAFETY</h1>
                          <p>
                              NoBorderClub provides the clients` professional service needs into satisfaction.
                              The "project coordinator" coordinates to the clients and associates` output to
                              ensure that both party`s provide the appropriate support towards their intended objectives.
                              Unlike other freelancer NoBorderClub has a coordinator who manages the clients`
                              project to meet their expectation.
                          </p> -->
                          <h1><span class="text-secondary-nbc">Sign up now</span></h1>
                          <div class="input-group">
                              <input type="text" class="form-control form-control-nbc-front" placeholder="What type of work do you need?">
                              <span class="input-group-btn">
                                  <button class="btn btn-primary-nbc" type="button">Get Started</button>
                              </span>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
<!-- /sub-header -->
<!-- body -->
    <!-- content -->
        <div class="section">
            <div class="container text-center">
                <div class="row">
                    <h1 class="title-secondary-nbc"><b>We have the right professional for your business</b></h1>
                    <div class="col-md-offset-3 col-md-6 title-underline">&nbsp;</div>
                    <div class="col-md-12 category-container">
                        <div class="row">
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/WebDev_Icon.svg') }}" class="wow bounceIn">
                                <h5>WEB DEVELOPMENT</h5>
                            </div>
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/IT-Program_Icon.svg') }}" class="wow bounceIn">
                                <h5>IT & PROGRAMMING</h5>
                            </div>
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/SoftwareDev_Icon.svg') }}" class="wow bounceIn">
                                <h5>SOFTWARE DEVELOPMENT</h5>
                            </div>
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/ArtsMedia_Icon.svg') }}" class="wow bounceIn">
                                <h5>ARTS & MEDIA</h5>
                            </div>
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/MobileDev_Icon.svg') }}" class="wow bounceIn">
                                <h5>MOBILE APPLICATIONS</h5>
                            </div>
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/Writing_Icon.svg') }}" class="wow bounceIn">
                                <h5>WRITING & CONTENT</h5>
                            </div>
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/SalesMarket_Icon.svg') }}" class="wow bounceIn">
                                <h5>SALES & MARKETING</h5>
                            </div>
                            <div class="col-md-3 category-box">
                                <img src="{{ asset('images/homepage/EngrScience_Icon.svg') }}" class="wow bounceIn">
                                <h5>ENGINEERING & SCIENCE</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <br>
                        <br>
                        <a href="" class="btn btn-primary-nbc" style="width: 200px">ALL CATEGORIES</a>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <div class="section background-primary-nbc">
            <div class="container text-center">
                <h1 class="title-primary-nbc "><b>Accomplish your project in 3 Easy Tips</b></h1>
                <div class="col-md-offset-3 col-md-6 title-underline">&nbsp;</div>
                <div class="hidden-sm hidden-xs col-md-offset-1 col-md-10 card-container">
                    <div class="col-md-4 card">
                        <div class="line">&nbsp;</div>
                        <div class="col-md-5 img-container">
                            <img class="img-responsive" src="{{ asset('images/homepage/Post_Icon.svg') }}" class="wow fadeInApp">
                        </div>
                        <div class="col-md-7 txt-container text-left">
                            <h3>POST</h3>
                            <p>Create project</p>
                        </div>
                    </div>
                    <div class="col-md-4 card">
                        <div class="line">&nbsp;</div>
                        <div class="col-md-5 img-container">
                            <img class="img-responsive" src="{{ asset('images/homepage/Matching_Icon.svg') }}">
                        </div>
                        <div class="col-md-7 txt-container text-left">
                            <h3>PICK</h3>
                            <p>Choose a worker</p>
                        </div>
                    </div>
                    <div class="col-md-4 card">
                        <div class="line">&nbsp;</div>
                        <div class="col-md-5 img-container">
                            <img class="img-responsive" src="{{ asset('images/homepage/Pay_Icon.svg') }}">
                        </div>
                        <div class="col-md-7 txt-container text-left">
                            <h3>DOWNLOAD</h3>
                            <p>Get your files</p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
        </div>

        <div class="section">
            <div class="container company-logos" style="min-height:300px;">
                <div class="col-md-4 logo-container">
                    <img class="img img-responsive" src="{{ asset('images/homepage/Empasys_Logo_Black.png') }}">
                </div>
                <div class="col-md-4 logo-container">
                    <img class="img img-responsive" src="{{ asset('images/homepage/FA_Inphisa_LOGO_2017_Dark.png') }}">
                </div>
                <div class="col-md-4 logo-container">
                    <img class="img img-responsive" src="{{ asset('images/homepage/FA_LOGO_MOTT_DARK.png') }}">
                </div>
            </div>
        </div>
    <!-- /content -->
<!-- /body -->


<!-- footer -->
    <div class="section background-footer-nbc">
        <div class="container">
            <div class="col-md-12 text-center">
              <h3>Follow us on</h3>
              <div class="social-container">
                <span class="fa fa-facebook"></span>
                <span class="fa fa-instagram"></span>
                <span class="fa fa-twitter"></span>
                <span class="fa fa-linkedin"></span>
                <span class="fa fa-youtube"></span>
              </div>
            </div>
            <div class="col-md-12 text-center">
                <p >
                     <a href="">Privacy</a> |
                     <a href="">Terms and Conditions</a> |
                     <a href="">Copyright Infrigement Policy</a> |
                     <a href="">Code of Conduct</a>
                </p>
            </div>
        </div>
    </div>
<!-- /footer -->
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
  $(function(){
    new WOW().init();
  });
</script>
<script>
  var myIndex = 0;

  carousel();

  function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      myIndex++;
      if (myIndex > x.length) {myIndex = 1}
      x[myIndex-1].style.display = "block";
      setTimeout(carousel, 5000);
  }
</script>
@endsection
