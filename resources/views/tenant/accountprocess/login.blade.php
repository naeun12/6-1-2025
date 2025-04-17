@include('tenant.accountprocess.partials.navigation')


<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card border-primary shadow-lg" style="width: 700px; height:auto;">
        <div class="card-body  p-4">
            <h1 class="text-center mb-4 mt-4">Hello Tenant</h1>
            <form method="POST">
                @csrf
                <div class="containier mt-5">

                    <div class="mb-3 mt-3 d-flex justify-content-center align-items-center">
                        <input type="email" name="email" id="email" class="form-control w-75"
                            placeholder="Email Address" required>
                    </div>
                    <div class="mb-3 mt-4 d-flex justify-content-center">
                        <div class="input-group w-75">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password" required>
                            <span class="input-group-text bg-transparent border-start-0">
                                <i id="togglePassword" class="fas fa-eye fs-5" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="container d-flex justify-content-center">
                    <div class=" gap-2   w-50">
                        <button type="submit"
                            class="btn btn-primary rounded-pill d-flex justify-content-center align-items-center w-100">Sign
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
