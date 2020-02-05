<!-- ========== HEADER ========== -->
<header id="header" class="u-header u-header--navbar-bg">
    <!-- Search -->
    <div id="searchPushTop" class="u-search-push-top">
      <div class="container position-relative">
        <div class="u-search-push-top__content">
          <!-- Close Button -->
          <button type="button" class="close u-search-push-top__close-btn"
                  aria-haspopup="true"
                  aria-expanded="false"
                  aria-controls="searchPushTop"
                  data-unfold-type="jquery-slide"
                  data-unfold-target="#searchPushTop">
            <span aria-hidden="true">×</span>
          </button>
          <!-- End Close Button -->

          <!-- Input -->
          <form class="js-focus-state input-group input-group-lg">
            <input type="search" class="form-control" placeholder="Search Front" aria-label="Search Front">
            <div class="input-group-append">
              <button type="button" class="btn btn-primary">Search</button>
            </div>
          </form>
          <!-- End Input -->

          <!-- Content -->
          <div class="row d-none d-md-flex mt-7">
            <div class="col-sm-6">
              <strong class="d-block mb-2">Quick Links</strong>

              <div class="row">
                <!-- List Group -->
                <div class="col-6">
                  <div class="list-group list-group-transparent list-group-flush list-group-borderless">
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      Search Results List
                    </a>
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      Search Results Grid
                    </a>
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      About
                    </a>
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      Services
                    </a>
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      Invoice
                    </a>
                  </div>
                </div>
                <!-- End List Group -->

                <!-- List Group -->
                <div class="col-6">
                  <div class="list-group list-group-transparent list-group-flush list-group-borderless">
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      Profile
                    </a>
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      User Contacts
                    </a>
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      Reviews
                    </a>
                    <a class="list-group-item list-group-item-action" href="#">
                      <span class="fas fa-angle-right list-group-icon"></span>
                      Settings
                    </a>
                  </div>
                </div>
                <!-- End List Group -->
              </div>
            </div>

            <div class="col-sm-6">
              <!-- Banner -->
              <div class="rounded u-search-push-top__banner">
                <div class="d-flex align-items-center">
                  <div class="u-search-push-top__banner-container">
                    <img class="img-fluid u-search-push-top__banner-img" src="../../assets/img/mockups/img3.png" alt="Image Description">
                    <img class="img-fluid u-search-push-top__banner-img" src="../../assets/img/mockups/img2.png" alt="Image Description">
                  </div>

                  <div>
                    <div class="mb-4">
                      <strong class="d-block mb-2">Featured Item</strong>
                      <p>Create astonishing web sites and pages.</p>
                    </div>
                    <a class="btn btn-xs btn-soft-success transition-3d-hover" href="index.html">Apply Now <span class="fas fa-angle-right ml-2"></span></a>
                  </div>
                </div>
              </div>
              <!-- End Banner -->
            </div>
          </div>
          <!-- End Content -->
        </div>
      </div>
    </div>
    <!-- End Search -->

    <div class="u-header__section gradient-half-primary-v1">
      <!-- Topbar -->
      <div class="container u-header__hide-content pt-2">
        <div class="d-flex align-items-center">
          <!-- Language -->
          <div class="position-relative">
            <a id="languageDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center" href="javascript:;" role="button"
               aria-controls="languageDropdown"
               aria-haspopup="true"
               aria-expanded="false"
               data-unfold-event="hover"
               data-unfold-target="#languageDropdown"
               data-unfold-type="css-animation"
               data-unfold-duration="300"
               data-unfold-delay="300"
               data-unfold-hide-on-scroll="true"
               data-unfold-animation-in="slideInUp"
               data-unfold-animation-out="fadeOut">
               <img class="dropdown-item-icon" src="{{ Theme::url('vendor/flag-icon-css/flags/4x3/us.svg') }}" alt="SVG">
              <span class="d-inline-block d-sm-none">US</span>
              <span class="d-none d-sm-inline-block">United States</span>
            </a>

            <div id="languageDropdown" class="dropdown-menu dropdown-unfold" aria-labelledby="languageDropdownInvoker">
              <a class="dropdown-item active" href="#">English</a>
              <a class="dropdown-item" href="#">Deutsch</a>
              <a class="dropdown-item" href="#">Español‎</a>
            </div>
          </div>
          <!-- End Language -->

          <div class="ml-auto">
            <!-- TODO: Jump To - MOBİL DE GÖZÜKÜYOR -->
            <div class="d-inline-block d-sm-none position-relative mr-2">
              <a id="jumpToDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center" href="javascript:;" role="button"
                 aria-controls="jumpToDropdown"
                 aria-haspopup="true"
                 aria-expanded="false"
                 data-unfold-event="hover"
                 data-unfold-target="#jumpToDropdown"
                 data-unfold-type="css-animation"
                 data-unfold-duration="300"
                 data-unfold-delay="300"
                 data-unfold-hide-on-scroll="true"
                 data-unfold-animation-in="slideInUp"
                 data-unfold-animation-out="fadeOut">
                Jump to
              </a>

              <div id="jumpToDropdown" class="dropdown-menu dropdown-unfold" aria-labelledby="jumpToDropdownInvoker">
                <a class="dropdown-item" href="../pages/help.html">Help</a>
                <a class="dropdown-item" href="../pages/contacts-agency.html">Contacts</a>
              </div>
            </div>
            <!-- End Jump To -->

            <!-- Links -->
            <!-- End Links -->
          </div>

          <ul class="list-inline ml-2 mb-0">
            <!-- Search -->
            <li class="list-inline-item">
              <a class="btn btn-xs btn-icon btn-text-secondary" href="javascript:;" role="button"
                      aria-haspopup="true"
                      aria-expanded="false"
                      aria-controls="searchPushTop"
                      data-unfold-type="jquery-slide"
                      data-unfold-target="#searchPushTop">
                <span class="fas fa-search btn-icon__inner"></span>
              </a>
            </li>
            <!-- End Search -->

            @auth
            <!-- Shopping Cart -->
            <li class="list-inline-item position-relative">
              <a id="shoppingCartDropdownInvoker" class="btn btn-xs btn-icon btn-text-secondary" href="javascript:;" role="button"
                      aria-controls="shoppingCartDropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                      data-unfold-event="hover"
                      data-unfold-target="#shoppingCartDropdown"
                      data-unfold-type="css-animation"
                      data-unfold-duration="300"
                      data-unfold-delay="300"
                      data-unfold-hide-on-scroll="true"
                      data-unfold-animation-in="slideInUp"
                      data-unfold-animation-out="fadeOut">
                <span class="fas fa-shopping-cart btn-icon__inner"></span>
              </a>

              <div id="shoppingCartDropdown" class="dropdown-menu dropdown-unfold dropdown-menu-right text-center p-7" aria-labelledby="shoppingCartDropdownInvoker" style="min-width: 250px;">
                <span class="btn btn-icon btn-soft-primary rounded-circle mb-3">
                  <span class="fas fa-shopping-basket btn-icon__inner"></span>
                </span>
                <span class="d-block">Your Cart is Empty</span>
              </div>
            </li>
            <!-- End Shopping Cart -->
            @endauth

            @auth
            <li class="list-inline-item position-relative">
                <!-- Account Dropdown -->
                <a id="account-dropdown-invoker" class="btn btn-xs btn-text-secondary u-sidebar--account__toggle-bg bg-white" href="javascript:;" role="button"
                aria-controls="account-dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                data-unfold-event="hover"
                data-unfold-target="#account-dropdown"
                data-unfold-type="css-animation"
                data-unfold-duration="300"
                data-unfold-delay="300"
                data-unfold-hide-on-scroll="true"
                data-unfold-animation-in="slideInUp"
                data-unfold-animation-out="fadeOut">
                <span class="u-sidebar--account__toggle-text">{{ Auth::user()->getName() }}</span>
                @if (Auth::user()->gravatar)
                    <img class="u-sidebar--account__toggle-img" src="{{ Auth::user()->gravatar }}">
                @endif
                </a>
                <!-- End Account Dropdown -->

                <div id="account-dropdown" class="dropdown-menu dropdown-unfold dropdown-menu-sm-right" aria-labelledby="account-dropdown-invoker">
                <a class="dropdown-item" href="{{ route('users.show_user', Auth::user()) }}">
                    <span class="fas fa-user-circle dropdown-item-icon"></span>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('users.current_user') }}">
                    <span class="fas fa-cog dropdown-item-icon"></span>
                    Settings
                </a>
                <a class="dropdown-item" href="{{ route('users.do_logout') }}">
                    <span class="fas fa-sign-out-alt dropdown-item-icon"></span>
                    Sign Out
                </a>
                </div>
            </li>
            @endauth
            @guest
            <!-- Account Login -->
            <li class="list-inline-item">
              <!-- Account Sidebar Toggle Button -->
              <a id="sidebarNavToggler" class="btn btn-xs btn-icon btn-text-secondary" href="javascript:;" role="button"
                 aria-controls="sidebarContent"
                 aria-haspopup="true"
                 aria-expanded="false"
                 data-unfold-event="click"
                 data-unfold-hide-on-scroll="false"
                 data-unfold-target="#sidebarContent"
                 data-unfold-type="css-animation"
                 data-unfold-animation-in="fadeInRight"
                 data-unfold-animation-out="fadeOutRight"
                 data-unfold-duration="500">
                <span class="fas fa-user-circle btn-icon__inner font-size-1"></span>
              </a>
              <!-- End Account Sidebar Toggle Button -->
            </li>
            <!-- End Account Login -->
            @endguest
          </ul>
        </div>
      </div>
      <!-- End Topbar -->

      <div id="logoAndNav" class="container">
        <!-- Nav -->
        <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space">
          <!-- Logo -->
          <a class="navbar-brand u-header__navbar-brand u-header__navbar-brand-default" href="index.html" aria-label="Front">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="46px" height="46px" viewBox="0 0 46 46" xml:space="preserve" style="margin-bottom: 0;">
              <path fill="#3F7DE0" opacity=".65" d="M23,41L23,41c-9.9,0-18-8-18-18v0c0-9.9,8-18,18-18h11.3C38,5,41,8,41,11.7V23C41,32.9,32.9,41,23,41z"/>
              <path class="fill-info" opacity=".5" d="M28,35.9L28,35.9c-9.9,0-18-8-18-18v0c0-9.9,8-18,18-18l11.3,0C43,0,46,3,46,6.6V18C46,27.9,38,35.9,28,35.9z"/>
              <path class="fill-primary" opacity=".7" d="M18,46L18,46C8,46,0,38,0,28v0c0-9.9,8-18,18-18h11.3c3.7,0,6.6,3,6.6,6.6V28C35.9,38,27.9,46,18,46z"/>
              <path class="fill-white" d="M17.4,34V18.3h10.2v2.9h-6.4v3.4h4.8v2.9h-4.8V34H17.4z"/>
            </svg>
            <span class="u-header__navbar-brand-text">SroCMS</span>
          </a>
          <!-- End Logo -->

          <!-- Responsive Toggle Button -->
          <button type="button" class="navbar-toggler btn u-hamburger"
                  aria-label="Toggle navigation"
                  aria-expanded="false"
                  aria-controls="navBar"
                  data-toggle="collapse"
                  data-target="#navBar">
            <span id="hamburgerTrigger" class="u-hamburger__box">
              <span class="u-hamburger__inner"></span>
            </span>
          </button>
          <!-- End Responsive Toggle Button -->

          <!-- Navigation -->
          <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
            <ul class="navbar-nav u-header__navbar-nav">
                @include ('components.navbar.menus')
            </ul>
          </div>
          <!-- End Navigation -->
        </nav>
        <!-- End Nav -->
      </div>
    </div>
  </header>
  <!-- ========== END HEADER ========== -->

  <!-- Account Sidebar Navigation -->
  <aside id="sidebarContent" class="u-sidebar" aria-labelledby="sidebarNavToggler">
    <div class="u-sidebar__scroller">
      <div class="u-sidebar__container">
        <div class="u-header-sidebar__footer-offset">
          <!-- Toggle Button -->
          <div class="d-flex align-items-center pt-4 px-7">
            <button type="button" class="close ml-auto"
                    aria-controls="sidebarContent"
                    aria-haspopup="true"
                    aria-expanded="false"
                    data-unfold-event="click"
                    data-unfold-hide-on-scroll="false"
                    data-unfold-target="#sidebarContent"
                    data-unfold-type="css-animation"
                    data-unfold-animation-in="fadeInRight"
                    data-unfold-animation-out="fadeOutRight"
                    data-unfold-duration="500">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!-- End Toggle Button -->

          <!-- Content -->
          <div class="js-scrollbar u-sidebar__body">
            <div class="u-sidebar__content u-header-sidebar__content">
              <form class="js-validate">
                <!-- Login -->
                <div id="login" data-target-group="idForm">
                  <!-- Title -->
                  <header class="text-center mb-7">
                    <h2 class="h4 mb-0">Welcome Back!</h2>
                    <p>Login to manage your account.</p>
                  </header>
                  <!-- End Title -->

                  <!-- Form Group -->
                  <div class="form-group">
                    <div class="js-form-message js-focus-state">
                      <label class="sr-only" for="signinEmail">Email</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="signinEmailLabel">
                            <span class="fas fa-user"></span>
                          </span>
                        </div>
                        <input type="email" class="form-control" name="email" id="signinEmail" placeholder="Email" aria-label="Email" aria-describedby="signinEmailLabel" required
                               data-msg="Please enter a valid email address."
                               data-error-class="u-has-error"
                               data-success-class="u-has-success">
                      </div>
                    </div>
                  </div>
                  <!-- End Form Group -->

                  <!-- Form Group -->
                  <div class="form-group">
                    <div class="js-form-message js-focus-state">
                      <label class="sr-only" for="signinPassword">Password</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="signinPasswordLabel">
                            <span class="fas fa-lock"></span>
                          </span>
                        </div>
                        <input type="password" class="form-control" name="password" id="signinPassword" placeholder="Password" aria-label="Password" aria-describedby="signinPasswordLabel" required
                               data-msg="Your password is invalid. Please try again."
                               data-error-class="u-has-error"
                               data-success-class="u-has-success">
                      </div>
                    </div>
                  </div>
                  <!-- End Form Group -->

                  <div class="d-flex justify-content-end mb-4">
                    <a class="js-animation-link small link-muted" href="javascript:;"
                       data-target="#forgotPassword"
                       data-link-group="idForm"
                       data-animation-in="slideInUp">Forgot Password?</a>
                  </div>

                  <div class="mb-2">
                    <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Login</button>
                  </div>

                  <div class="text-center mb-4">
                    <span class="small text-muted">Do not have an account?</span>
                    <a class="js-animation-link small" href="javascript:;"
                       data-target="#signup"
                       data-link-group="idForm"
                       data-animation-in="slideInUp">Signup
                    </a>
                  </div>

                  <div class="text-center">
                    <span class="u-divider u-divider--xs u-divider--text mb-4">OR</span>
                  </div>

                  <!-- Login Buttons -->
                  <div class="d-flex">
                    <a class="btn btn-block btn-sm btn-soft-facebook transition-3d-hover mr-1" href="#">
                      <span class="fab fa-facebook-square mr-1"></span>
                      Facebook
                    </a>
                    <a class="btn btn-block btn-sm btn-soft-google transition-3d-hover ml-1 mt-0" href="#">
                      <span class="fab fa-google mr-1"></span>
                      Google
                    </a>
                  </div>
                  <!-- End Login Buttons -->
                </div>
              </form>
            </div>
          </div>
          <!-- End Content -->
        </div>

        <!-- Footer -->
        <footer id="SVGwaveWithDots" class="svg-preloader u-sidebar__footer u-sidebar__footer--account">
          <ul class="list-inline mb-0">
            <li class="list-inline-item pr-3">
              <a class="u-sidebar__footer--account__text" href="../pages/privacy.html">Privacy</a>
            </li>
            <li class="list-inline-item pr-3">
              <a class="u-sidebar__footer--account__text" href="../pages/terms.html">Terms</a>
            </li>
            <li class="list-inline-item">
              <a class="u-sidebar__footer--account__text" href="../pages/help.html">
                <i class="fas fa-info-circle"></i>
              </a>
            </li>
          </ul>

          <!-- SVG Background Shape -->
          <div class="position-absolute right-0 bottom-0 left-0">
            <img class="js-svg-injector" src="../../assets/svg/components/wave-bottom-with-dots.svg" alt="Image Description"
                   data-parent="#SVGwaveWithDots">
          </div>
          <!-- End SVG Background Shape -->
        </footer>
        <!-- End Footer -->
      </div>
    </div>
  </aside>
  <!-- End Account Sidebar Navigation -->
