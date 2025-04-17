@include('tenant.accountprocess.partials.navigation')

<main class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container mt-5 b">
        <div class="row justify-content-center border-primary">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-center text-white">Verify Email account</div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <p>Please enter the verification OTP sent to your email.</p>
                        <p>Timer 1:20</p>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    document.querySelectorAll('.input-box').forEach((input, index, inputs) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus(); // Move focus to the next input
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && index > 0 && !input.value) {
                inputs[index - 1].focus(); // Move focus to the previous input
            }
        });
    });
</script>
@include('tenant.accountprocess.partials.footer')
