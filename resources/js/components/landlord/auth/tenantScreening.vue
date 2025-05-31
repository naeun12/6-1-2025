<template>
    <div class="p-4 mt-4">
        <!-- Header -->

        <!-- Search Bar -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search Tenants" v-model="searchQuery"
                @keyup="filterTenants" />
        </div>

        <!-- Table -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tenant ID</th>
                    <th>Tenant Name</th>
                    <th>Email</th>
                    <th>Dorm Name</th>
                    <th>Room No</th>
                    <th>Move-In Date</th>
                    <th>Payment Status</th>
                    <th>Application Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tenant in filteredTenants" :key="tenant.id">
                    <td>{{ tenant.tenantId }}</td>
                    <td>{{ tenant.name }}</td>
                    <td>{{ tenant.email }}</td>
                    <td>{{ tenant.dormName }}</td>
                    <td>{{ tenant.roomNo }}</td>
                    <td>{{ tenant.moveInDate }}</td>
                    <td>{{ tenant.paymentStatus }}</td>
                    <td>{{ tenant.applicationStatus }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" @click="VisibleModalApproval = true">Update</button>
                        <button class="btn btn-sm btn-danger ms-2" @click="VisibleDeleteModal = true">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!--Modal Tenant Appoval-->
        <!-- Use v-if to render the modal only if needed -->
        <div v-if="VisibleModalApproval" class="modal d-block" tabindex="-1" id="tenantModal"
            style="background: rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tenantModalLabel">Tenant Information</h5>
                        <button type="button" class="btn-close" @click="VisibleModalApproval = false"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Tenant Image -->
                        <div class="text-center mb-3">
                            <img :src="tenant.image || 'https://via.placeholder.com/150'" alt="Tenant Profile Picture"
                                class="rounded-circle img-fluid" style="max-width: 150px" />
                            <p class="mt-2 text-center">{{ tenant.id }}</p>
                        </div>

                        <!-- Tenant Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Firstname:</strong> {{ tenant.firstname }}</p>
                                <p><strong>Email:</strong> <a :href="`mailto:${tenant.email}`">{{ tenant.email }}</a>
                                </p>
                                <p><strong>Address:</strong> {{ tenant.address }}</p>
                                <p><strong>School:</strong> {{ tenant.school }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Lastname:</strong> {{ tenant.lastname }}</p>
                                <p><strong>Contact Number:</strong> {{ tenant.contactNumber }}</p>
                                <p><strong>Payment Type:</strong> {{ tenant.paymentType }}</p>
                                <p><strong>Course and Year:</strong> {{ tenant.courseYear }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" @click="approveTenant">Approve</button>
                        <button type="button" class="btn btn-outline-secondary" @click="notApproveTenant">Not
                            Approve</button>
                    </div>
                </div>
            </div>
        </div>

        <!--End Appoval Modal-->
        <!--DElete Modal-->
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
        <!--End Delete MOdal-->
    </div>
</template>
<script>
export default {
    data() {
        return {
            VisibleModalApproval: false,
            VisibleDeleteModal: false,
            tenants: [
                {
                    tenantId: 1,
                    name: "John Doe",
                    email: "john.doe@example.com",
                    dormName: "Dorm A",
                    roomNo: "101",
                    moveInDate: "2023-01-15",
                    paymentStatus: "Paid",
                    applicationStatus: "Approved",
                },
                {
                    tenantId: 2,
                    name: "Jane Smith",
                    email: "jane.smith@example.com",
                    dormName: "Dorm B",
                    roomNo: "202",
                    moveInDate: "2023-02-01",
                    paymentStatus: "Pending",
                    applicationStatus: "Pending",
                },
                {
                    tenantId: 3,
                    name: "Alice Johnson",
                    email: "alice.johnson@example.com",
                    dormName: "Dorm C",
                    roomNo: "303",
                    moveInDate: "2023-03-10",
                    paymentStatus: "Paid",
                    applicationStatus: "Approved",
                },
            ],
            tenant: {
                id: "1885598713",
                firstname: "Lance",
                lastname: "Monsanto",
                email: "nilnauer@gmail.com",
                address: "Yeti Lilisan Cebu City",
                paymentType: "Cash",
                contactNumber: "09232424628",
                school: "UCLM",
                courseYear: "BSIT '23",
            },
            searchQuery: "",
            filteredTenants: [],
        };
    },
    mounted() {
        this.filteredTenants = this.tenants; // Initialize filtered list with all tenants
    },
    methods: {
        filterTenants() {
            // Filter tenants based on the search query
            this.filteredTenants = this.tenants.filter((tenant) => {
                return (
                    tenant.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    tenant.email.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            });
        },
        approveTenant() {
            alert("Tenant approved!");
            // Add logic to handle approval (e.g., API call)
        },
        notApproveTenant() {
            alert("Tenant not approved!");
            // Add logic to handle rejection (e.g., API call)
        },
    },
};
</script>
<style scoped>
/* Optional custom styles */
.container {
    max-width: 800px;
}

.input-group {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.table {
    font-size: 0.9rem;
}

.table th {
    background-color: #f8f9fa;
}

.table td,
.table th {
    vertical-align: middle;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>