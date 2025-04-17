@include('tenant.accountprocess.partials.header')
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid navigation-style">
            <a class="navbar-brand text-black" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end align-content-end px-10" id="navbarNav">
                <ul class="navbar-nav gap-3 px-5 py-2">
                    <li class="nav-item">
                        <a class="nav-link nav-btn" aria-current="page" href="{{ route('landingpage') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-btn" href="{{ route('landingpage') }}">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-btn" href="{{ route('landingpage') }}">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-btn" href="{{ route('landingpage') }}">FAQS</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- Include the Vite-compiled CSS and JS files -->
