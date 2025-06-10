@include('tenant.auth.partials.header')
@if (session('tenant_logged_in'))
    <nav class="navbar navbar-expand-lg navbar-light bg-light custom-navbar-border mb-1">
        <a class="navbar-brand d-flex align-items-center text-black" href="#">
            <img src="{{ asset('images/Logo/logo.png') }}" alt="Company Logo" width="100" class="me-2">
            <span class="logo-text fw-bold fs-4">DormHub</span>
        </a>
        <div class="container d-flex align-items-center justify-content-between">

            <!-- Logo -->


            <!-- Hamburger button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dorm Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Communication</a>
                    </li>
                </ul>
            </div>

            <!-- Right-side icons (Notification & User) -->

        </div>
        <div class="d-flex align-items-center gap-3">
            <!-- Notifications -->
            <div class="nav-item dropdown">
                <button class="btn p-0 border-0 bg-transparent nav-link dropdown-toggle d-flex align-items-center"
                    id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications"
                    style="cursor:pointer; width: 40px; height: 40px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-bell-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                    </svg>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg mt-2" aria-labelledby="notificationDropdown"
                    style="min-width: 300px;">
                    <!-- Notification items here -->
                </ul>
            </div>

            <!-- User Avatar -->
            <div class="dropdown">
                <a class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" href="#"
                    role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset(session('profile_pic_url')) }}" alt="User Avatar" width="45" height="45"
                        class="rounded-circle me-2">




                    <span class="username fw-semibold"> {{ session('tenant_firstname') }}
                        {{ session('tenant_lastname') }}</span>
                </a>
                <span class="username fw-semibold">
                    <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#contactModal">View
                                Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="dropdown-item" style="cursor: pointer;">Logout</button>
                            </form>
                        </li>
                    </ul>

            </div>
        </div>
    </nav>
@endif


<style>
    .custom-navbar-border {
        border: 2px solid #4edce2;
        border-radius: 6px;
    }

    .navbar-nav .nav-item {
        margin-left: 10px;
        margin-right: 10px;
    }

    .navbar-nav .nav-link {
        padding: 0.5rem 0.75rem;
    }

    .navbar-nav .dropdown-menu {
        padding: 0.5rem 0;
    }

    .btn .badge {
        font-size: 0.65rem;
        padding: 0.25em 0.4em;
    }
</style>
