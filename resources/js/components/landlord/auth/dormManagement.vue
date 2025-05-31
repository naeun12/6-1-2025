<template>
    <div class="container mt-5">
        <div v-if="loading" class="spinner-overlay">
            <div class="spinner"></div>
        </div>
        <Toastcomponents ref="toast" />


        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary fw-bold">Register Dorm</h1>
            <div>
                <button class="btn btn-outline-primary me-2" @click="ViewRoomsPage">View Rooms</button>
                <button class="btn btn-primary" @click="VisibleAddModal = true">
                    Add Dorm
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <input type="text" v-model="searchTerm" @input="onSearch" placeholder="🔍 Search Dorm..."
            class="form-control mb-4 shadow-sm" />
        <div v-if="dorms.length === 0" class="text-center text-muted">
            No dormitories found matching your search criteria.
        </div>
        <!-- Table -->
        <div class="table-responsive shadow-sm rounded p-3 bg-white">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th scope="col">Dorm ID</th>
                        <th scope="col">Dorm Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Contact Email</th>
                        <th scope="col">Contact Phone</th>
                        <th scope="col">Total Rooms</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="dorm in filteredDorms" :key="dorm.dorm_id" class="text-center">
                        <td>{{ dorm.dorm_id }}</td>
                        <td class="text-truncate" style="max-width: 150px;">{{ dorm.dorm_name }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ dorm.address }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ dorm.contact_email }}</td>
                        <td>{{ dorm.contact_phone }}</td>
                        <td>{{ dorm.total_rooms }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <button class="btn btn-sm btn-outline-success"
                                    @click="viewDorm(dorm.dorm_id)">View</button>
                                <button class="btn btn-sm btn-outline-primary"
                                    @click="editDorm(dorm.dorm_id)">Edit</button>
                                <button class="btn btn-sm btn-outline-danger"
                                    @click="deleteDorm(dorm.dorm_id)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination with Bootstrap 5 -->
        <div v-if="lastPage > 1" class="d-flex justify-content-center align-items-center my-3">
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li :class="['page-item', { disabled: currentPage === 1 }]">
                        <button class="page-link" :disabled="currentPage === 1" @click="fetchDorms(currentPage - 1)"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo; Prev</span>
                        </button>
                    </li>

                    <li class="page-item disabled">
                        <span class="page-link">
                            Page {{ currentPage }} of {{ lastPage }}
                        </span>
                    </li>

                    <li :class="['page-item', { disabled: currentPage === lastPage }]">
                        <button class="page-link" :disabled="currentPage === lastPage"
                            @click="fetchDorms(currentPage + 1)" aria-label="Next">
                            <span aria-hidden="true">Next &raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Modal Add Dorm -->
        <div v-if="VisibleAddModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white py-3">
                        <h5 class="modal-title fw-bold">🏠 Add Dorm</h5>
                        <button type="button" class="btn-close btn-close-white"
                            @click="VisibleAddModal = false"></button>
                    </div>
                    <Toastcomponents ref="toast" />


                    <!-- Modal Body -->
                    <div class="modal-body bg-white">
                        <form @submit.prevent="AddnewDorm">
                            <div class="row g-4">
                                <!-- Left Column -->
                                <div class="col-md-4">
                                    <div class="form-floating mb-3 mt-3">
                                        <input type="text" class="form-control" id="dormName" v-model="dorm_name"
                                            placeholder="Dorm Name">
                                        <label for="dormName">Dorm Name</label>
                                    </div>
                                    <span class="mb-3 text-danger" v-if="errors.dorm_name">{{ errors.dorm_name[0]
                                    }}</span>
                                    <div class="form-floating mb-3 mt-3">
                                        <input type="text" class="form-control" id="address" v-model="address"
                                            placeholder="Address" readonly>
                                        <label for="address">Address</label>
                                    </div>
                                    <span class="mb-3 text-danger " v-if="errors.address">
                                        {{ errors.address[0] }}
                                    </span>
                                    <div class="form-floating mb-3 mt-3">
                                        <textarea class="form-control" id="description" placeholder="Description"
                                            style="height: 120px;" v-model="description"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                    <span class="mb-3 text-danger" v-if="errors.description">{{ errors.description[0]
                                    }}</span>


                                    <div class="form-floating mb-3 mt-3">
                                        <input type="text" class="form-control" id="total_rooms"
                                            placeholder="Total Rooms" v-model="total_rooms">
                                        <label for="total_rooms">Total Rooms</label>
                                    </div>
                                    <span v-if="errors.total_rooms" class="mb-3 text-danger">{{ errors.total_rooms[0]
                                    }}</span>

                                </div>

                                <!-- Middle Column -->
                                <div class="col-md-4">
                                    <div class="form-floating mb-3 mt-3">
                                        <input type="email" class="form-control" id="contact_email"
                                            placeholder="Contact Email" v-model="contact_email">
                                        <label for="contact_email">Contact Email</label>
                                    </div>
                                    <span class="mb-3 text-danger mt-3" v-if="errors.contact_email">{{
                                        errors.contact_email[0] }}</span>
                                    <div class="form-floating mb-3 mt-3">
                                        <input type="tel" class="form-control" id="contact_phone"
                                            placeholder="Contact Phone" v-model="contact_phone">
                                        <label for="contact_phone">Contact Phone</label>
                                    </div>
                                    <span class="text-danger mb-3" v-if="errors.contact_phone">{{
                                        errors.contact_phone[0] }}</span>
                                    <div class="form-floating mb-3 mt-3">
                                        <textarea class="form-control" id="rules" placeholder="Rules"
                                            style="height: 120px;" v-model="rules"></textarea>
                                        <label for="rules">Rules</label>
                                    </div>
                                    <span class="mb-3 text-danger" v-if="errors.rules">{{ errors.rules[0] }}</span>
                                    <div class="d-grid mb-3 mt-3">
                                        <button type="button" class="btn btn-outline-primary"
                                            @click="VisibleMap = true">
                                            📍 View Map
                                        </button>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-outline-success btn-lg">
                                            ➕ Add Dorm
                                        </button>
                                    </div>
                                </div>
                                <!-- Right Column -->
                                <div
                                    class="col-md-4 d-flex flex-column justify-content-center align-items-center text-center p-4">
                                    <a class="navbar-brand d-flex align-items-center mb-2" href="#">
                                        <img :src="getAssetPath('images/Logo/logo.png')" alt="Company Logo" width="80"
                                            class="me-2">
                                        <span class="logo-text fw-bold fs-4 ">DormHub</span>
                                    </a>

                                    <div class="mt-3">
                                        <p class="text-muted small mb-1">
                                            📍 Click <strong>View Map</strong> to locate your dormitory.
                                        </p>
                                        <p class="text-muted small">
                                            ✅ Ensure all required fields are filled before submitting.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" @click="VisibleAddModal = false">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MAP MODAL -->
        <div v-if="VisibleMap" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);" @click.self="VisibleMap = false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dorm Location</h5>
                        <button type="button" class="btn-close" @click="VisibleMap = false" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="AddMap" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="VisibleMap = false">Back to
                            Inputs</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal -->
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
                        <p class="fs-5">Are you sure you want to delete this Dorm? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            @click="VisibleDeleteModal = false">Cancel</button>
                        <button type="button" class="btn btn-danger px-4" @click="confirmDelete()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Amenities Modal -->
        <div class="modal fade show d-block w-100" v-if="amenitiesModal" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);" @click.self="amenitiesModal = false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title">Add Amenities</h5>
                        <button type="button" class="btn-close btn-close-white" @click="amenitiesModal = false"
                            aria-label="Close"></button>
                    </div>
                    <Toastcomponents ref="toast" />


                    <div class="modal-body">
                        <div v-for="(amenity, index) in amenities" :key="index" class="form-floating mb-3">
                            <input type="text" class="form-control mb-2" v-model="amenities[index]"
                                :id="'amenity' + index" placeholder="Enter amenity" />
                            <label :for="'amenity' + index">Amenity {{ index + 1 }}</label>
                            <span class="text-danger mb-3 " v-if="errors.amenities">{{ errors.amenities[0] }}</span>

                        </div>

                        <button class="btn btn-primary w-25 mb-4" @click="addAmenity"
                            :disabled="amenities.length >= 4">Add Amenities</button>
                    </div>


                </div>
            </div>
        </div>
        <!-- Update Modal -->
        <div v-if="VisibleUpdateModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white py-3">
                        <h5 class="modal-title fw-bold">🏠 Update Dorm</h5>
                        <button type="button" class="btn-close btn-close-white"
                            @click="VisibleUpdateModal = false"></button>
                    </div>
                    <Toastcomponents ref="toast" />


                    <!-- Modal Body -->
                    <form @submit.prevent="updateDorm">
                        <div class="modal-body bg-white">
                            <div class="row g-4">
                                <!-- Left Column -->
                                <div class="col-md-4">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="dormName"
                                            v-model="editDormData.dorm_name" placeholder="Dorm Name">
                                        <label for="dormName">Dorm Name</label>
                                        <span class="text-danger small" v-if="errors.editDormData?.dorm_name">
                                            {{ errors.editDormData.dorm_name[0] }}
                                        </span>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="address"
                                            v-model="editDormData.address" placeholder="Address">
                                        <label for="address">Address</label>
                                        <span class="text-danger small" v-if="errors.editDormData?.address">
                                            {{ errors.editDormData.address[0] }}
                                        </span>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <textarea class="form-control" id="description"
                                            v-model="editDormData.description" placeholder="Description"
                                            style="height: 120px;"></textarea>
                                        <label for="description">Description</label>
                                        <span class="text-danger small" v-if="errors.editDormData?.description">
                                            {{ errors.editDormData.description[0] }}
                                        </span>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="total_rooms"
                                            v-model="editDormData.total_rooms" placeholder="Total Rooms">
                                        <label for="total_rooms">Total Rooms</label>
                                        <span class="text-danger small" v-if="errors.editDormData?.total_rooms">
                                            {{ errors.editDormData.total_rooms[0] }}
                                        </span>
                                    </div>
                                    <div class="border rounded p-2">
                                        <div class="row fw-bold border-bottom py-2 text-center">
                                            <div class="col">Amenity</div>
                                            <div class="col-3">Actions</div>
                                        </div>

                                        <div v-for="amenity in editDormData.amenities"
                                            :key="amenity.pivot ? amenity.pivot.id : amenity.id"
                                            class="row align-items-center py-2 border-bottom text-center">
                                            <div class="col">
                                                <input type="text" readonly class="form-control text-center"
                                                    v-model="amenity.name" placeholder="Amenity name" />
                                            </div>
                                            <div class="col-3 d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-danger"
                                                    @click.prevent="deleteAmenity(amenity.pivot.id)">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>




                                </div>

                                <!-- Middle Column -->
                                <div class="col-md-4">
                                    <div class="form-floating mb-2">
                                        <input type="email" class="form-control" id="contact_email"
                                            v-model="editDormData.contact_email" placeholder="Contact Email">
                                        <label for="contact_email">Contact Email</label>
                                        <span class="text-danger small" v-if="errors.editDormData?.contact_email">
                                            {{ errors.editDormData.contact_email[0] }}
                                        </span>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="tel" class="form-control" id="contact_phone"
                                            v-model="editDormData.contact_phone" placeholder="Contact Phone">
                                        <label for="contact_phone">Contact Phone</label>
                                        <span class="text-danger small" v-if="errors.editDormData?.contact_phone">
                                            {{ errors.editDormData.contact_phone[0] }}
                                        </span>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <textarea class="form-control" id="rules" placeholder="Rules"
                                            v-model="editDormData.rules" style="height: 120px;"></textarea>
                                        <label for="rules">Rules</label>
                                        <span class="text-danger small" v-if="errors.editDormData?.rules">
                                            {{ errors.editDormData.rules[0] }}
                                        </span>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="Optional"
                                            v-model="editDormData.newAmenities" placeholder="Optional Add Amenities">
                                        <label for="Optional">(Optional) Add Amenities</label>
                                    </div>
                                    <span class="text-danger small" v-if="errors.editDormData?.newAmenities">
                                        {{ errors.editDormData.newAmenities[0] }}
                                    </span>

                                    <div class="mb-2">
                                        <button type="button" class="btn btn-outline-secondary w-100"
                                            @click="addnewAmenity()">Add Amenity</button>
                                    </div>


                                    <div class="d-grid gap-2 mt-3">
                                        <button type="button" class="btn btn-outline-primary"
                                            @click="UpdateVisibleMap = true">
                                            📍 View Map
                                        </button>
                                        <button type="submit" class="btn btn-outline-success btn-lg">
                                            ➕ Update Dorm
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="col-md-4 d-flex flex-column justify-content-center align-items-center text-center p-4">
                                    <a class="navbar-brand d-flex align-items-center mb-2" href="#">
                                        <img :src="getAssetPath('images/Logo/logo.png')" alt="Company Logo" width="80"
                                            class="me-2">
                                        <span class="logo-text fw-bold fs-4 ">DormHub</span>
                                    </a>

                                    <div class="mt-3">
                                        <p class="text-muted small mb-1">
                                            📍 Click <strong>View Map</strong> to locate your dormitory.
                                        </p>
                                        <p class="text-muted small">
                                            ✅ Ensure all required fields are filled before submitting.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary"
                                @click="VisibleUpdateModal = false">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Map View -->
        <div v-if="UpdateVisibleMap" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);" @click.self="UpdateVisibleMap = false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dorm Location</h5>
                        <button type="button" class="btn-close" @click="UpdateVisibleMap = false"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="UpdateVisibleMap = false">Back to
                            Inputs</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Display Data Modal -->
        <div v-if="VisibleDisplayDataModal" class="modal fade show d-block w-100" tabindex="-1"
            style="background-color: rgba(0,0,0,0.5);" @click.self="VisibleDisplayDataModal = false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title" id="tenantModalLabel">Dormitory Information</h5>
                        <button type="button" class="btn-close btn-close-white" @click="VisibleDisplayDataModal = false"
                            aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto; padding: 1.5rem;">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Dorm Name:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{ selectedDorm?.dorm_name }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address:</label>
                                    <div class="p-2 border rounded bg-light text-break"
                                        style="max-height: 100px; overflow-y: auto;">
                                        {{ selectedDorm?.address }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Contact Email:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{ selectedDorm?.contact_email
                                    }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold align-text-center">Amenities:</label>


                                    <div class="row gap-2">
                                        <div v-for="amenity in selectedDorm?.amenities" :key="amenity.id"
                                            class="col-auto">
                                            <span class="badge bg-primary text-white px-3 py-2 shadow-sm"
                                                style="font-size: 0.9rem;">
                                                {{ amenity.name }}
                                            </span>
                                        </div>
                                    </div>



                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{ selectedDorm?.description
                                    }}</div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Contact Phone:</label>
                                    <div class="p-2 border rounded bg-light text-break">{{
                                        selectedDorm?.contact_phone
                                    }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Available Rooms:</label>
                                    <div class="p-2 border rounded bg-light">{{ selectedDorm?.available_rooms }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Registration Date:</label>
                                    <div class="p-2 border rounded bg-light">{{ formatDate(selectedDorm?.created_at)
                                    }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Rules:</label>
                                    <div class="p-2 border rounded bg-light text-break"
                                        style="max-height: 120px; overflow-y: auto;">
                                        {{ selectedDorm?.rules }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal Footer -->

</template>

<script>
import axios from 'axios';
import Toastcomponents from '@/components/Toastcomponents.vue';

export default {
    components: {
        Toastcomponents

    },
    name: "MapView",
    data() {
        return {
            searchTerm: '',
            VisibleAddModal: false,
            VisibleMap: false,
            UpdateVisibleMap: false,
            VisibleDeleteModal: false,
            VisibleUpdateModal: false,
            VisibleDisplayDataModal: false,
            dorm_name: "",
            address: "",
            description: "",
            total_rooms: "",
            contact_email: "",
            contact_phone: "",
            rules: "",
            longitude: "",
            latitude: "",
            amenitiesModal: false,
            amenities: [''],
            inputamenities: '',
            errors: {},
            loading: false,
            dorms: [],
            dormId: '',
            selectedDorm: null,
            currentDormId: null,
            currntamenitiesId: null,
            editDormData: {
                dorm_id: null,
                dorm_name: "",
                address: "",
                description: "",
                total_rooms: "",
                contact_email: "",
                contact_phone: "",
                rules: "",
                latitude: "",
                longitude: "",
                newAmenities: '',
            },
            lastPage: 1,
            currentPage: 1,
            newAmenity: ''



        };
    },
    methods: {
        ViewRoomsPage() {
            const landlord = window.landlordId;

            if (!landlord) {
                alert("Landlord ID not found!");
                return;
            }

            alert(landlord);
            window.location.href = `/landlordRoomManagement/${landlord}`;
        },
        fill() {
            this.dorm_name = " ";
            this.address = " ";
            this.description = " ";
            this.total_rooms = " ";
            this.contact_email = " ";
            this.contact_phone = " ";
            this.rules = " ";
        },
        emptyValidation() {
            this.errors = {};
            if (!this.dorm_name) this.errors.dorm_name = ['Required Dormitory name '];
            if (!this.address) this.errors.address = ['Required Address'];
            if (!this.description) this.errors.description = ['Required Description'];
            if (!this.total_rooms) this.errors.total_rooms = [' Required Total Rooms '];
            if (!this.contact_email) this.errors.contact_email = ['Required Contact Email'];
            if (!this.contact_phone) this.errors.contact_phone = ['Required Contact phone'];
            if (!this.rules) this.errors.rules = ['Required Rules'];
            return Object.keys(this.errors).length === 0;


        },
        EditEmptyValidation() {
            this.errors = {};
            if (!this.editDormData?.dorm_name) {
                this.errors.editDormData ??= {};
                this.errors.editDormData.dorm_name = ['Dormitory name is required.'];
            }
            if (!this.editDormData?.address) {
                this.errors.editDormData ??= {};
                this.errors.editDormData.address = ['Address is required.'];
            }
            if (!this.editDormData?.description) {
                this.errors.editDormData ??= {};
                this.errors.editDormData.description = ['Description is required.'];
            }

            if (!this.editDormData?.total_rooms) {
                this.errors.editDormData ??= {};
                this.errors.editDormData.total_rooms = ['Total rooms are required.'];
            }
            if (!this.editDormData?.contact_email) {
                this.errors.editDormData ??= {};
                this.errors.editDormData.contact_email = ['Contact email is required.'];
            }
            if (!this.editDormData?.contact_phone) {
                this.errors.editDormData ??= {};
                this.errors.editDormData.contact_phone = ['Contact phone is required.'];
            }
            if (!this.editDormData?.rules) {
                this.errors.editDormData ??= {};
                this.errors.editDormData.rules = ['Rules are required.'];
            }
            return Object.keys(this.errors).length === 0;


        },
        async deleteDorm(dormId) {
            this.currentDormId = dormId;
            this.VisibleDeleteModal = true;
        },
        async deleteAmenity(id) {

            this.amenitiesId = id;

            if (this.amenitiesId) {
                this.loading = true; // Show spinner

                try {
                    const response = await axios.delete(`/delete-amenities/${this.amenitiesId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    this.loading = false; // Hide spinner

                    if (response.data.status === "success") {
                        this.$refs.toast.showToast(response.data.message, 'success');
                        this.fetchDorms();
                        this.VisibleUpdateModal = false;
                    } else {
                        this.$refs.toast.showToast('Failed to delete amenities. Please try again.', 'error');
                    }
                } catch (error) {
                    this.loading = false; // Hide spinner
                    console.error("Error deleting amenities:", error);
                    console.log("Deleting amenity with ID:", this.amenitiesId);

                }
            } else {
                console.warn("No dorm ID provided for deleting amenities.");
            }
        },
        confirmDelete() {
            if (this.currentDormId) {
                this.loading = true; // Hide spinner

                axios.delete(`/DeleteDorm/${this.currentDormId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        this.loading = false; // Hide spinner

                        if (response.data.status === "success") {
                            this.VisibleDeleteModal = false;
                            this.fetchDorms(); // Refresh dorm list
                            this.$refs.toast.showToast(response.data.message, 'success');
                        } else {
                            this.$refs.toast.showToast('Failed to delete dorm. Please try again.', 'success');

                        }
                    })
                    .catch(error => {
                        this.loading = false; // Hide spinner

                        console.error("Error deleting dorm:", error);
                        alert('An error occurred while deleting the dorm. Please try again.');
                    });
            } else {
                console.warn("No dorm ID provided for deletion.");
            }
        },
        async AddnewDorm() {
            if (this.emptyValidation()) {
                this.loading = true; // Show spinner

                const formData = new FormData();
                formData.append('dorm_name', this.dorm_name);
                formData.append('address', this.address);
                formData.append('description', this.description);
                formData.append('latitude', this.latitude);
                formData.append('longitude', this.longitude);
                formData.append('total_rooms', this.total_rooms);
                formData.append('contact_email', this.contact_email);
                formData.append('contact_phone', this.contact_phone);
                formData.append('rules', this.rules);

                try {
                    const response = await axios.post('/AddDorm', formData, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.data.status === "success") {

                        this.amenitiesModal = true;
                        this.VisibleAddModal = false;
                        this.$refs.toast.showToast(response.data.message, 'success');

                        this.fill();
                        this.errors = {};
                        this.dormId = response.data.dormId
                        await this.fetchDorms(); // Refresh dorm list
                    } else if (response.data.errors) {
                        this.errors = response.data.errors;
                    }
                } catch (error) {
                    this.loading = false; // Hide spinner
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                        console.error("Validation errors:", this.errors);
                    }
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error("Error adding dorm:", error);
                        alert('An error occurred while adding the dorm. Please try again.');

                    }
                }
            }
        },

        async editDorm(dormId) {
            this.loading = true; // Show spinner
            try {
                const response = await axios.get(`/ViewDorm/${dormId}`);
                if (response.data.status === "success") {
                    this.loading = false;
                    this.editDormData = {

                        ...response.data.dorm,
                        dorm_id: dormId
                    };

                    this.VisibleUpdateModal = true;

                } else {
                    console.error("Failed to fetch dorm details:", response.data.message);
                    alert("Failed to load dorm details for editing");
                }
            } catch (error) {
                console.error("Error fetching dorm details:", error);
                alert("An error occurred while loading dorm details");
            }
        },
        async addAmenity() {
            this.loading = true; // Show spinner
            if (this.amenities.some(a => a.trim() === '')) {
                this.errors.amenities = ['Please fill in all amenity fields before submitting.'];
                return;
            }

            this.errors = {};

            for (const amenity of this.amenities) {
                try {
                    const response = await axios.post('/add-amenities', {
                        amenities: amenity.trim(),
                        dorm_id: this.dormId,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.data.status === 'success') {
                        this.loading = false;
                        this.amenities = [''];
                        this.inputamenities = '';
                        this.amenitiesModal = true;

                        this.$refs.toast.showToast(`${amenity} added successfully.`, 'success');
                    } else if (response.data.errors) {
                        this.errors.amenities = [response.data.message];
                    } else {
                        this.$refs.toast.showToast('An unexpected error occurred while adding amenity.', 'error');
                    }

                } catch (error) {
                    // Show Laravel validation or custom error message
                    if (error.response && error.response.data) {
                        const res = error.response.data;

                        if (res.errors && res.errors.amenities) {
                            this.errors.amenities = res.errors.amenities;
                            this.$refs.toast.showToast(this.errors.amenities[0], 'error');
                        } else if (res.message) {
                            this.errors.amenities = [res.message];
                            this.$refs.toast.showToast(res.message, 'error');
                        } else {
                            this.$refs.toast.showToast('An unexpected error occurred.', 'error');
                        }
                    } else {
                        this.$refs.toast.showToast('An unexpected error occurred.', 'error');
                    }

                    console.error('Error adding amenity:', error);
                }
            }
        },
        async updateDorm() {
            this.loading = true;
            if (this.EditEmptyValidation()) {
                // Hide spinner

                const formData = new FormData();
                formData.append('dorm_name', this.editDormData.dorm_name);
                formData.append('address', this.editDormData.address);
                formData.append('description', this.editDormData.description);
                formData.append('latitude', this.editDormData.latitude);
                formData.append('longitude', this.editDormData.longitude);
                formData.append('total_rooms', this.editDormData.total_rooms);
                formData.append('contact_email', this.editDormData.contact_email);
                formData.append('contact_phone', this.editDormData.contact_phone);
                formData.append('rules', this.editDormData.rules);


                try {
                    const response = await axios.post(`/UpdateDorm/${this.editDormData.dorm_id}`, formData, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    // Hide spinner

                    if (response.data.status === "success") {
                        this.VisibleUpdateModal = false;
                        this.fill();
                        this.errors = {};
                        this.$refs.toast.showToast(response.data.message, 'success');
                        this.loading = false;
                        await this.fetchDorms(); // Refresh dorm list
                    } else if (response.data.errors) {
                        this.errors = response.data.errors;
                    }
                } catch (error) {
                    this.loading = false; // Hide spinner
                    if (error.response && error.response.data && error.response.data.message) {
                        this.errors.error.response.data.errors;
                    }
                    else if (error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error("Error updating dorm:", error);
                        alert('An error occurred while updating the dorm. Please try again.');
                    }
                }
            }
            else {
                this.loading = false; // Hide spinner
            }


        },

        getAssetPath(path) {
            return `/` + path;
        },
        async addnewAmenity() {
            if (!this.editDormData?.newAmenities || this.editDormData.newAmenities.trim() === '') {
                this.errors.editDormData ??= {};
                this.errors.editDormData.newAmenities = ['Please fill in the amenity field before submitting.'];
                return;
            }

            // Clear previous errors
            this.errors.amenities = [];

            const formData = new FormData();
            formData.append('amenities', this.editDormData.newAmenities);
            formData.append('dorm_id', this.editDormData.dorm_id);

            try {
                const response = await axios.post('/add-amenities', formData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const res = response.data;

                if (res.status === 'success') {

                    this.$refs.toast.showToast(' added successfully.');
                    //this.editDormData.newAmenities = '';
                    this.VisibleUpdateModal = false;
                    this.errors = {};
                    this.fetchDorms();

                } else {
                    this.errors.amenities = [res.message || 'Failed to add amenity.'];
                    this.$refs.toast.showToast(this.errors.amenities[0], 'error');
                }

            } catch (error) {
                if (error.response && error.response.data) {
                    const res = error.response.data;

                    // Laravel's default validation error structure
                    if (res.errors) {
                        this.errors.editDormData ??= {};

                        if (res.errors.amenities) {
                            this.errors.editDormData.amenities = res.errors.amenities;
                            this.$refs.toast.showToast(res.errors.amenities[0], 'error');
                        }

                    } else if (res.message) {

                        this.errors.editDormData ??= {};
                        this.errors.editDormData.newAmenities = [res.message];


                    } else {
                        // Unexpected format
                        this.errors.editDormData ??= {};
                        this.errors.editDormData.amenities = ['An unexpected error occurred.'];
                        this.$refs.toast.showToast('An unexpected error occurred.', 'error');
                    }
                } else {
                    this.errors.editDormData ??= {};
                    this.errors.editDormData.amenities = ['Network or unknown error occurred.'];
                    this.$refs.toast.showToast('Network or unknown error occurred.', 'error');
                }
            }


        },

        async viewDorm(dormId) {
            this.loading = true;
            try {
                const response = await axios.get(`/ ViewDorm / ${dormId} `, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (response.data.status === "success") {
                    this.loading = false;
                    this.selectedDorm = response.data.dorm;
                    this.VisibleDisplayDataModal = true;
                } else {
                    console.error("Failed to fetch dorm details:", response.data.message);
                    // Handle error, e.g., show a notification
                }
            } catch (error) {
                console.error("Error fetching dorm details:", error);
                // Handle error, e.g., show a notification
            }
        },
        initMap() {
            // Common locations and settings
            const mandaue = { lat: 10.330025, lng: 123.914337 };
            const lapuLapu = { lat: 10.309897, lng: 123.949997 };
            const centerPoint = { lat: 10.32, lng: 123.93 };
            const defaultZoom = 13;

            // Initialize geocoder (used by both maps)
            const geocoder = new google.maps.Geocoder();

            // Helper function to handle map clicks
            const handleMapClick = (clickedLatLng, isUpdateMap = false) => {
                geocoder.geocode({ location: clickedLatLng }, (results, status) => {
                    if (status === "OK") {
                        if (results[0]) {
                            const address = results[0].formatted_address;
                            const latitude = clickedLatLng.lat();
                            const longitude = clickedLatLng.lng();

                            if (isUpdateMap) {
                                this.editDormData.address = address;
                                this.editDormData.latitude = latitude;
                                this.editDormData.longitude = longitude;
                                this.UpdateVisibleMap = false;
                            } else {
                                this.address = address;
                                this.latitude = latitude;
                                this.longitude = longitude;
                                this.VisibleMap = false;
                            }
                        } else {
                            const message = `No address found.Coordinates: \nLat: ${clickedLatLng.lat()} \nLng: ${clickedLatLng.lng()} `;
                            alert(message);
                        }
                    } else {
                        alert(`Geocoder failed: ${status} `);
                    }
                });
            };

            // Add Dorm Map
            if (this.VisibleMap) {
                const addMapElement = document.getElementById("AddMap");
                if (addMapElement && !addMapElement._map) { // Check if map already initialized
                    const addMap = new google.maps.Map(addMapElement, {
                        center: centerPoint,
                        zoom: defaultZoom,
                    });

                    // Add markers
                    new google.maps.Marker({
                        position: mandaue,
                        map: addMap,
                        title: "Mandaue City"
                    });
                    new google.maps.Marker({
                        position: lapuLapu,
                        map: addMap,
                        title: "Lapu-Lapu City"
                    });

                    // Add click listener
                    addMap.addListener("click", (mapsMouseEvent) => {
                        handleMapClick(mapsMouseEvent.latLng);
                    });

                    // Store reference to prevent re-initialization
                    addMapElement._map = addMap;
                }
            }

            // Update Dorm Map
            if (this.UpdateVisibleMap) {
                const updateMapElement = document.getElementById("map");
                if (updateMapElement && !updateMapElement._map) { // Check if map already initialized
                    const updateMap = new google.maps.Map(updateMapElement, {
                        center: this.editDormData.latitude && this.editDormData.longitude
                            ? { lat: parseFloat(this.editDormData.latitude), lng: parseFloat(this.editDormData.longitude) }
                            : centerPoint,
                        zoom: defaultZoom,
                    });

                    // Add markers
                    new google.maps.Marker({
                        position: mandaue,
                        map: updateMap,
                        title: "Mandaue City"
                    });
                    new google.maps.Marker({
                        position: lapuLapu,
                        map: updateMap,
                        title: "Lapu-Lapu City"
                    });

                    // Add existing location marker if available
                    if (this.editDormData.latitude && this.editDormData.longitude) {
                        new google.maps.Marker({
                            position: {
                                lat: parseFloat(this.editDormData.latitude),
                                lng: parseFloat(this.editDormData.longitude)
                            },
                            map: updateMap,
                            title: "Current Location",
                            icon: {
                                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                            }
                        });
                    }

                    // Add click listener
                    updateMap.addListener("click", (mapsMouseEvent) => {
                        handleMapClick(mapsMouseEvent.latLng, true);
                    });

                    // Store reference to prevent re-initialization
                    updateMapElement._map = updateMap;
                }
            }
        },
        async fetchDorms(page = 1) {
            this.loading = true;
            try {
                const response = await axios.get('/SearchDorms', {
                    params: { page, search: this.searchTerm || '' },
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
                });

                if (response.data.status === "success") {
                    this.dorms = response.data.dorms.data;
                    this.currentPage = response.data.dorms.current_page;
                    this.lastPage = response.data.dorms.last_page;
                } else {
                    console.error("Failed to fetch dorms:", response.data.message);
                }
            } catch (error) {
                console.error("Error fetching dorms:", error);
            } finally {
                this.loading = false;
            }
        },
        formatDate(dateStr) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateStr).toLocaleDateString('en-US', options);
        }
    },
    onSearch() {
        this.currentPage = 1; // Reset to the first page
        this.fetchDorms(1); // Fetch dorms with the search term
    },


    computed: {
        filteredDorms() {
            const searchTermLower = this.searchTerm.toLowerCase();

            return this.dorms.filter(dorm => {
                return (
                    dorm.dorm_name.toLowerCase().includes(searchTermLower) ||
                    dorm.address.toLowerCase().includes(searchTermLower) ||
                    dorm.contact_email?.toLowerCase().includes(searchTermLower)
                );
            });
        }
    },
    mounted() {
        if (!window.google) {
            const script = document.createElement("script");
            script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCyQYH_O-3v9vW6ba_V653qgVECSxII0GU&callback=initMap";

            script.async = true;
            script.defer = true;
            // Set up callback
            window.initMap = this.initMap;
            script.onerror = () => {
                console.error("Google Maps failed to load.");
            };
            document.head.appendChild(script);
        } else {
            this.initMap(); // If already loaded
        }
        this.fetchDorms();

    },


    watch: {
        VisibleMap(val) {
            if (val) {
                this.$nextTick(() => {
                    this.initMap();
                });
            }
        },
        UpdateVisibleMap(val) {
            if (val) {
                this.$nextTick(() => {
                    this.initMap();
                });
            }
        },
    },

};
</script>

<style scoped>
.table-responsive {
    border-radius: 10px;
    overflow: hidden;
}

.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 6px solid #ccc;
    border-top-color: #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    /* smooth scrolling on iOS */
    max-width: 100%;
}

.table-responsive table {
    min-width: 700px;
    /* Adjust based on your table's total width */
}
</style>