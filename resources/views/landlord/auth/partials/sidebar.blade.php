@include('landlord.auth.partials.header')
<div class="col-md-2 bg-white sidebar py-3" id="sidebarMenu">
    <a class="navbar-brand d-flex align-items-center text-black">
        <img src="{{ asset('images/Logo/logo.png') }}" alt="Company Logo" width="100" class="me-2">
        <span class="logo-text fw-bold">DormHub</span>
    </a>
    <ul class="list-group list-group-flush py-3 ">
        <li class="list-group-item text-dark"><a href="{{ route('landlordDashboard') }}"
                class="text-decoration-none">Dashboard</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('landlordDormManagement', ['landlordId' => session('landlord_id')]) }}"
                class="text-decoration-none">
                Register Your Dorm
            </a>
        </li>

        <li class="list-group-item">
            <a href="{{ route('landlordRoomManagement', ['landlordId' => session('landlord_id')]) }} "
                class="text-decoration-none">
                Rooms Management
            </a>
        </li>

        <li class="list-group-item">
            <a class="d-flex justify-content-between align-items-center text-decoration-none text-dark"
                data-bs-toggle="collapse" href="#tenantManagementMenu" role="button" aria-expanded="false"
                aria-controls="tenantManagementMenu">
                Tenant Management
                <i class="bi bi-caret-down-fill"></i> <!-- Bootstrap Icons (optional) -->
            </a>
            <ul class="collapse list-unstyled ms-3 mt-2" id="tenantManagementMenu">
                <li><a href="{{ route('tenantScreening') }}" class="text-decoration-none">Tenant Screening</a></li>
                <li><a href="{{ route('tenant') }}" class="text-decoration-none">Rooms Tenants</a></li>
            </ul>
        </li>
        <li class="list-group-item"><a href="{{ route('BookingPage') }}" class="text-decoration-none">Booking &
                Reservations</a></li>

        <li class="list-group-item"><a href="{{ route('AnalyticsPage') }}" class="text-decoration-none">
                Analytics</a></li>
        <li class="list-group-item"><a href="{{ route('MessagingPage') }}" class="text-decoration-none">Messaging
                Center</a></li>
        <li class="list-group-item"><a href="{{ route('ReviewandFeedback') }}" class="text-decoration-none">Review &
                Feedback
                Page</a></li>
        <li class="list-group-item"><a href="{{ route('NotificationPage') }}" class="text-decoration-none">Notification
            </a></li>
    </ul>
</div>
<style>
    @media (max-width: 1265px) {
        .logo-text {
            display: none !important;
        }
    }

    @media (min-width: 1266px) {
        .logo-text {
            display: inline !important;
        }
    }
</style>
