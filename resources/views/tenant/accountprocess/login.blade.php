@include('tenant.accountprocess.partials.navigation')


<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card border-primary shadow-lg" style="width: 700px; height:auto;">
        <div class="card-body  p-4">
            <h1 class="text-center mb-4 mt-4 text-create">Hello Tenant</h1>
            <p class="text-center mb-4 text-muted">Welcome back! Please log in to explore available boarding houses and
                manage your bookings.</p>

            <form method="POST">
                @csrf
                <div class="row mt-4">
                    <div class="mt-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Email Address" required style="border: 2px solid #4edce2;">

                    </div>
                    <!-- Email Column -->

                    <!-- Password Column -->
                    <div class="mt-2">

                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password" required style="border: 2px solid #4edce2;">
                            <span class="input-group-text bg-transparent border-start-0"
                                style="border: 2px solid #4edce2;">
                                <i id="togglePassword" class="fas fa-eye fs-5" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>



        </div>
        <div class="container d-flex justify-content-center">
            <div class=" gap-2   w-50">
                <button type="submit"
                    class="btn rounded-pill d-flex justify-content-center align-items-center w-100">Sign
                    In</button>
            </div>
        </div>
        </form>
        <p class="text-center mt-5">
            Hello Tenant! Don't have an account?
            <a href="{{ route('register-tenant') }}" class="text-primary">Sign up here.</a>
        </p>


    </div>
</div>



<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>
@include('tenant.accountprocess.partials.footer')
