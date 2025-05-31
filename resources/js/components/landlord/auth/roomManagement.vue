<template>
    <div class="container mt-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary fw-bold">Post Room</h1>
            <div>
                <button class="btn btn-primary" @click="VisibleAddModal = true">
                    Add Room
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <input type="text" v-model="searchTerm" placeholder="🔍 Search Room..." class="form-control mb-4 shadow-sm" />

        <!-- Table -->
        <div class="table-responsive shadow-sm rounded mt-4">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Room ID</th>
                        <th>Room No</th>
                        <th>Room Type</th>
                        <th>Price (₱)</th>
                        <th>Availability</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center align-middle" v-for="room in rooms" :key="room.room_id">
                        <td>{{ room.room_id }}</td>
                        <td>{{ room.room_number }}</td>
                        <td>{{ room.room_type }}</td>
                        <td>{{ room.price }}</td>
                        <td>
                            <span class="badge"
                                :class="room.availability === 'Available' ? 'bg-success' : room.availability === 'Occupied' ? 'bg-danger' : 'bg-warning'">
                                {{ room.availability }}
                            </span>
                        </td>
                        <td>{{ room.capacity }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-outline-success" @click="ViewRoom(room.room_id)">
                                    View
                                </button>
                                <button class="btn btn-sm btn-outline-primary" @click="VisibleUpdateModal = true">
                                    Update
                                </button>
                                <button class="btn btn-sm btn-outline-danger" @click="VisibleDeleteModal = true">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!--modal add room-->
        <div v-if="VisibleAddModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add Room</h5>
                        <button type="button" class=" btn-close" @click="VisibleAddModal = false"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Large button groups (default and split) -->
                        <div class="btn-group mt-5 mb-3">

                            <ul class="dropdown-menu">

                            </ul>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-lg h-50" type="button">
                                Dorm Name
                            </button>

                            <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li v-for="dorm in dorms" :key="dorm.dorm_id">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="#"
                                        @click.prevent="dormId(dorm)">
                                        <span>{{ dorm.dorm_name }}</span>
                                        <span class="badge bg-secondary">ID: {{ dorm.dorm_id }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="row g-4">
                            <!-- Column 1 -->
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" readonly="ID" placeholder="Dorm ID"
                                        v-model="dormsId">
                                    <label for="ID">Dorm ID</label>
                                </div>
                                <div class="form-floating mb-2 position-relative">
                                    <input type="text" class="form-control ps-5" id="roomNumber"
                                        placeholder="Room Number" v-model="roomNumber" maxlength="10"
                                        pattern="[A-Za-z0-9\- ]+" title="Letters, numbers, dashes, and spaces only">
                                    <label for="roomNumber">Room Number</label>


                                </div>
                                <span class="text-danger" v-if="errors.roomNumber">{{ errors.roomNumber[0]
                                    }}</span>
                                <div class="form-floating mb-2 mt-2">
                                    <select class="form-select" id="roomType" v-model="roomType">
                                        <option value="" disabled selected>Select Room Type</option>
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                        <option value="Studio">Studio</option>
                                        <option value="Suite">Suite</option>
                                        <option value="Shared">Shared</option>
                                    </select>
                                    <label for="roomType">Room Type</label>
                                </div>
                                <span class="text-danger" v-if="errors.roomType">{{ errors.roomType[0]
                                    }}</span>

                                <div class="form-floating mb-2 mt-2">
                                    <select class="form-select" id="availability" v-model="availability">
                                        <option value="" selected>Select Availability</option>
                                        <option v-for="slot in availibilityArray" :key="slot" :value="slot">
                                            {{ slot }}
                                        </option>
                                    </select>

                                    <label for="availability">Availability Status</label>
                                </div>
                                <span class="text-danger" v-if="errors.availability">{{ errors.availability[0]
                                    }}</span>

                            </div>

                            <!-- Column 2 -->
                            <div class="col-md-4">
                                <div class="form-floating mb-2 position-relative">
                                    <input type="number" class="form-control ps-5" id="price" placeholder="Price"
                                        v-model="price" min="0" step="0.01">
                                    <label for="price">Price (₱)</label>

                                    <!-- Icon inside the input -->

                                </div>
                                <span class="text-danger" v-if="errors.availability">{{ errors.availability[0]
                                    }}</span>


                                <div class="form-floating mb-2 mt-2">
                                    <input type="number" min="0" max="10" class="form-control" id="capacity"
                                        v-model="capacity" placeholder="Capacity">
                                    <label for="capacity">Capacity</label>
                                </div>
                                <span class="text-danger" v-if="errors.capacity">{{ errors.capacity[0]
                                    }}</span>
                            </div>

                            <!-- Column 3 -->
                            <div class="col-md-4">

                                <!-- Optional: Image upload or preview section -->
                                <div class="d-grid mt-4">
                                    <button type="submit" @click="VisibleImagePostModal = true"
                                        class="btn btn-success btn-lg">
                                        Post Images
                                    </button>
                                    <button type="submit " @click="submitRoom" class="btn btn-primary btn-lg mt-3">
                                        Submit Room
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="VisibleAddModal = false">Close</button>
                    </div>
                </div>
            </div>
        </div>




        <!--Delete Modal--->
        <div v-if="VisibleDeleteModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);" @click.self="VisibleDeleteModal = false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-danger text-white rounded-top-4">
                        <h5 class="modal-title fw-bold">Delete Confirmation</h5>
                        <button type="button" class="btn-close btn-close-white" @click="VisibleDeleteModal = false"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="bi bi-exclamation-triangle-fill text-warning fs-1 mb-3"></i>
                        <p class="fs-5">Are you sure you want to delete this Room? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            @click="VisibleDeleteModal = false">Cancel</button>
                        <button type="button" class="btn btn-danger px-4" @click="confirmDelete()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!---Update Modal-->
        <div v-if="VisibleUpdateModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Room</h5>
                        <button type="button" class="btn-close" @click="VisibleUpdateModal = false"></button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="row g-4">

                                <!-- Column 1 -->
                                <div class="col-md-4">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="roomNumber"
                                            placeholder="Room Number">
                                        <label for="roomNumber"></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="roomType" placeholder="Room Type">
                                        <label for="roomType">Room Type</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="availability"
                                            placeholder="Availability">
                                        <label for="availability">Availability Status</label>
                                    </div>

                                </div>

                                <!-- Column 2 -->
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="price" placeholder="Price">
                                        <label for="price">Price</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="amenities" placeholder="Amenities">
                                        <label for="amenities">Amenities</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="booking"
                                            placeholder="Booking Status">
                                        <label for="booking">Booking Status</label>
                                    </div>
                                </div>

                                <!-- Column 3 -->
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="maintenance"
                                            placeholder="Maintenance Status">
                                        <label for="maintenance">Maintenance Status</label>
                                    </div>
                                    <!-- Optional: Image upload or preview section -->
                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            Post Images
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="VisibleUpdateModal = false">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="modal fade show d-block w-100" v-if="amenitiesModal" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);" @click.self="amenitiesModal = false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title">Amenities</h5>
                        <button type="button" class="btn-close btn-close-white" @click="amenitiesModal = false"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div v-for="(amenity, index) in amenities" :key="index" class="form-floating mb-3">
                            <input type="text" class="form-control" v-model="amenities[index]" :id="'amenity' + index"
                                placeholder="Enter amenity" />
                            <label :for="'amenity' + index">Amenity {{ index + 1 }}</label>
                        </div>

                        <button class="btn btn-primary w-25 mb-4" @click="addAmenity">Add Amenities</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="amenitiesModal = false">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="submitAmenities">Submit</button>
                    </div>
                </div>
            </div>
        </div> -->


        <!--Display Data Modal-->
        <div v-if="VisibleDisplayDataModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);" @click.self="VisibleDisplayDataModal = false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title">Room Details</h5>
                        <button type="button" class="btn-close btn-close-white" @click="VisibleDisplayDataModal = false"
                            aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto; padding: 1.5rem;">
                        <div class="row g-4 ">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Room Number:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{ selectedRoom?.room_number }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Room Type:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{ selectedRoom?.room_type }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Price:</label>
                                    <div class="p-2 border rounded bg-light text-break">₱{{ selectedRoom?.price }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Capacity:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{ selectedRoom?.capacity }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 ">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Availability:</label>
                                    <div class="p-2 border rounded bg-light text-break">
                                        <span class="badge"
                                            :class="selectedRoom?.availability === 'Available' ? 'bg-success' : selectedRoom?.availability === 'Occupied' ? 'bg-danger' : 'bg-warning'">
                                            {{ selectedRoom?.availability }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Contact Email:</label>
                                    <div class="p-2 border rounded bg-light text-break"> {{ selectedRoom?.contact_email
                                        }}

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Contact Phone:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{ selectedRoom?.contact_phone
                                        }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Registration Date:</label>
                                    <div class="p-2 border rounded bg-light text-break">2023-01-01</div>

                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Address:</label>
                                <div class="p-2 border rounded bg-light text-break w-100"
                                    style="max-height: 100px;  overflow-y: auto;">
                                    {{ selectedRoom?.address
                                    }}

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-success px-4"
                            @click="VisibleDisplayDataModal = false">OK</button>
                    </div>
                </div>
            </div>
        </div>


        <!--Images Post Modal-->
        <div v-if="VisibleImagePostModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content shadow-lg rounded-4 overflow-hidden">
                    <!-- Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Upload Images</h5>
                        <button type="button" class="btn-close" @click="VisibleImagePostModal = false"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body bg-white">
                        <div class="container mx-auto">
                            <h2 class="text-2xl font-semibold mb-4 text-center">Upload Room Images</h2>
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
                            <div v-if="currentStep === 0">
                                <div class="d-flex justify-content-center mb-0">
                                    <div class="file-upload">
                                        <div class="image-upload-wrap" @click="triggerRoomImage1">
                                            <input ref="RoomsImages1Input" class="file-upload-input" type="file"
                                                accept="image/*" @change="handleroomImage1" />
                                            <div class="drag-text">
                                                <h3>Drag and drop a Room Images</h3>
                                            </div>
                                        </div>

                                        <!-- Image Preview Container -->
                                        <div class="file-upload-content" v-if="roomImage1Preview">
                                            <img class="file-upload-image" :src="roomImage1Preview" alt="Uploaded ID">

                                            <div class="image-title-wrap">
                                                <button type="button" @click="removeRoomImages1" class="remove-image">
                                                    Remove <span class="image-title">Uploaded
                                                        Image</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="currentStep === 1">
                                <div class="d-flex justify-content-center mb-0">
                                    <div class="file-upload">
                                        <div class="image-upload-wrap" @click="triggerRoomImage2">
                                            <input ref="RoomsImages2Input" class="file-upload-input" type="file"
                                                accept="image/*" @change="handleroomImage2" />
                                            <div class="drag-text">
                                                <h3>Drag and drop a Room Images</h3>
                                            </div>
                                        </div>

                                        <!-- Image Preview Container -->
                                        <div class="file-upload-content" v-if="roomImage2Preview">
                                            <img class="file-upload-image" :src="roomImage2Preview" alt="Uploaded ID">

                                            <div class="image-title-wrap">
                                                <button type="button" @click="removeRoomImages2" class="remove-image">
                                                    Remove <span class="image-title">Uploaded
                                                        Image</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="currentStep === 2">
                                <div class="d-flex justify-content-center mb-0">
                                    <div class="file-upload">
                                        <div class="image-upload-wrap" @click="triggerRoomImage3">
                                            <input ref="RoomsImages3Input" class="file-upload-input" type="file"
                                                accept="image/*" @change="handleroomImage3" />
                                            <div class="drag-text">
                                                <h3>Drag and drop a Room Images</h3>
                                            </div>
                                        </div>

                                        <!-- Image Preview Container -->
                                        <div class="file-upload-content" v-if="roomImage3Preview">
                                            <img class="file-upload-image" :src="roomImage3Preview" alt="Uploaded ID">

                                            <div class="image-title-wrap">
                                                <button type="button" @click="removeRoomImages3" class="remove-image">
                                                    Remove <span class="image-title">Uploaded
                                                        Image</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4  text-create">
                                <button type="button" class="btn btn-secondary" @click="prevStep"
                                    :disabled="currentStep === 0">
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary" @click="nextStep"
                                    :disabled="currentStep === steps.length - 1">
                                    Next
                                </button>
                            </div>

                            <!-- Image Grid -->

                        </div>
                    </div>

                    <!-- Footer -->
                    <button class="btn btn-secondary mb-2" @click="VisibleImagePostModal = false">Close</button>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import axios from 'axios';
import Toastcomponents from '@/components/Toastcomponents.vue';


export default {
    components: {
        Toastcomponents

    },
    data() {
        return {
            searchTerm: "",
            VisibleAddModal: false,
            VisibleDeleteModal: false,
            VisibleUpdateModal: false,
            VisibleDisplayDataModal: false,
            VisibleImagePostModal: false,
            steps: ["Upload Images 1 ", "Upload Images 2", "Upload Images 3"],
            currentStep: 0,
            roomImage1Preview: "",
            roomImage1File: "",
            roomImage2Preview: "",
            roomImage2File: "",
            roomImage3Preview: "",
            roomImage3File: "",
            loading: false,
            dorms: window.allRooms || [],
            dormsId: "",
            roomNumber: "",
            roomType: "",
            availability: '',
            availibilityArray: ['Available', 'Occupied', 'Under Maintenance'],
            price: "",
            amenities: "",
            capacity: '',
            amenitiesModal: false,
            amenities: [''],
            errors: {},
            rooms: [],
            selectedRoom: null,
            currentRoomID: null,
        };
    },
    methods: {
        dormId(dorm) {
            this.dormsId = dorm.dorm_id;
        },
        addAmenity() {
            this.amenities.push('');
        },
        submitAmenities() {
            console.log('Amenities:', this.amenities.filter(a => a.trim() !== ''));
            alert("Amenities submitted: " + this.amenities.filter(a => a.trim() !== '').join(', '));
            this.amenitiesModal = false;
        },
        validateForm() {
            this.errors = {};
            if (!this.roomNumber) {
                this.errors.roomNumber = ["Room number is required."];
            }
            if (!this.roomType) {
                this.errors.roomType = ["Room type is required."];
            }
            if (!this.availability) {
                this.errors.availability = ["Availability status is required."];
            }
            if (!this.price || isNaN(this.price) || this.price <= 0) {
                this.errors.price = ["Valid price is required."];
            }


            if (!this.capacity || isNaN(this.capacity) || this.capacity < 0) {
                this.errors.capacity = ["Valid capacity  are required."];
            }

            if (Object.keys(this.errors).length > 0) {
                return false;
            }
            return true;
        },
        async submitRoom() {
            if (!this.validateForm()) {
                alert("Please fix the errors in the form.");
                return;
            }
            try {
                const formData = new FormData();
                formData.append('dormsId', this.dormsId);
                formData.append('roomNumber', this.roomNumber);
                formData.append('roomType', this.roomType);
                formData.append('availability', this.availability);
                formData.append('price', this.price);
                formData.append('capacity', this.capacity);
                const response = await axios.post('/addRoom', formData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.data.status === "success") {
                    alert("Room added successfully!");
                    this.errors = {};
                } else if (response.data.error) {
                    this.errors = response.data.error;
                }
            }
            catch (error) {
                if (error.response) {
                    console.log('Error data:', error.response.data);
                    console.log('Input data that caused error:', error.response.data.input);
                }

                return;
            }
            this.amenitiesModal = true;
        },
        async fetchRooms() {
            try {
                const response = await axios.get('/ListRooms', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                this.rooms = response.data.rooms || [];
            } catch (error) {
                console.error('Error fetching rooms:', error);
            }
        },
        async ViewRoom(roomId) {
            try {

                const response = await axios.get(`/ViewRoom/${roomId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (response.data.status === "success") {
                    this.selectedRoom = response.data.room;
                    this.VisibleDisplayDataModal = true;
                } else {
                    console.error("Failed to fetch dorm details:", response.data.message);

                }
            } catch (error) {
                console.error("Error fetching dorm details:", error);
            }

        },
        confirmDelete() {
            alert("delete");
            this.VisibleDeleteModal = false;

        },
        UpdateRoom() {
            alert("Update");
        },
        DeleteRoom() {
            alert("Delete");

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
        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                let isValid = true;

                if (this.currentStep === 0) {
                    isValid = this.UploadImages1();



                } else if (this.currentStep === 1) {
                    isValid = this.UploadImages2();
                }
            }
        },
        UploadImages1() {
            this.currentStep = 1;
        },
        UploadImages2() {
            this.currentStep = 2;
        },


        //Room Images Picture
        handleroomImage1(event) {
            const file = event.target.files[0];
            if (file) {
                // Create object URL and revoke previous one if exists
                if (this.roomImage1Preview) {
                    URL.revokeObjectURL(this.roomImage1Preview);
                }
                this.roomImage1File = file;

                this.roomImage1Preview = URL.createObjectURL(file);
            }
        },
        triggerRoomImage1() {
            if (this.$refs.RoomsImages1Input) {
                this.$refs.RoomsImages1Input.click();
            }
        },

        removeRoomImages1() {
            if (this.roomImage1Preview) {
                URL.revokeObjectURL(this.roomImage1Preview);
            }
            this.roomImage1Preview = null;
            // Add null check for safety
            if (this.$refs.roomImage1Preview) {
                this.$refs.roomImage1Preview.value = ''; // Reset file input
            }
        },
        //image 2
        handleroomImage2(event) {
            const file = event.target.files[0];
            if (file) {
                // Create object URL and revoke previous one if exists
                if (this.roomImage2Preview) {
                    URL.revokeObjectURL(this.roomImage2Preview);
                }
                this.roomImage2File = file;

                this.roomImage2Preview = URL.createObjectURL(file);
            }
        },
        triggerRoomImage2() {
            if (this.$refs.RoomsImages2Input) {
                this.$refs.RoomsImages2Input.click();
            }
        },

        removeRoomImages2() {
            if (this.roomImage2Preview) {
                URL.revokeObjectURL(this.roomImage2Preview);
            }
            this.roomImage2Preview = null;
            // Add null check for safety
            if (this.$refs.roomImage2Preview) {
                this.$refs.roomImage2Preview.value = ''; // Reset file input
            }
        },
        //image 3
        handleroomImage3(event) {
            const file = event.target.files[0];
            if (file) {
                // Create object URL and revoke previous one if exists
                if (this.roomImage3Preview) {
                    URL.revokeObjectURL(this.roomImage3Preview);
                }
                this.roomImage3File = file;

                this.roomImage3Preview = URL.createObjectURL(file);
            }
        },
        triggerRoomImage3() {
            if (this.$refs.RoomsImages3Input) {
                this.$refs.RoomsImages3Input.click();
            }
        },

        removeRoomImages3() {
            if (this.roomImage3Preview) {
                URL.revokeObjectURL(this.roomImage3Preview);
            }
            this.roomImage3Preview = null;
            // Add null check for safety
            if (this.$refs.roomImage3Preview) {
                this.$refs.roomImage3Preview.value = ''; // Reset file input
            }
        },




    },
    mounted() {
        this.fetchRooms();
    },
    computed: {
        filteredRooms() {
            if (!this.searchTerm) return this.rooms;
            return this.rooms.filter(room =>
                Object.values(room).some(val =>
                    String(val).toLowerCase().includes(this.searchTerm.toLowerCase())
                )
            );
        }
    },
};
</script>

<style scoped>
.table-responsive {
    border-radius: 10px;
    overflow: hidden;
}

.file-upload-btn:hover {
    background: #1AA059;
    color: #ffffff;
    transition: all .2s ease;
    cursor: pointer;
}

.file-upload-btn:active {
    border: 0;
    transition: all .2s ease;
}

.file-upload-content {
    display: none;
    text-align: center;
}

.file-upload-input {
    position: absolute;
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    outline: none;
    opacity: 0;
    cursor: pointer;
}

.image-upload-wrap {
    margin-top: 20px;
    border: 4px dashed #4edce2;
    position: relative;
}

.image-dropping,
.image-upload-wrap:hover {
    background-color: #4edce2;
    border: 4px dashed #ffffff;
}

.image-title-wrap {
    padding: 0 15px 15px 15px;
    color: #222;
}

.drag-text {
    text-align: center;
}

.drag-text h3 {
    font-weight: 100;
    text-transform: uppercase;
    color: black;
    padding: 60px 0;
}

.file-upload-image {
    max-height: 200px;
    max-width: 200px;
    margin: auto;
    padding: 20px;
}

.remove-image {
    width: 200px;
    margin: 0;
    color: black;
    background: #4edce2;
    border: none;
    padding: 10px;
    border-radius: 4px;
    border-bottom: 4px solid #b02818;
    transition: all .2s ease;
    outline: none;
    text-transform: uppercase;
    font-weight: 700;
}

.remove-image:hover {
    background: #4edce2;
    color: black;
    transition: all .2s ease;
    cursor: pointer;
}

.remove-image:active {
    border: 0;
    transition: all .2s ease;
}

.file-upload-input {
    display: none;
}

.image-upload-wrap {
    border: 2px dashed #ddd;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    margin-bottom: 20px;
}

.file-upload-content {
    display: block;
    margin-top: 20px;
}

.file-upload-image {
    max-width: 100%;
    max-height: 300px;
    margin: 0 auto;
    display: block;
}

.remove-image {
    background: none;
    border: none;
    color: #ff0000;
    cursor: pointer;
    margin-top: 10px;
}
</style>
