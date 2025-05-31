import 'bootstrap'; // Importing Bootstrap
import { createApp } from 'vue'; // Vue 3
import TenantRegister from './components/tenants/tenantRegister.vue';
import LandlordRegister from './components/landlord/landlordregister.vue';
import LandlordLogin from './components/landlord/landlordlogin.vue';
import landlorddormManagement from './components/landlord/auth/dormManagement.vue';
import landlordroomManagement from './components/landlord/auth/roomManagement.vue';
import tenantAuth from './components/landlord/auth/tenant.vue';
import tenantScreening from './components/landlord/auth/tenantScreening.vue';
import BookingManagement from './components/landlord/auth/bookingManagement.vue';
import Analytics from './components/landlord/auth/analytics.vue';
import MessagingCenter from './components/landlord/auth/messagingCenter.vue';
import ReviewandFeedback from './components/landlord/auth/ReviewandFeedback.vue';
import Notification from './components/landlord/auth/Notification.vue';

import AOS from 'aos';
import 'aos/dist/aos.css'
AOS.init();



const tenantContainer = document.querySelector('#TenantRegisterContainer');
if (tenantContainer) {
    createApp(TenantRegister).mount('#TenantRegisterContainer');
}
const landlordContainer = document.querySelector('#LandlordRegisterContainer');
if (landlordContainer) {
    createApp(LandlordRegister).mount('#LandlordRegisterContainer');
}
const landlordContainerLogin = document.querySelector('#landlordContainerLogin');
if (landlordContainerLogin) {
    createApp(LandlordLogin).mount('#landlordContainerLogin');
}
const landlorddormManagementContainer = document.querySelector('#landlorddormManagement');
if (landlorddormManagementContainer) {
    createApp(landlorddormManagement).mount('#landlorddormManagement');

}
const landlordroomManagementContainer = document.querySelector('#landlordroomManagement');
if (landlordroomManagementContainer) {
    createApp(landlordroomManagement).mount('#landlordroomManagement');

}
const tenantAuthContainer = document.querySelector('#tenant');
if (tenantAuthContainer) {
    createApp(tenantAuth).mount('#tenant');

}
const tenantScreeningContainer = document.querySelector('#tenantScreening');
if (tenantScreeningContainer) {
    createApp(tenantScreening).mount('#tenantScreening');

}
const BookingManagementController = document.querySelector('#BookingManagement');
if (BookingManagementController) {
    createApp(BookingManagement).mount('#BookingManagement');

}
const AnalyticsController = document.querySelector('#Analytics');
if (AnalyticsController) {
    createApp(Analytics).mount('#Analytics');

}
const MessagingCenterController = document.querySelector('#MessagingCenter');
if (MessagingCenterController) {
    createApp(MessagingCenter).mount('#MessagingCenter');
}
const ReviewandFeedbackController = document.querySelector('#ReviewandFeedback');
if (ReviewandFeedbackController) {
    createApp(ReviewandFeedback).mount('#ReviewandFeedback');

}
const NotificationController = document.querySelector('#Notification');
if (NotificationController) {
    createApp(Notification).mount('#Notification');

}



