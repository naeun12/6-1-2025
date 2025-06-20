<template>
    <div class="container-fluid py-4 bg-light min-vh-100">
        <div class="input-group mb-4 w-100 shadow-sm rounded-pill overflow-hidden">
            <span class="input-group-text bg-white border-0">
                <i class="bi bi-search text-primary"></i>
            </span>
            <input type="text" class="form-control border-0 shadow-none" placeholder="Search Locations"
                aria-label="Search Locations" />
        </div>
        <div class="row mb-4">
            <!-- Price Range Dropdown -->
            <div class="col-md-6 col-lg-4 mb-2">
                <select class="form-select shadow-sm">
                    <option disabled value="">Select Price Range</option>
                    <option value="all">All Prices</option>
                    <option value="0-100">₱0 - ₱100</option>
                    <option value="101-200">₱101 - ₱200</option>
                    <option value="201-300">₱201 - ₱300</option>
                    <option value="301+">₱301 and above</option>
                </select>
            </div>

            <!-- Occupancy Type Dropdown -->
            <div class="col-md-6 col-lg-4 mb-2">
                <select class="form-select shadow-sm">
                    <option disabled value="">Select Occupancy Type</option>
                    <option value="all">All Types</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Mixed">Mixed</option>
                </select>

            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3" v-for="(dormitorie, dorm_id) in dormitories" :key="dorm_id">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden d-flex flex-column">
                    <div class="image-wrapper">
                        <img :src="dormitorie?.images?.main_image || 'https://via.placeholder.com/300x200?text=No+Image'"
                            class="card-img-top" :alt="dormitorie.name" />
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <h5 class="card-title text-dark fw-bold">{{ dormitorie.dorm_name }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="bi bi-person-fill"></i> {{ dormitorie.occupancy_type }}
                            </p>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-geo-alt-fill"></i> {{ dormitorie.address }}
                            </p>
                        </div>
                        <div class="mt-4 d-flex justify-content-center">
                            <button class="btn btn-outline-primary rounded-pill px-4 w-100">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <h2 class="mb-4 text-primary fw-semibold text-center">Find Your Ideal Dorm in Lapu-Lapu City</h2>

    </div>
</template>


<script>
import axios from 'axios';
export default {
    name: 'ProductGrid',
    data() {
        return {
            dormitories: [],
        }
    },
    methods: {
        async dormListingfetch() {
            try {
                const response = await axios.get('/list-dorms');
                console.log(response.data.dorms);
                this.dormitories = response.data.dorms;

            } catch (error) {
                console.error("Error fetching dorms:", error);
            }
        }
    },
    mounted() {
        this.dormListingfetch();
    },
}
</script>

<style scoped>
.card:hover {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}

.image-wrapper {
    height: 200px;
    /* You can adjust this height */
    overflow: hidden;
}

.card-img-top {
    height: 100%;
    width: 100%;
    object-fit: cover;
}
</style>
