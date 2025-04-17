@include('landingpage.partials.navigation')
<main>
    <!-- Home Section -->
    <section id="home" class="py-5">
        <div class="container-fluid py-3 mt-3 px-5">
            <div class="row align-items-center">
                <div class="col-md-6 p-5 px-3">
                    <h1>Welcome to DormHub Cebu</h1>
                    <p class="lead">Your Ultimate Solution for Boarding House Management in Cebu</p>
                    <p>Dorm Hub Cebu simplifies finding the perfect dormitory or boarding house in Cebu, connecting
                        students, professionals, and travelers with top-notch accommodations, simplifying the process
                        for landlords and tenants.</p>
                    <div class="mt-4">
                        <p>Sign up with</p>
                        <div class="d-flex justify-content-start">
                            <a href="" class="btn btn-primary rounded-pill me-3">Landlord</a>
                            <a href="{{ route('login-tenant') }}" class="btn btn-primary rounded-pill">Tenant</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end py-5 px-3">
                    <img src="{{ asset('images/landingpage/homewallapepr.png') }}" alt="Person sitting on a bunk bed"
                        class="img-fluid" />
                </div>
            </div>
        </div>

        <!-- Dorm Listings -->
        <div class="container-lg  section mt-1">
            <div class="text-container d-flex justify-content-center align-content-center">
                <h3 class="text-center fs-4 py-4">Browse DormHub Cebu</h3>
            </div>
            <div class="container-md py-3">
                <div class="row g-0">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="col-lg-3 p-2">
                            <div class="dorm-card card h-100">
                                <div class="dorm-image">
                                    <img src="{{ asset('images/landingpage/homewallapepr.png') }}" class="card-img-top"
                                        alt="...">
                                </div>
                                <div class="card-header card-header-style py-3">
                                    <h3>Available Dorm</h3>
                                </div>
                                <div class="card-body card-body-style">
                                    <p class="location">Mandaue loc city</p>
                                    <p class="description">
                                        Affordable dorms in Cebu City, near schools and workspaces. Starting at
                                        ₱3000/month.
                                    </p>
                                    <div class="features py-3">
                                        <button class="feature-btn">Wi-Fi</button>
                                        <button class="feature-btn">Near School</button>
                                        <button class="feature-btn">AC</button>
                                        <button class="feature-btn">Free Parking</button>
                                    </div>
                                    <button class="view-details-btn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">View Details</button>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-modal-check d-flex justify-content-center align-content-center">
                            <img class="w-25" src="{{ asset('images/landingpage/green-check-mark-png.webp') }}"
                                alt="Checkmark" />
                        </div>
                        <p>To access the details, please log in to your account or sign up if you're new here. It only
                            takes a moment.</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-content-center">
                        <a href=" " class="btn btn-primary">Sign-up</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-us py-5 section" id="about-us">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col-md-6 py-3 px-3">
                    <div class="Page-Title py-5">
                        <h3 class="fs-1">About Us</h3>
                    </div>
                    <div class="first-content">
                        <p style="font-size:16px;">
                            Welcome to Dorm Hub Cebu, the premier platform designed specifically for students searching
                            for dormitory and boarding house accommodations in Mandaue and Lapu-Lapu City. As students
                            ourselves, we understand how crucial it is to find safe, affordable, and conveniently
                            located housing near your school. That's why we've created a platform that simplifies the
                            search for the perfect living space.
                        </p>
                        <p style="font-size:13px">
                            Our mission is to connect students with a wide range of dormitories and boarding houses that
                            meet their needs and preferences. Whether you're looking for a place close to your campus,
                            or one with specific amenities, Dorm Hub Cebu provides comprehensive listings complete with
                            detailed information on pricing, facilities, and proximity to local schools.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 py-3 px-3 d-flex justify-content-end">
                    <img src="{{ asset('images/landingpage/aboutmap.png') }}" class="w-100 img-fluid"
                        alt="Map of Cebu showing dormitory locations" />
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact py-5 section" id="contact-us">
        <div class="container w-100 py-3">
            <div class="contact-title text-center">
                <h3 class="fs-2 fw-bold mb-4">Contact Us</h3>
                <div class="d-flex flex-column align-items-center">
                    <p class="mb-2"><strong>Email:</strong> support@dormhubcebu.com</p>
                    <p class="mb-2"><strong>Phone:</strong> +63 912 345 6789</p>
                    <p><strong>Operating Hours:</strong> Monday to Friday, 9:00 AM – 5:00 PM</p>
                </div>
            </div>

            <div class="col-12 mb-3">
                <input type="text" name="name" placeholder="Name" class="form-control rounded-1" aria-label="Name"
                    required />
            </div>
            <div class="col-12  mb-3">
                <input type="email" name="email" placeholder="Email Address" class="form-control rounded-1"
                    aria-label="Email Address" required />
            </div>
            <div class="col-12  mb-3">
                <textarea name="message" placeholder="Message" class="form-control rounded-1" rows="4" aria-label="Message"
                    required></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="faq-section py-5 section" id="faqs">
        <div class="container">
            <h2 class="text-start mb-5">Frequently Asked Questions</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordionLeft">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    What is Dorm Hub Cebu?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    Dorm Hub Cebu is a platform designed to help students find safe, affordable, and
                                    conveniently located dormitory and boarding house accommodations in Mandaue and
                                    Lapu-Lapu City.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    How do I search for a dormitory?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    You can search for dormitories by using the search bar on our homepage or by
                                    filtering options based on location, price, and amenities.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    How do I contact a dormitory owner?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    Each dormitory listing includes contact information for the owner. You can click on
                                    the contact details to get in touch.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    Is Dorm Hub Cebu free to use?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    Yes, Dorm Hub Cebu is completely free to use for both students and dormitory owners.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    Can I book a dormitory through Dorm Hub Cebu?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    Dorm Hub Cebu provides listings and contact information for dormitories. You can
                                    reach out to the owner directly to book a room.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordionRight">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading6">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    How can I report an issue with a dormitory listing?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                                data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    If you notice any issues with a dormitory listing, please email us at
                                    support@dormhubcebu.com or use the contact form on our website.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading7">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    Is Dorm Hub Cebu limited to specific areas?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    Currently, Dorm Hub Cebu focuses on dormitories in Mandaue and Lapu-Lapu City, but
                                    we plan to expand to other areas in the future.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading8">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                    <span class="me-2"><i class="bi bi-plus-circle"></i></span>
                                    What if I need more help or have further questions?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    For additional assistance, visit our Help Center or contact us via email at
                                    support@dormhubcebu.com.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="footer bg-primary text-white py-4">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5>Useful Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#about-us" class="text-white text-decoration-none">About Us</a></li>
                    <li><a href="#contact-us" class="text-white text-decoration-none">Contact Us</a></li>
                    <li><a href="#faqs" class="text-white text-decoration-none">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4 text-center">
                <h5>Social Media Links</h5>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="#" target="_blank" class="text-white">
                        <i class="fab fa-facebook fs-3"></i>
                    </a>

                    <a href="#" target="_blank" class="text-white">
                        <i class="fab fa-instagram fs-3"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-white">
                <h5>Address</h5>
                <p class="mb-2 text-white">
                    Address: Dorm Hub Cebu, Mandaue City, Cebu, Philippines
                </p>
                <p class="text-white">Email: support@dormhubcebu.com</p>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            © 2025 Dorm Hub Cebu. All rights reserved.
        </div>
    </div>
</footer>
@include('landingpage.partials.footer')
