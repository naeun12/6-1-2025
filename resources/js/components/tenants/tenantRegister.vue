<template>


    <div>

        <form @submit.prevent="submitTenant">

            <!-- <div v-if="successMessage" class="alert alert-success text-center"><span class="text-black">{{successMessage}}</span></div> -->
            <!-- Profile Picture -->
            <div class="d-flex justify-content-center container-image my-4">
                <div class="avatar-wrapper text-center">
                    <img class="profile-pic rounded-circle" :src="profilePic" alt="Profile Picture" width="150">

                    <div class="upload-button btn btn-primary mt-3" @click="triggerFileInput">
                        Upload Image
                        <input ref="fileInput" class="file-input" name="profile_pic" id="profile-pic" type="file"
                            accept="image/*" style="display: none;" @change="handleImageUpload">
                    </div>
                </div>
            </div>

            <!-- First Name and Last Name -->
            <div class="row px-4">
                <div class="col-md-6 mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" id="firstname" name="firstname" v-model="firstname"
                        class="form-control border-primary" placeholder="Enter your First Name">
                    <span v-if="errors.firstname" class="error">{{ errors.firstname[0] }}</span>



                </div>

                <div class="col-md-6 mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" id="lastname" name="lastname" v-model="lastname"
                        class="form-control border-primary" placeholder="Enter your Last Name" required>
                    <span v-if="errors.lastname" class="error">{{ errors.lastname[0] }}</span>

                </div>
            </div>

            <!-- Email -->
            <div class="mb-3 px-4">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" v-model="email" class="form-control border-primary"
                    placeholder="Enter your Email Address" required>
                <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>

            </div>

            <!-- Password and Confirm Password -->
            <div class="row px-4">
                <div class="col-md-6 mb-0">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" v-model="password"
                        class="form-control border-primary" placeholder="Enter your Password" required>
                    <span class="error" v-if="errors.password">{{ errors.password[0] }}</span>

                </div>
                <div class="col-md-6 mb-0">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="password_confirmation"
                        v-model="password_confirmation" class="form-control border-primary"
                        placeholder="Confirm your Password" required>
                    <span v-if="errors.password_confirmation" class="error">{{ errors.password_confirmation[0] }}</span>
                </div>
            </div>

            <!-- Show Password Checkbox -->
            <div class="mb-3 px-4">
                <div class="input-group-text bg-transparent border-0">
                    <input type="checkbox" id="show-password" class="me-2 bg-transparent"
                        @click="togglePasswordVisibility">
                    <label for="show-password" class="form-check-label bg-transparent">Show Password</label>
                </div>
            </div>

            <!-- Phone Number -->
            <div class="mb-3 px-4">
                <label for="phonenumber" class="form-label">Phone Number</label>
                <input type="tel" id="phonenumber" name="phonenumber" v-model="phonenumber"
                    class="form-control border-primary" placeholder="Enter your Phone Number" required
                    pattern="^(?:\+63|09)\d{9}$">

                <span v-if="errors.phonenumber" class="error">{{ errors.phonenumber[0] }}</span>

            </div>

            <!-- Gender -->
            <div class="mb-3 px-4">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" v-model="gender" class="form-select border-primary" required>
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <span class="error" v-if="errors.gender">{{ errors.gender[0] }}</span>
            </div>

            <!-- Address Fields -->
            <div class="row px-4">
                <!-- Region -->
                <div class="col-md-4 mb-3">
                    <label for="region" class="form-label">Region</label>
                    <select id="region" v-model="selectedRegion" class="form-select border-primary"
                        @change="updateProvinces">
                        <option value="">-- Select Region --</option>
                        <option v-for="(name, code) in regions" :key="code" :value="code">{{ name }}</option>
                    </select>
                    <span class="error" v-if="errors.selectedRegion">{{ errors.selectedRegion[0] }}</span>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="province" class="form-label">Province</label>
                    <select id="province" v-model="selectedProvince" class="form-select border-primary"
                        @change="updateCities">
                        <option value="">-- Select Province --</option>
                        <option v-if="provinces.length === 0" disabled>No provinces available</option>
                        <option v-for="province in provinces" :key="province" :value="province">{{ province }}</option>
                    </select>
                    <span class="error" v-if="errors.selectedProvince">{{ errors.selectedProvince[0] }}</span>

                </div>


                <div class="col-md-4 mb-3">
                    <label for="city" class="form-label">City</label>
                    <select id="city" v-model="selectedCity" class="form-select border-primary">
                        <option value="">-- Select City --</option>
                        <option v-if="cities.length === 0" disabled>No City available</option>
                        <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                    </select>
                    <span class="error" v-if="errors.selectedCity">{{ errors.selectedCity[0] }}</span>
                </div>
            </div>
            <div class="mb-3 px-4">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" id="postalcode" name="postalcode" v-model="postalcode"
                    class="form-control border-primary" placeholder="Postal Code" required>
                <span class="error" v-if="errors.postalcode">{{ errors.postalcode[0] }}</span>
            </div>

            <div class="mb-3 px-4">
                <label for="current_address" class="form-label">Current Address</label>
                <textarea id="current_address" name="currentaddress" v-model="currentaddress"
                    class="form-control border-primary" rows="3" placeholder="Current Address" required></textarea>
                <span class="error" v-if="errors.currentaddress">{{ errors.currentaddress[0] }}</span>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <button type="button" @click="openModal" class="btn btn-primary w-50">Sign-up</button>
            </div>



            <div v-if="modalVisible" class="modal-backdrop" @click="closeModal"></div>

            <div v-if="modalVisible" class="custom-modal">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title text-center">Email OTP</h5>
                        <button type="button" class="btn-close" @click="closeModal">×</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p>Please enter the verification OTP sent to your email.</p>
                        <div class="otp-inputs">
                            <input v-for="(digit, index) in otpdigits" :key="index" type="text"
                                :ref="'otpInput' + index" maxlength="1" class="form-control" name="codeotp"
                                v-model="otpdigits[index]" @input="handleInput(index)"
                                @keydown.backspace="handleBackspace(index)" required />
                        </div>
                        <div class="otp_timer mb-3">
                            <p class="primary" v-if="otpTimer > 0">OTP expires in: {{ formattedTime }}</p>
                        </div>
                        <div class="modal-actions">
                            <button type="submit" class="btn btn-primary">Verify Email</button>
                            <button type="button" @click="resendOtp" class="btn btn-success">Resend OTP</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div :class="['container-toast', { show: toastgmailvisible }]" v-show="toastgmailvisible">
        <!-- Toast Container -->
        <div :class="['toast-child', `bg-${toastColor}`]">
            <div class="toast-body d-flex justify-content-between align-items-center text-white fw-bold py-3 px-4">
                <span class="text-wrap">{{ this.toastResponseText }}</span>
                <button type="button" class="btn-close btn-close-white ms-3" @click="ExittoastGmail"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <!--Register Error Modal-->
    <div v-if="RegisterErrorOpenModal" class="modal-overlay ">
        <div class="modal-container ">

            <div class="confirmation-box mb-5">
                <h2 class="mb-5 mt-3">{{ this.RegisterErrorMessage }}</h2>

                <svg class="checkmark mb-5" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" fill="none" stroke="#e74c3c" stroke-width="5" cx="26" cy="26"
                        r="24" />
                    <path class="checkmark-check" fill="none" stroke="#e74c3c" stroke-width="5"
                        d="M16 16l20 20 M16 36l20 -20" />
                </svg>
                <h3 class="mb-5">{{ this.RegisterErrorChildMessage }}</h3>
                <button class="btn btn-danger w-50" @click="RegisterErrorCloseModal">OK</button>
            </div>
        </div>
    </div>
    <!--Register Success Modal-->

    <div v-if="showSuccessModal" class="modal-overlay ">
        <div class="modal-container ">

            <div class="confirmation-box mb-5">
                <h2 class="mb-5 mt-4">Welcome to DormHub</h2>
                <svg class="checkmark mb-5" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" fill="none" stroke="#2ecc71" stroke-width="5" cx="26" cy="26"
                        r="24" />
                    <path class="checkmark-check" fill="none" stroke="#2ecc71" stroke-width="5" d="M14 27l7 7 16-16" />
                </svg>
                <h3 class="mb-5"> {{ this.successMessage }}</h3>
                <button class="btn btn-success w-50" @click="RegistercloseModal">OK</button>
            </div>

        </div>
    </div>

    <div v-if="isLoading" class="loader-overlay">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
            <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Please wait...</p>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    name: "TenantRegistration",
    data() {
        return {
            profilePic: "/images/registertenant/Profile-PNG-Photo.png",
            profileFile: null,
            firstname: '',
            lastname: '',
            email: '',
            password: '',
            password_confirmation: '',
            phonenumber: '',
            gender: '',
            postalcode: '',
            currentaddress: '',
            message: '',
            errors: {},
            modalVisible: false,
            isLoading: false,
            otpTimer: 0,
            selectedRegion: "",
            selectedProvince: "",
            selectedCity: "",
            cities: [],
            showSuccessModal: false,
            successMessage: "",
            RegisterErrorOpenModal: false,
            RegisterErrorMessage: "",
            toastgmailvisible: false,
            toastResponseText: "",
            toastColor: "",
            RegisterErrorChildMessage: "",
            otpdigits: Array(6).fill(''),
            provinces: [],
            regions: {
                "NCR": "National Capital Region (NCR)",
                "CAR": "Cordillera Administrative Region (CAR)",
                "Region I": "Region I - Ilocos Region",
                "Region II": "Region II - Cagayan Valley",
                "Region III": "Region III - Central Luzon",
                "Region IV-A": "Region IV-A - CALABARZON",
                "MIMAROPA": "MIMAROPA Region",
                "Region V": "Region V - Bicol Region",
                "Region VI": "Region VI - Western Visayas",
                "Region VII": "Region VII - Central Visayas",
                "Region VIII": "Region VIII - Eastern Visayas",
                "Region IX": "Region IX - Zamboanga Peninsula",
                "Region X": "Region X - Northern Mindanao",
                "Region XI": "Region XI - Davao Region",
                "Region XII": "Region XII - SOCCSKSARGEN",
                "Region XIII": "Region XIII - Caraga",
                "BARMM": "BARMM - Bangsamoro Autonomous Region"
            },
            provinceData: {
                "NCR": ["Metro Manila"],
                "CAR": ["Abra", "Apayao", "Benguet", "Ifugao", "Kalinga", "Mountain Province"],
                "Region I": ["Ilocos Norte", "Ilocos Sur", "La Union", "Pangasinan"],
                "Region II": ["Batanes", "Cagayan", "Isabela", "Nueva Vizcaya", "Quirino"],
                "Region III": ["Aurora", "Bataan", "Bulacan", "Nueva Ecija", "Pampanga", "Tarlac", "Zambales"],
                "Region IV-A": ["Batangas", "Cavite", "Laguna", "Quezon", "Rizal"],
                "MIMAROPA": ["Marinduque", "Occidental Mindoro", "Oriental Mindoro", "Palawan", "Romblon"],
                "Region V": ["Albay", "Camarines Norte", "Camarines Sur", "Catanduanes", "Masbate", "Sorsogon"],
                "Region VI": ["Aklan", "Antique", "Capiz", "Guimaras", "Iloilo", "Negros Occidental"],
                "Region VII": ["Bohol", "Cebu", "Negros Oriental", "Siquijor"],
                "Region VIII": ["Biliran", "Eastern Samar", "Leyte", "Northern Samar", "Samar", "Southern Leyte"],
                "Region IX": ["Zamboanga del Norte", "Zamboanga del Sur", "Zamboanga Sibugay"],
                "Region X": ["Bukidnon", "Camiguin", "Lanao del Norte", "Misamis Occidental", "Misamis Oriental"],
                "Region XI": ["Davao de Oro", "Davao del Norte", "Davao del Sur", "Davao Occidental", "Davao Oriental"],
                "Region XII": ["Cotabato", "Sarangani", "South Cotabato", "Sultan Kudarat"],
                "Region XIII": ["Agusan del Norte", "Agusan del Sur", "Dinagat Islands", "Surigao del Norte", "Surigao del Sur"],
                "BARMM": ["Basilan", "Lanao del Sur", "Maguindanao", "Sulu", "Tawi-Tawi"]
            },
            cityData: {

                "Metro Manila": ["Manila", "Quezon City", "Caloocan", "Las Piñas", "Makati", "Malabon", "Mandaluyong", "Marikina", "Muntinlupa", "Navotas", "Parañaque", "Pasay", "Pasig", "Pateros", "San Juan", "Taguig"],
                "Abra": ["Bangued", "Boliney", "Bucay", "Bucloc", "Daguioman", "Danglas", "Dolores", "La Paz", "Lacub", "Lagangilang", "Langiden", "Licuan-Baay", "Luba", "Malibcong", "Manabo", "Peñarrubia", "Pidigan", "Pilar", "Sallapadan", "San Isidro", "San Juan", "San Quintin", "Tayum", "Tineg", "Tubo"],
                "Apayao": ["Calanasan", "Conner", "Flora", "Kabugao", "Luna", "Pudtol", "Santa Marcela"],
                "Benguet": ["Atok", "Bakun", "Bokod", "Buguias", "Itogon", "Kabayan", "Kapangan", "Kibungan", "La Trinidad", "Mankayan", "Sablan", "Tuba", "Tublay"],
                "Ifugao": ["Aguinaldo", "Alfonso Lista", "Asipulo", "Banaue", "Hingyon", "Hungduan", "Kiangan", "Lagawe", "Lamut", "Mayoyao", "Tinoc"],
                "Kalinga": ["Tabuk City", "Balbalan", "Lubuagan", "Pasil", "Pinukpuk", "Rizal", "Tinglayan", "Tanudan"],
                "Mountain Province": ["Barlig", "Bauko", "Besao", "Bontoc", "Natonin", "Paracelis", "Sabangan", "Sadanga", "Sagada", "Tadian"],
                "Ilocos Norte": ["Laoag City", "Batac"],
                "Ilocos Sur": ["Vigan City", "Candon City"],
                "La Union": ["San Fernando City"],
                "Pangasinan": ["Dagupan City", "Urdaneta City", "Alaminos City", "San Carlos City"],
                "Batanes": ["Basco"],
                "Cagayan": ["Tuguegarao City", "Santiago City", "Ilagan City", "Cauayan City"],
                "Isabela": ["Ilagan City", "Cauayan City", "Santiago City"],
                "Nueva Vizcaya": ["Bayombong", "Solano"],
                "Quirino": ["Aglipay", "Cabarroguis", "Diffun", "Maddela", "Nagtipunan", "Saguday"],
                "Nueva Ecija": ["Aliaga", "Bongabon", "Cabiao", "Cabanatuan City", "Carranglan", "Cuyapo", "Gabaldon", "Gapan City", "General Mamerto Natividad", "General Tinio", "Guimba", "Jaen", "Laur", "Licab", "Llanera", "Lupao", "Nampicuan", "Palayan City", "Pantabangan", "Peñaranda", "Quezon", "Rizal", "San Antonio", "San Isidro", "San Jose City", "San Leonardo", "Santa Rosa", "Santo Domingo", "Talavera", "Talugtug", "Zaragoza"],
                "Pampanga": ["Angeles City", "City of San Fernando", "Mabalacat City", "San Luis", "San Simon", "Santa Ana", "Santo Tomas", "Apalit", "Bacolor", "Floridablanca", "Guagua", "Lubao", "Macabebe", "Magalang", "Masantol", "Mexico", "Porac"],
                "Tarlac": ["Tarlac City", "Concepcion", "Gerona", "La Paz", "Moncada", "Paniqui", "Pura", "Ramos", "San Clemente", "San Jose", "San Manuel", "Santa Ignacia", "Victoria"],
                "Bohol": ["Tagbilaran City", "Antequera", "Baclayon", "Balilihan", "Bilar", "Bohol", "Carmen", "Catigbian", "Cortes", "Dauis", "Dimiao", "Duero", "Garcia Hernandez", "Guindulman", "Inabanga", "Jagna", "Loboc", "Loon", "Mabini", "Panglao", "Pilar", "Sagbayan", "San Isidro", "San Miguel", "Sevilla", "Sierra Bullones", "Tauran", "Trinidad"],
                "Cebu": ["Cebu City", "Carcar City", "Danao City", "Lapu-Lapu City", "Mandaue City", "Naga City", "Toledo City", "Alcoy", "Alegria", "Aloguinsan", "Argao", "Asturias", "Badian", "Balamban", "Bantayan", "Barili", "Bogo City", "Boljoon", "Borbon", "Carmen", "Catmon", "Compostela", "Consolacion", "Cordova", "Dumanjug", "Ginatilan", "Liloan", "Minglanilla", "Moalboal", "Oslob", "Pinamungajan", "Poro", "San Fernando", "San Francisco", "San Remigio", "Santa Fe", "Santander", "Sogod", "Tabogon", "Tabuelan", "Talisay City", "Tuban", "Tuburan"],
                "Zambales": ["Iba", "Olongapo City", "San Antonio", "San Felipe", "San Marcelino", "San Narciso", "Castillejos", "Subic", "Botolan", "Masinloc", "Palauig", "Candelaria", "Chindonan", "Kababae"],
                "Bulacan": ["Malolos", "Meycauayan", "San Jose del Monte", "Baliuag", "Angat"],
                "Batangas": ["Batangas City", "Lipa City", "Tanauan City", "Balayan", "Lemery"],
                "Davao del Sur": ["Davao City", "Tagum City", "Digos City", "Panabo City", "Samal City"],
                "South Cotabato": ["General Santos City", "Koronadal City", "Polomolok", "Tupi"],
                "Surigao del Norte": ["Surigao City", "Siargao Island"],
                "Misamis Oriental": ["Cagayan de Oro City", "Gingoog City", "El Salvador City", "Claveria"],
                "BARMM": ["Marawi City", "Cotabato City", "Lamitan City", "Malabang"],
                "Aurora": ["Baler", "Maria Aurora"],
                "Bataan": ["Balanga City", "Dinalupihan", "Hermosa"],
                "Cavite": ["Imus City", "Bacoor City", "Dasmariñas City", "Tagaytay City", "Trece Martires City"],
                "Laguna": ["Santa Rosa City", "Calamba City", "San Pablo City", "Biñan City", "Cabuyao City"],
                "Quezon": ["Lucena City", "Tayabas City", "Sariaya", "Pagbilao"],
                "Rizal": ["Antipolo City", "Cainta", "Taytay", "Binangonan"],
                "Marinduque": ["Boac", "Gasan", "Torrijos"],
                "Occidental Mindoro": ["Mamburao", "Sablayan", "San Jose", "Calintaan"],
                "Oriental Mindoro": ["Calapan City", "Puerto Galera", "Baco", "Pinamalayan"],
                "Palawan": ["Puerto Princesa City", "Coron", "El Nido", "Brooke's Point"],
                "Romblon": ["Romblon Town", "Odiongan", "Looc", "Ferrol"],
                "Albay": ["Legazpi City", "Tabaco City", "Ligao City", "Daraga", "Tiwi"],
                "Camarines Norte": ["Daet", "Labo", "Paracale", "Jose Panganiban"],
                "Camarines Sur": ["Naga City", "Sorsogon City", "Iriga City", "Pili", "Calabanga"],
                "Catanduanes": ["Virac", "Baras", "Pandan", "Bagamanoc"],
                "Masbate": ["Masbate City", "Milagros", "Mandaon", "Baleno"],
                "Sorsogon": ["Sorsogon City", "Gubat", "Bulan", "Matnog"],
                "Aklan": ["Kalibo", "Boracay", "Malay", "Nabas"],
                "Antique": ["San Jose de Buenavista", "Pandan", "Culasi", "Anini-y"],
                "Capiz": ["Roxas City", "Pontevedra", "Jamindan", "Cuartero"],
                "Guimaras": ["Jordan", "Nueva Valencia", "San Lorenzo", "Sibunag"],
                "Iloilo": ["Iloilo City", "Passi City", "Roxas City", "Silay City", "Kalibo"],
                "Negros Occidental": ["Bacolod City", "Silay City", "Cadiz City", "Escalante City", "Victorias City"],
                "Negros Oriental": ["Dumaguete City", "Bais City", "Tanjay City", "Canlaon City", "Guihulngan City"],
                "Siquijor": ["Siquijor Town", "Larena", "Enrique Villanueva", "Maria"],
                "Biliran": ["Naval", "Caibiran", "Biliran Town", "Almeria"],
                "Eastern Samar": ["Borongan City", "Sulat", "Taft", "Maydolong"],
                "Leyte": ["Tacloban City", "Ormoc City", "Baybay City", "Maasin City", "Abuyog"],
                "Northern Samar": ["Catarman", "Laoang", "Victoria", "Allen"],
                "Samar": ["Calbayog City", "Catbalogan City", "Basey", "Marabut"],
                "Southern Leyte": ["Maasin City", "Sogod", "Hinunangan", "Bontoc"],
                "Zamboanga del Norte": ["Dipolog City", "Dapitan City", "Polanco", "Manukan"],
                "Zamboanga del Sur": ["Zamboanga City", "Pagadian City", "Ipil", "Molave"],
                "Zamboanga Sibugay": ["Ipil", "Buug", "Payao", "Titay"],
                "Bukidnon": ["Malaybalay City", "Valencia City", "Manolo Fortich", "Don Carlos"],
                "Camiguin": ["Mambajao", "Mahinog", "Guinsiliban", "Catarman"],
                "Lanao del Norte": ["Iligan City", "Tubod", "Baroy", "Kapatagan"],
                "Misamis Occidental": ["Oroquieta City", "Ozamiz City", "Tangub City", "Jimenez"],
                "Misamis Oriental": ["Cagayan de Oro City", "Gingoog City", "El Salvador City", "Claveria"],
                "Davao de Oro": ["Nabunturan", "Compostela", "Montevista", "New Corella"],
                "Davao del Norte": ["Tagum City", "Panabo City", "Island Garden City of Samal", "Carmen"],
                "Davao Occidental": ["Malita", "Don Marcelino", "Santa Maria", "Sarangani"],
                "Davao Oriental": ["Mati City", "Governor Generoso", "Manay", "Boston"],
                "Agusan del Norte": ["Butuan City", "Cabadbaran City", "Jabonga", "Las Nieves"],
                "Agusan del Sur": ["Prosperidad", "Bunawan", "Bayugan City", "Rosario"],
                "Dinagat Islands": ["San Jose", "Libjo", "Loreto", "Cagdianao"],
                "Surigao del Sur": ["Tandag City", "Bislig City", "Hinatuan", "Lianga"],
                "Basilan": ["Isabela City", "Lamitan City", "Hadji Mohammad Ajul", "Sumisip"],
                "Lanao del Sur": ["Marawi City", "Malabang", "Picong", "Wao"],
                "Maguindanao": ["Cotabato City", "Buluan", "Shariff Aguak", "Datu Odin Sinsuat"],
                "Sulu": ["Jolo", "Patikul", "Indanan", "Maimbung"],
                "Tawi-Tawi": ["Bongao", "Sibutu", "Sitangkai", "Mapun"],
                "Cotabato": ["Cotabato City", "Aleosan", "Antipas", "Arakan", "Banisilan", "Carmen", "Kabacan", "Midsayap", "Matalam", "Pigcawayan", "Pikit", "President Roxas", "Tulunan"],
                "Sarangani": ["Alabel", "Glan", "Kiamba", "Maasim", "Maitum", "Malungon", "Sarangani", "Santo Niño"],
                "Sultan Kudarat": ["Isulan", "Bagumbayan", "Columbio", "Esperanza", "Kalamansig", "Lambayong", "Lebak", "Sen. Ninoy Aquino", "Tacurong"]
            },
        }
    },

    mounted() {

        this.startTimer();
    },
    beforeUnmount() {
        this.stopTimer();
    },

    methods: {
        formattedTime() {

            const minutes = Math.floor(this.otpTimer / 60);
            const seconds = this.otpTimer % 60;
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        },
    },
    methods: {
        updateProvinces() {
            console.log("Selected Region:", this.selectedRegion);
            this.selectedProvince = "";
            this.selectedCity = "";
            this.provinces = this.provinceData[this.selectedRegion] || [];
            console.log("Provinces:", this.provinces);
            this.cities = [];
        },
        updateCities() {
            console.log("Selected Province:", this.selectedProvince);
            this.selectedCity = "";
            this.cities = this.cityData[this.selectedProvince] || [];
            console.log("Cities:", this.cities);
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

        validateForm() {
            this.errors = {};
            if (!this.firstname) this.errors.firstname = ["First Name is required."];
            if (!this.lastname) this.errors.lastname = ["Last Name is required."];
            if (!this.email) this.errors.email = ["Email is required."];
            if (!this.password) this.errors.password = ["Password is required."];
            if (!this.phonenumber) this.errors.phonenumber = ["Phone Number is required."];
            if (!this.gender) this.errors.gender = ["Gender is required."];
            if (!this.selectedRegion) this.errors.selectedRegion = ["Region is required."];
            if (!this.selectedCity) this.errors.selectedCity = ["City is required."];
            if (!this.selectedProvince) this.errors.selectedProvince = ["Province is required."];
            if (!this.postalcode) this.errors.postalcode = ["Postal Code is required."];
            if (!this.currentaddress)
                this.errors.currentaddress = ["Current Address is required."];

            return Object.keys(this.errors).length === 0; // Return true if no errors
        },

        openModal() {

            this.errors = {};
            const isFormValid = this.validateForm();
            if (isFormValid) {
                this.isLoading = true;
                this.OtpVerification()
                    .then((success) => {
                        if (success) {
                            this.modalVisible = true;
                            document.body.style.overflow = "hidden";
                        }
                    })
                    .catch((error) => {
                        console.error("Error during OTP verification:", error);
                        alert("An error occurred while verifying OTP. Please try again.");
                    })
                    .finally(() => {
                        this.isLoading = false; // Hide loader regardless of success or failure
                    });
            } else {
                this.isLoading = false;
                this.RegisterErrorMessage = "Incomplete Submission";
                this.RegisterErrorChildMessage = "Please verify the information you have entered, as some required fields appear to be incomplete or empty.";
                this.RegisterErrorOpenModal = true;

            }
        },
        closeModal() {
            this.modalVisible = false;
            document.body.style.overflow = "";

        },
        async OtpVerification() {
            const requestData = {
                email: this.email.trim(),
                phonenumber: this.phonenumber.trim(),
                postalcode: this.postalcode.trim(),
                password: this.password.trim(),
                password_confirmation: this.password_confirmation.trim(),
            };

            try {
                const response = await axios.post('/SendOtp', requestData, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                    }
                });
                if (response.status === 200) {
                    this.toastgmailvisible = true;
                    this.toastResponseText = response.data.message;
                    this.toastColor = "success";
                    setTimeout(() => {
                        this.toastgmailvisible = false;

                    }, 10000);
                    const expirationTime = new Date(response.data.timer);
                    const currentTime = new Date();
                    let remainingSeconds = Math.floor((expirationTime - currentTime) / 1000);
                    this.otpTimer = remainingSeconds;
                    const interval = setInterval(() => {
                        if (remainingSeconds <= 0) {
                            clearInterval(interval);
                            this.otpTimer = 0;
                            return;
                        }
                        this.otpTimer = remainingSeconds;
                        remainingSeconds--;
                    }, 1000);
                    return true;
                }
            }
            catch (error) {
                if (error.response && error.response.status === 422) {
                    console.error('Validation Errors:', error.response.data.errors);

                    // Bind field-specific errors
                    this.RegisterErrorMessage = "Invalid Submission";
                    this.RegisterErrorChildMessage = "Please review and correct the invalid fields in the form before proceeding.";
                    this.RegisterErrorOpenModal = true;
                    this.errors = error.response.data.errors || {};
                } else if (error.response && error.response.status === 400) {
                    console.error('Unexpected Error:', error.response.data.message);
                    this.errors.general = [error.response.data.message];
                } else {
                    console.error('Network Error:', error);
                    this.errors.general = ['A network error occurred. Please try again.'];
                }
                return false;
            }


        },
        async submitTenant() {

            const formData = new FormData();
            formData.append('firstname', this.firstname);
            formData.append('lastname', this.lastname);
            formData.append('email', this.email);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.password_confirmation);
            formData.append('phonenumber', this.phonenumber);
            formData.append('gender', this.gender);
            formData.append('city', this.selectedCity);
            formData.append('province', this.selectedProvince);
            formData.append('region', this.selectedRegion);
            formData.append('postalcode', this.postalcode);
            formData.append('currentaddress', this.currentaddress);
            if (this.profileFile) {
                formData.append('profile_pic', this.profileFile);
            }
            else {
                console.log('No Profile picture selected. Using default image');
            }
            formData.append('codeotp', this.otpdigits.join(''));
            try {


                const response = await axios.post('/registerTenant', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (response.status === 200) {
                    this.modalVisible = false;
                    this.showSuccessModal = true;
                    this.successMessage = response.data.message;
                    this.errors = {};
                    this.fill();

                    setTimeout(() => {
                        this.RegistercloseModal();
                    }, 10000);
                }

                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
            catch (error) {
                if (error.response && error.response.data.status === "error") {
                    this.toastgmailvisible = true;
                    this.toastResponseText = error.response.data.message;
                    this.toastColor = "danger";
                    setTimeout(() => {
                        this.toastgmailvisible = false;
                    }, 10000);
                }


            }


        },
        async resendOtp() {
            try {
                this.isReadingfalse = false;
                this.errors = {};
                this.errorMessage = '';
                const requestData = {
                    email: this.email.trim(),
                }
                const response = await axios.post('/resendOtp', requestData);
                if (response.data.status === "success") {
                    this.toastgmailvisible = true;
                    this.toastResponseText = response.data.message;
                    this.toastColor = "success";
                    setTimeout(() => {
                        this.toastgmailvisible = false;
                    }, 10000);
                    const expirationTime = new Date(response.data.timer);
                    const currentTime = new Date();
                    let remainingSeconds = Math.floor((expirationTime - currentTime) / 1000);
                    this.otpTimer = remainingSeconds;
                    const interval = setInterval(() => {
                        if (remainingSeconds <= 0) {
                            clearInterval(interval);
                            this.otpTimer = 0;
                            return;
                        }
                        this.otpTimer = remainingSeconds;
                        remainingSeconds--;
                    }, 1000);
                }

            }
            catch (error) {
                // Handle validation errors (status 422)
                if (error.response && error.response.status === 422) {
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
        togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirm_password');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            confirmPasswordField.type = type;
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.profilePic = URL.createObjectURL(file);
                this.profileFile = file;
            }
            else {
                this.profilePic = "/images/registertenant/Profile-PNG-Photo.png";
            }
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
        RegistercloseModal() {
            this.showSuccessModal = false;
            document.body.style.overflow = "";

        },
        RegisterErrorCloseModal() {
            this.RegisterErrorOpenModal = false;
            document.body.style.overflow = "";
        },
        ExittoastGmail() {
            this.toastgmailvisible = false;


        },


        fill() {
            this.profilePic = "/images/registertenant/Profile-PNG-Photo.png";
            this.profileFile = null;
            this.firstname = '';
            this.lastname = '';
            this.email = '';
            this.password = '';
            this.password_confirmation = '';
            this.phonenumber = '';
            this.gender = '';
            this.postalcode = '';
            this.currentaddress = '';
            this.message = '';
            this.errors = {};
            this.isLoading = false;
            this.otpTimer = 0;
            this.selectedRegion = "";
            this.selectedProvince = "";
            this.selectedCity = "";
            this.cities = [];
            this.otpdigits = Array(6).fill('');
            this.provinces = [];
        },
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
<style scoped>
.error {
    color: red;
    font-size: 12px;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(152, 133, 133, 0.8);
    opacity: 0.3;
    z-index: 999;
}

.custom-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 500px;
    /* Adjust as needed */
    max-width: 90%;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #ddd;
}

.modal-header .modal-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.modal-header .btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

/* Modal Body */
.modal-body {
    padding: 1rem;
    text-align: center;
}



/* OTP Inputs */
.otp-inputs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 1rem;
}

.otp-box {
    width: 40px;
    height: 40px;
    text-align: center;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
}

.otp-box:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Modal Actions */
.modal-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.modal-actions .btn {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.modal-actions .btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
}

.modal-actions .btn-success {
    background-color: #28a745;
    color: #fff;
    border: none;
}

.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    /* Semi-transparent white */
    z-index: 1050;
    /* Ensure it's above other content */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.spinner-border {
    width: 4rem;
    height: 4rem;
}

/* Overlay */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* darker transparent background */
    z-index: 999;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Modal Container */
.modal-container {
    background-color: #fff;
    border-radius: 8px;
    width: 400px;
    max-width: 90%;
    padding: 20px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
    z-index: 1000;
    position: relative;
    animation: fadeIn 0.3s ease;
}

/* Fade-in Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

/* Modal Header */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.modal-header h2 {
    font-size: 24px;
    color: #333;
    margin: 0;
}

.close-button {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #007bff;
}

/* Confirmation Box */
.confirmation-box {
    text-align: center;
}

.confirmation-box h3 {
    font-size: 20px;
    margin-bottom: 20px;
    color: #333;
}

/* Checkmark (optional SVG style) */
.checkmark {
    width: 60px;
    height: 60px;
    margin-bottom: 15px;
    animation: rotate 1s ease-in-out;

}

.ok-button {
    background-color: transparent;
    border: 2px solid #22ff00;
    color: #000000;
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.ok-button:hover {
    background-color: #5bfd04;
    color: #fff;
}

/* Base Styles */
.container-toast {
    position: fixed;
    top: 7rem;
    left: 50%;
    transform: translateX(-50%);
    width: 95%;
    max-width: 30rem;
    z-index: 1000;
    transition: all 0.5s ease;
    /* Smooth transition for all properties */
    opacity: 0;
}

.toast-child {

    border-radius: 0.5rem;
    /* Rounded corners */
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    /* Subtle shadow */
    overflow: hidden;
    /* Prevent content from overflowing */
    transition: all 0.5s ease;
    /* Smooth transition for all properties */




}

@keyframes slideDownBounce {
    0% {
        top: -10rem;
        opacity: 0;
    }

    70% {
        top: 8rem;
        /* Overshoot slightly */
    }

    100% {
        top: 7rem;
        opacity: 1;
    }
}

.container-toast.show {
    animation: slideDownBounce 0.6s ease forwards;
}

.toast-body {
    font-size: 1rem;
    /* Default font size */
}

/* Responsive Font Sizes */
@media (max-width: 768px) {
    .toast-body {
        font-size: 0.9rem;
        /* Smaller font size for tablets and smaller devices */
    }
}

@media (max-width: 576px) {
    .toast-body {
        font-size: 0.8rem;
        /* Even smaller font size for mobile devices */
    }

    .container-toast {
        width: 100%;
        /* Full width on very small screens */
        padding: 0 1rem;
        /* Add horizontal padding for better spacing */
    }
}

/* Button Styling */
.btn-close {
    margin-left: 1rem;
    /* Add spacing between text and close button */
}
</style>