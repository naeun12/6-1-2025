@include('landingpage.partials.header')
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid navigation-style">
            <a class="navbar-brand text-black px-2" href="#">
                <img src="{{ asset('images/Logo/logo.png') }}" alt="Company Logo" width="75">
                <span class="ml-2 logo-text"> DormHub </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end align-content-end px-10" id="navbarNav">
                <ul class="navbar-nav gap-3 px-5 py-2">
                    <li class="nav-item">
                        <a class="nav-link nav-btn" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-btn" href="#about-us" id="aboutUsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            About Us
                        </a>
                        <ul class="dropdown-menu " aria-labelledby="aboutUsDropdown">
                            <li><a class="dropdown-item text-center text-black" href="#about-us">About Us</a></li>
                            <li><a class="dropdown-item text-center text-black" href="#ourteam"
                                    onclick="showOurTeam()">Our Team</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-btn" href="#contact-us">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-btn" href="#faqs">FAQS</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<style>

</style>
<!-- Include the Vite-compiled CSS and JS files -->
