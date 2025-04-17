@include('tenant.accountprocess.partials.navigation')
<main class="d-flex justify-content-center  align-items-center mb-5 py-5 mt-5">
    <div class="card mt-5 border-primary registration-container">


        @if (session('success'))
            <div class="alert alert-success text-center mt-5"><span>{{ session('success') }}</span></div>
        @endif

        <div class="title d-flex justify-content-center mt-5">
            <h3 class="text-primary fs-bold fw-bold text-wrap">Create a Tenant Account</h3>
        </div>
        <div id="TenantRegisterContainer">
            <tenant-register></tenant-register>

        </div>
        <p class="mt-3 text-center">
            Already have an account? <a class="text-primary" href="{{ route('login-tenant') }}">Login here</a>
        </p>
    </div>
</main>
<style>
    .registration-container {
        box-shadow: rgba(2, 2, 169, 0.25) 0px 50px 100px -20px, rgba(45, 5, 154, 0.3) 0px 30px 60px -30px, rgba(0, 45, 91, 0.35) 0px -2px 6px 0px inset;
    }
</style>
@include('tenant.accountprocess.partials.footer')
