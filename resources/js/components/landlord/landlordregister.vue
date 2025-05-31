<template>

    <form @submit.prevent="nextStep">
        <div v-if="LoaderSendingEmail" class="loader-overlay animated-fade">
            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                <!-- Bootstrap spinner -->
                <div class="spinner-border text-primary mb-3" role="status" style="width: 4rem; height: 4rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <p class="mt-3 text-muted animated-text">Loading, {{ emailMessage }}</p>
            </div>
        </div>

        <!-- Steps Navigation -->
        <div class="nav-pills w-100 bg-info">
            <ul class="nav mb-3 justify-content-center flex-wrap">
                <li class="" v-for="(step, index) in steps" :key="index">
                    <button class="btn btn-primary m-2" :class="{ active: currentStep === index }"
                        :disabled="index > currentStep">
                        {{ step }}
                    </button>
                </li>
            </ul>
        </div>



        <!-- Step Content -->
        <div class="tab-content">
            <!-- Step 1: Information -->
            <div v-if="currentStep === 0">
                <h2 class="text-center mb-4 text-create  mt-5">Create Your Landlord Account</h2>

                <div class="d-flex justify-content-center container-image ">

                    <div class="avatar-wrapper text-center">
                        <img class="profile-pic rounded-circle" :src="previewPic" alt="Profile Picture" width="150" />
                        <div class="upload-button btn btn-primary mt-3" @click="triggerProfileInput">
                            Upload Image
                            <input ref="fileInput" class="file-input" name="profile_pic" id="profile-pic" type="file"
                                accept="image/*" style="display: none;" @change="handleImageUpload" />

                        </div>


                    </div>



                </div>
                <div v-if="errors.profilePic" class="alert alert-danger text-center">
                    <span class="text-black  fs-bold">
                        {{ errors.profilePic[0] }}
                    </span>
                </div>


                <div class=" row mb-3">
                    <div class="col">
                        <label for="firstname" class="form-label">Firstname</label>
                        <input type="text" class="form-control" placeholder="Enter your firstname" v-model="firstname"
                            style="border: 2px solid #4edce2;" id="firstname" name="firstname" />

                        <span v-if="errors.firstname" class="text-danger">
                            {{ errors.firstname[0] }}
                        </span>


                    </div>
                    <div class="col">
                        <label for="lastname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" placeholder="Enter your lastname" v-model="lastname"
                            style="border: 2px solid #4edce2;" name="lastname" id="lastname" />
                        <span v-if="errors.lastname" class="text-danger">
                            {{ errors.lastname[0] }}
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter your Email Address" v-model="email" autocomplete="email"
                        style="border: 2px solid #4edce2;" />
                    <span v-if="errors.email" class="text-danger">
                        {{ errors.email[0] }}
                    </span>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter your Password" v-model="password"
                            style="border: 2px solid #4edce2;" name="password" id="password" />
                        <span v-if="errors.password" class="text-danger">
                            {{ errors.password[0] }}
                        </span>
                    </div>
                    <div class="col">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Confirm Password"
                            v-model="password_confirmation" name="password_confirmation"
                            style="border: 2px solid #4edce2;" id="password_confirmation" />
                        <span v-if="errors.password_confirmation" class="text-danger">
                            {{ errors.password_confirmation[0] }}
                        </span>

                    </div>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" id="showpassword" @click="showpassword" />
                    <label for="showpassword" class="mb-0">Show Password</label>
                </div>

                <div class=" mb-3">
                    <label for="phonenumber" class="form-label">Phone Number</label>
                    <input type="tel" id="phonenumber" class="form-control" placeholder="Enter your Phone Number"
                        v-model="phonenumber" style="border: 2px solid #4edce2;" name="phonenumber" />
                    <span v-if="errors.phonenumber" class="text-danger">
                        {{ errors.phonenumber[0] }}
                    </span>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" aria-label="Select Gender" name="gender" v-model="gender" id="gender"
                        style="border: 2px solid #4edce2;">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <span v-if="errors.gender" class="text-danger">
                        {{ errors.gender[0] }}
                    </span>
                </div>

            </div>
            <div class=" modal-overlay py-5 mt-5 " v-if="PersonalDetailsModal">
                <div class=" modal-container ">

                    <div class=" confirmation-box mb-5">
                        <h2 class="mb-5 mt-3"></h2>

                        <svg class="checkmark mb-5" viewBox="0 0 52 52">
                            <circle class="checkmark-circle" fill="none" stroke="#e74c3c" stroke-width="5" cx="26"
                                cy="26" r="24" />
                            <path class="checkmark-check" fill="none" stroke="#e74c3c" stroke-width="5"
                                d="M16 16l20 20 M16 36l20 -20" />
                        </svg>
                        <h3 class="mb-5">{{ this.errorMessage }}</h3>
                        <button class="btn w-50" @click="PersonalDetailsErrorsModal">OK</button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Government ID -->
            <div v-if="currentStep === 1">
                <h2 class="text-center mb-2 text-create">Upload Government ID</h2>
                <div class="d-flex justify-content-center mb-0">
                    <div class="file-upload">
                        <div class="image-upload-wrap" @click="triggerGovIdInput">
                            <input ref="govIdInput" class="file-upload-input" type="file" accept="image/*"
                                @change="handleGovermentIdUpload" />
                            <div class="drag-text">
                                <h3>Drag and drop a Government ID</h3>
                            </div>
                        </div>

                        <!-- Image Preview Container -->
                        <div class="file-upload-content" v-if="govermentIdPicPreview">
                            <img class="file-upload-image" :src="govermentIdPicPreview" alt="Uploaded ID">

                            <div class="image-title-wrap">
                                <button type="button" @click="removeGovermentPermitPic" class="remove-image">
                                    Remove <span class="image-title">Uploaded Image</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Step 3: Business Permit -->
            <div v-if="currentStep === 2">
                <h2 class="text-center mb-0  text-create">Upload Business Permit</h2>
                <div class="d-flex justify-content-center mb-0">
                    <div class="file-upload">
                        <div class="image-upload-wrap" @click="triggerBusinessPermitInput">
                            <input ref="businessPermitInput" class="file-upload-input" type="file" accept="image/*"
                                @change="handleBusinessPermitUpload" />
                            <div class="drag-text">
                                <h3>Drag and drop a Business Permit</h3>
                            </div>
                        </div>

                        <!-- Image Preview Container -->
                        <div class="file-upload-content" v-if="businessIdPicPreview">
                            <img class="file-upload-image" :src="businessIdPicPreview" alt="Uploaded ID">

                            <div class="image-title-wrap">
                                <button type="button" @click="removeBusinessPermitPic" class="remove-image">
                                    Remove <span class="image-title">Uploaded Image</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <!-- Step 4: OTP -->
            <div v-if="currentStep === 3" class="custom-modal d-flex justify-content-center align-items-center w-100 ">
                <div class="modal-wrapper text-center w-75">

                    <h2 class="mb-4 text-create">OTP Verification</h2>
                    <p class="mb-4">Please enter the verification OTP sent to your email.</p>
                    <!-- OTP Inputs -->
                    <div class="otp-inputs d-flex justify-content-center gap-2 mb-5 ">
                        <input v-for="(digit, index) in otpdigits" :key="index" type="text" :ref="'otpInput' + index"
                            maxlength="1" class="form-control text-center fs-4" name="codeotp"
                            v-model="otpdigits[index]" @input="handleInput(index)"
                            @keydown.backspace="handleBackspace(index)" required
                            style="width: 50px; height: 50px; border: 2px solid #4edce2;" />
                    </div>

                    <!-- OTP Timer -->
                    <div class=" otp_timer mb-4">
                        <p class="primary" v-if="otpTimer > 0">OTP expires in: {{ formattedTime }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="modal-actions d-flex justify-content-center gap-3 mb-3">
                        <button type="button" @click="RegisterLandlord" class="btn px-4">Sign-in</button>
                        <button type="button" @click="resendOtp" class="btn t px-4">Resend
                            OTP</button>


                    </div>
                </div>
            </div>


        </div>

        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between mt-4  text-create">
            <button type="button" class="btn " @click="prevStep" :disabled="currentStep === 0">
                Previous
            </button>
            <button type="button" class="btn" @click="nextStep" :disabled="currentStep === steps.length - 1">
                Next
            </button>
        </div>
    </form>
    <!-- Already have an account? Link -->

    <div :class="['container-toast mt-5', { show: toaster }]" v-show="toaster">
        <!-- Toast Container -->
        <div :class="['toast-child', `bg-${toastColor}`]">
            <div class="toast-body d-flex justify-content-between align-items-center text-white fw-bold py-3 px-4">
                <span class="text-wrap">{{ this.Message }}</span>
                <button type="button" class="btn-close btn-close-white ms-3" @click="ExitToaster"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</template>
<script>
import { data } from '@maptiler/sdk';
import axios from 'axios';

export default {

    name: 'LandlordRegister',
    data() {
        return {
            //images
            previewPic: "/images/registertenant/Profile-PNG-Photo.png",
            govermentIdPicPreview: "",
            businessIdPicPreview: "",
            //messages, modals and toaster
            successMessage: "",
            errorMessage: "",
            Message: "",
            RegisterModal: false,
            PersonalDetailsModal: false,
            toaster: false,
            toastColor: "",
            errors: {},
            //steps
            steps: ["Personal Details", "Identity Verification", "Business Documentation", "Email Verification"],
            currentStep: 0,
            //data
            firstname: "",
            lastname: "",
            email: "",
            password: "",
            password_confirmation: "",
            phonenumber: "",
            gender: "",
            profilePic: "",
            governmentIdFile: "",
            businessPermitFile: "",
            //loader and otp
            LoaderSendingEmail: false,
            emailMessage: "",
            otpTimer: 0,
            otpdigits: Array(6).fill(''),

        };
    },
    //timer
    methods: {
        formattedTime() {

            const minutes = Math.floor(this.otpTimer / 60);
            const seconds = this.otpTimer % 60;
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        },
    },
    methods: {
        //Steps 1 to 4
        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                let isValid = true;

                if (this.currentStep === 0) {
                    isValid = this.PersonalDetails();



                } else if (this.currentStep === 1) {
                    isValid = this.IdentityVerification();
                }
                else if (this.currentStep === 2) {
                    this.LoaderSendingEmail = true;
                    this.emailMessage = "Sending Email";
                    isValid = this.BusinessDocumentation();
                }


            }
        },

        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
            }
        },
        goToStep(index) {
            if (index <= this.currentStep) {
                this.currentStep = index;
            }
        },
        // image handler
        //profilePic
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.profilePic = file;
                this.previewPic = URL.createObjectURL(file);


            } else {
                this.previewPic = "/images/registertenant/Profile-PNG-Photo.png";
            }
        },
        triggerProfileInput() {
            if (this.$refs.fileInput) {
                this.$refs.fileInput.click();
            }
        },
        //GovermentId Picture
        handleGovermentIdUpload(event) {
            const file = event.target.files[0];
            if (file) {
                if (this.govermentIdPicPreview) {
                    URL.revokeObjectURL(this.govermentIdPicPreview);
                }
                this.governmentIdFile = file;
                this.govermentIdPicPreview = URL.createObjectURL(file);
            }
        },
        removeGovermentPermitPic() {
            if (this.govermentIdPicPreview) {
                URL.revokeObjectURL(this.govermentIdPicPreview);
                this.govermentIdPicPreview = "";
                this.governmentIdFile = "";

            }
            this.govermentIdPicPreview = "";
            this.governmentIdFile = "";


            if (this.$refs.govIdInput) {
                this.$refs.govIdInput.value = ''; // Reset file input
            }
        },
        //Business Permit Picture
        handleBusinessPermitUpload(event) {
            const file = event.target.files[0];
            if (file) {
                // Create object URL and revoke previous one if exists
                if (this.businessIdPicPreview) {
                    URL.revokeObjectURL(this.businessIdPicPreview);
                }
                this.businessPermitFile = file;

                this.businessIdPicPreview = URL.createObjectURL(file);
            }
        },
        triggerBusinessPermitInput() {
            if (this.$refs.businessPermitInput) {
                this.$refs.businessPermitInput.click();
            }
        },
        triggerGovIdInput() {
            if (this.$refs.govIdInput) {
                this.$refs.govIdInput.click();
            }
        },
        removeBusinessPermitPic() {
            if (this.businessIdPicPreview) {
                URL.revokeObjectURL(this.businessIdPicPreview);
            }
            this.businessIdPicPreview = null;
            // Add null check for safety
            if (this.$refs.businessIdPicPreview) {
                this.$refs.businessIdPicPreview.value = ''; // Reset file input
            }
        },
        //validations 
        PersonalDetailsValidation() {
            this.errors = {};
            // Validate each field
            if (!this.firstname) this.errors.firstname = ["Firstname is required."];
            if (!this.lastname) this.errors.lastname = ["Lastname is required."];
            if (!this.email) this.errors.email = ["Email is required."];
            if (!this.password) this.errors.password = ["Password is required."];
            if (!this.phonenumber) this.errors.phonenumber = ["Phone Number is required."];
            if (!this.gender) this.errors.gender = ["Gender is required."];
            if (!this.profilePic) this.errors.profilePic = ["Profile Picture is required."];
            return Object.keys(this.errors).length === 0;
        },
        //Input Data
        //personal Details
        async PersonalDetails() {
            const formData = new FormData();
            formData.append('firstname', this.firstname.trim());
            formData.append('lastname', this.lastname.trim());
            formData.append('email', this.email.trim());
            formData.append('phonenumber', this.phonenumber.trim());
            formData.append('password', this.password.trim());
            formData.append('password_confirmation', this.password_confirmation.trim());
            formData.append("profilePic", this.profilePic);
            try {
                if (this.PersonalDetailsValidation()) {
                    const response = await axios.post('/personalDetails', formData, {
                        headers: {
                            // DON'T set Content-Type when using FormData
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.data.status === 'success') {
                        this.currentStep = 1;
                        return true;
                    }
                    else {
                        this.PersonalDetailsModal = true;
                        this.errorMessage = "Oops! It looks like you missed some fields. Please fill out everything we need.";
                    }


                }
                else {
                    this.PersonalDetailsModal = true;
                    this.errorMessage = "Oops! It looks like you missed some fields. Please fill out everything we need.";
                }
            } catch (error) {
                console.clear();
                if (error.response) {
                    if (error.response.status === 422) {
                        this.PersonalDetailsModal = true;
                        this.errorMessage = "Oops! Something doesn't look right. Please double-check your entries.";
                        this.errors = error.response.data.errors || {};
                    } else {

                        this.PersonalDetailsModal = true;
                        this.errorMessage = error.response.data;
                    }
                }
            }
        },
        //Identify Verifaction
        async IdentityVerification() {
            const formData = new FormData();

            formData.append('governmentIdPic', this.governmentIdFile);
            try {
                const response = await axios.post('/IdentityVerifaction', formData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (response.data.status === "success") {
                    this.currentStep = 2;

                    return true;
                }
            }
            catch (error) {
                if (error.response) {
                    if (error.response.status === 422) {
                        console.log('Validation errors:', error.response.data.errors);
                        this.PersonalDetailsModal = true;
                        this.errorMessage = "Oops! Something doesn't look right. Please double-check your entries.";
                        this.errors = error.response.data.errors || {};
                    } else {
                        console.error('Registration error:', error.response.data);
                    }
                } else {
                    console.error('Network error:', error.message);
                }
            }
            return true;
        },

        //Business Documentation
        async BusinessDocumentation() {
            const formData = new FormData();
            formData.append('businessPermitPic', this.businessPermitFile);
            formData.append('email', this.email);

            try {
                const response = await axios.post('/businessPermitValidation', formData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (response.data.status === "success") {
                    this.toaster = true;
                    this.Message = response.data.message;
                    this.toastColor = "success";
                    this.startOtpTimer(response.data.timer);

                    this.currentStep = 3;
                    return true;
                }
                else if (response.data.status === "error") {
                    this.toaster = true;
                    this.Message = response.data.message;
                    this.toastColor = "danger";
                }
            }
            catch (error) {
                if (error.response) {
                    if (error.response.status === 422) {
                        this.PersonalDetailsModal = true;
                        this.errorMessage = "Oops! Something doesn't look right. Please double-check your entries.";
                        this.errors = error.response.data.errors || {};
                    } else {
                        console.error('Registration error:', error.response.data);
                    }
                } else {
                    console.error('Network error:', error.message);
                }
            }
            finally {
                this.LoaderSendingEmail = false;
            }
            return false;
        },
        //Register Landlord
        async RegisterLandlord() {
            const formData = new FormData();
            formData.append('firstname', this.firstname.trim());
            formData.append('lastname', this.lastname.trim());
            formData.append('email', this.email.trim());
            formData.append('password', this.password.trim());
            formData.append('password_confirmation', this.password_confirmation.trim());
            formData.append('phonenumber', this.phonenumber.trim());
            formData.append('gender', this.gender);
            formData.append("profilePic", this.profilePic);
            formData.append('governmentIdPic', this.governmentIdFile);
            formData.append('businessPermitPic', this.businessPermitFile);
            formData.append('codeotp', this.otpdigits.join(''));
            try {
                const response = await axios.post('/RegisterLandlord', formData, {
                    headers: {
                        // DON'T set Content-Type when using FormData
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (response.data.status === "success") {
                    this.toaster = true;
                    this.Message = response.data.message;
                    this.toastColor = "success";
                    this.Emptyfill();
                    this.currentStep = 0;
                    return true;
                }
            }
            catch (error) {
                if (error.response) {
                    const response = error.response;
                    if (response.data.status === "error") {
                        this.toaster = true;
                        this.Message = response.data.message;
                        this.toastColor = "danger";
                    }
                } else {
                    this.toaster = true;
                    this.Message = response.data.message;
                    this.toastColor = "danger";
                }
            }
            return false;

        },
        //modal and Toast
        //Toaster
        ExitToaster() {
            this.toastColor = "";
            this.toaster = false;
            this.Message = "";
        },

        //Personal Details Modal
        PersonalDetailsErrorsModal() {
            this.PersonalDetailsModal = false;
        },
        //Timer and OTP
        startOtpTimer(timerValue) {
            const expirationTime = new Date(timerValue);
            const currentTime = new Date();
            let remainingSeconds = Math.floor((expirationTime - currentTime) / 1000);

            this.otpTimer = remainingSeconds;

            if (this.otpInterval) {
                clearInterval(this.otpInterval);
            }

            this.otpInterval = setInterval(() => {
                if (remainingSeconds <= 0) {
                    clearInterval(this.otpInterval);
                    this.otpTimer = 0;
                } else {
                    this.otpTimer = remainingSeconds;
                    remainingSeconds--;
                }
            }, 1000);
        },
        startTimer() {
            this.intervalId = setInterval(() => {
                if (this.otpTimer > 0) {
                    this.otpTimer--;
                } else {
                    this.stopTimer();
                }
            }, 1000);
        },
        stopTimer() {
            clearInterval(this.intervalId);
        },
        resetTimer() {
            this.otpTimer = 60;
            this.startTimer();
        },
        mounted() {
            this.startTimer();
        },
        beforeUnmount() {
            this.stopTimer();
        },
        handleInput(index) {
            const currentInput = this.otpdigits[index];
            if (currentInput.length === 1 && index < 5) {
                this.$refs[`otpInput${index + 1}`]?.focus();
            }
        },
        getOtpCode() {
            return this.otpDigits.join('');
        },

        async resendOtp() {

            try {
                this.LoaderSendingEmail = true;
                this.errors = {};
                this.errorMessage = '';
                this.otpTimer = 0;
                const requestData = {
                    email: this.email.trim(),
                }
                const response = await axios.post('/resendOtp', requestData);
                if (response.data.status === "success") {
                    setTimeout(() => {
                        this.LoaderSendingEmail = false;
                    }, 300);
                    this.toaster = true;
                    this.Message = response.data.message;
                    this.toastColor = "success";
                    setTimeout(() => {
                        this.toaster = false;
                    }, 5000);
                    this.startOtpTimer(response.data.timer);


                }

            }
            catch (error) {
                // Handle validation errors (status 422)
                if (error.response && error.response.status === 422) {
                    this.LoaderSendingEmail = false;

                    this.errors = error.response.data.errors || {};
                    this.errorMessage = 'Please correct the errors below.';
                }
                // Handle unexpected server errors (status 500)
                else if (error.response && error.response.status === 500) {
                    this.errorMessage = error.response.data.message || 'An unexpected error occurred. Please try again.';
                }
                // Handle network errors
                else {
                    this.errorMessage = 'A network error occurred. Please check your connection.';
                }
            } finally {
                // Re-enable the Resend OTP button
                // this.isResending = false;
            }
        },
        //filling data
        Emptyfill() {
            this.profilePic = "";
            this.previewPic = "/images/registertenant/Profile-PNG-Photo.png";
            this.firstname = "";
            this.lastname = "";
            this.email = "";
            this.password = "";
            this.password_confirmation = "";
            this.phonenumber = "";
            this.gender = "";
            this.govermentIdPicPreview = "";
            this.governmentIdFile = "";
            this.businessIdPicPreview = "";
            this.businessPermitFile = "";
            // this.BusinessPermitPic = "";
            this.otpTimer = 0;
            this.otpdigits = Array(6).fill('');

        },
        showpassword() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            confirmPasswordField.type = type;
        }


    },
    computed: {
        formattedTime() {
            const minutes = Math.floor(this.otpTimer / 60);
            const seconds = this.otpTimer % 60;
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        },
    },


};
</script>
