import 'bootstrap'; // Importing Bootstrap
import { createApp } from 'vue'; // Vue 3
import TenantRegister from './components/tenants/tenantRegister.vue';

const app = createApp(TenantRegister);
app.mount('#TenantRegisterContainer');
