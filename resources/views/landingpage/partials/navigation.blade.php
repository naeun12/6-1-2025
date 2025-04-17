@include('landingpage.partials.header')
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid navigation-style">
            <a class="navbar-brand text-black px-3" href="#">
                <img src="{{ asset('images/Logo/logo.png') }}" alt="Company Logo" width="75">
                <span class="ml-3"
                    style="font-family: 'Poppins', sans-serif; font-weight: bold; font-size: 24px; color: #2c3e50; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1); letter-spacing: 1px;">
                    DormHub
                </span>
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
                    <li class="nav-item">
                        <a class="nav-link nav-btn" href="#about-us">About us</a>
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
<!-- Include the Vite-compiled CSS and JS files -->
