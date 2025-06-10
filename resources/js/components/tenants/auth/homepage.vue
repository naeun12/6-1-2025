<template>

    <div class="container text-center mt-4 mb-5">
        <form class="d-flex justify-content-center search-input">
            <input class="form-control me-2 w-50" type="search" placeholder="Search Rooms locations"
                aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>
    <div
        class="container mt-3 d-flex flex-wrap align-items-center gap-3 justify-content-between bg-light p-3 rounded custom-border">
        <ul class="list-unstyled d-flex gap-4 mb-0 order-2 ms-auto">
            <li><a href="#" class="text-decoration-none fw-semibold text-dark">Room Reservation</a></li>
            <li><a href="#" class="text-decoration-none fw-semibold text-dark">Tenant Submissions</a></li>
        </ul>

        <div class="d-flex gap-3 justify-content-start flex-grow-1 order-1">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="priceDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 150px;">
                    Estimated Price
                </button>
                <ul class="dropdown-menu" aria-labelledby="priceDropdown">
                    <li><a class="dropdown-item" href="#">Under $100</a></li>
                    <li><a class="dropdown-item" href="#">$100 - $300</a></li>
                    <li><a class="dropdown-item" href="#">Above $300</a></li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn btn-outline-success dropdown-toggle" type="button" id="ratingDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 150px;">
                    Top Rating
                </button>
                <ul class="dropdown-menu" aria-labelledby="ratingDropdown">
                    <li><a class="dropdown-item" href="#">4 stars & up</a></li>
                    <li><a class="dropdown-item" href="#">3 stars & up</a></li>
                    <li><a class="dropdown-item" href="#">All ratings</a></li>
                </ul>
            </div>
        </div>
    </div>


    <!-- Map Section -->
    <section class="py-5 bg-light mt-4">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold text-primary">
                Discover Dormitories Around Lapu-Lapu and Mandaue
            </h2>
            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-3 p-2" v-for="room in rooms" :key="room.room_id"
                    data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine">
                    <div class="dorm-card card h-100">
                        <div class="dorm-image">
                            <img :src="room.images?.main_image" class="card-img-top"
                                :alt="`Image of ${room.dorm?.dorm_name || 'Dorm'}`"
                                style="height: 200px; object-fit: cover;" />
                        </div>
                        <div class="card-header card-header-style py-3">
                            <h5> {{ room.dorm_name || 'Available Dorm' }}</h5>
                        </div>


                        <div class="card-body card-body-style">
                            <p class="location">{{ room.address || 'Location unavailable' }}</p>
                            <p class="description">
                                {{ room.description || 'No description available.' }}
                            </p>
                            <button class="btn " @click="viewDorms(room.dorm_id)">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            rooms: [],

        };
    },
    methods: {

        viewDorms(dormitoryId) {
            const tenant = window.tenant_id;

            if (!tenant) {
                alert("tenant_id id not found");
                return;
            }

            window.location.href = `/room-details/${dormitoryId}/${tenant}`;
        },
        async fetchDorms() {
            try {
                const response = await axios.get('/list-dorms')
                if (response.data.status === 'success') {
                    this.rooms = response.data.dorms;
                }
            }
            catch (error) {

            }
        },


    },
    mounted() {

        this.fetchDorms();
    }


}
</script>
<style>
.carousel-caption {
    padding: 1rem;
    backdrop-filter: blur(3px);
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
}

.carousel-inner {
    max-height: 500px;
}

.carousel-inner img {
    height: 500px;
    object-fit: cover;
    width: 100%;
}

@media (max-width: 768px) {
    .carousel-inner img {
        height: 300px;
    }
}

.profile-picture {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

/* Card Title Styling */
.card-title {
    font-weight: bold;
    color: #333;
}

/* Card Subtitle Styling */
.card-subtitle {
    font-size: 14px;
    color: #6c757d;
}

/* Description Styling */
.card-description {
    font-size: 14px;
    color: #6c757d;
}

/* Timestamp Styling */
.card-timestamp {
    font-size: 12px;
    color: #999;
}

/* Button Styling */
.btn-follow {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.btn-message {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

/* Card Footer Styling */
.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.text-decoration-none:hover {
    color: #0d6efd;
    /* Bootstrap primary blue */
    text-decoration: underline;
}

/* Hover effect for dropdown buttons */
.btn-primary:hover {
    background-color: #0b5ed7;
    /* Slightly darker blue */
    border-color: #0a58ca;
}

.custom-border {
    border: 2px solid #4edce2;
}

.btn {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 25px;
    box-shadow: #777 0px 25px 20px -20px;
    transition: transform 1s ease, box-shadow 0.3s ease;
    background-color: #4edce2;
}

.btn:hover {

    background-color: #093334;
    color: white;
    transform: scale(1.1);
    box-shadow: 0px 10px 15px -5px #555;
}

.image {
    width: 200%;
    height: 100%;
}

.dorm-card {
    width: 100%;
    /* Ensure full width within the column */
    height: 500px;
    background-color: #fff;
    border: 2px solid #4edce2;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 16px;
}

.card-img-top {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.card-header-style {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card-header h3 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.card-body-style {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.location {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.description {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
}

.features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.feature-btn {
    background-color: transparent;
    border: 1px solid #ccc;
    color: #333;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 12px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.feature-btn:hover {
    background-color: #f0f0f0;
}

.view-details-btn {
    background-color: #007bff;
    color: #fff;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
</style>