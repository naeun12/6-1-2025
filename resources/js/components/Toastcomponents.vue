<template>
    <div :class="['container-toast mt-5', { show: toaster }]">
        <!-- Toast Container -->
        <div :class="['toast-child', `bg-${toastColor}`]">
            <div class="toast-body d-flex justify-content-between align-items-center text-white fw-bold py-3 px-4">
                <span class="text-wrap">{{ messageToaster }}</span>
                <button type="button" class="btn-close btn-close-white ms-3" @click="ExitToaster"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            toaster: false,
            toastColor: 'success', // Default color
            messageToaster: '',
        };
    },
    methods: {
        showToast(message, color = 'success') {
            this.messageToaster = message;
            this.toastColor = color;
            this.toaster = true;

            // Auto-hide after 3 seconds
            setTimeout(() => {
                this.ExitToaster();
            }, 3000);
        },
        ExitToaster() {
            this.toaster = false;
        }
    }
};
</script>
<style>
.container-toast {
    position: fixed;
    bottom: 1.5rem;
    /* near bottom */
    right: 1.5rem;
    /* align to right */
    transform: none;
    /* no horizontal centering */
    width: 95%;
    max-width: 30rem;
    z-index: 1000;
    opacity: 0;
    transition: all 0.5s ease;
}

@keyframes slideUpBounce {
    0% {
        bottom: -10rem;
        opacity: 0;
    }

    70% {
        bottom: 1.5rem;
    }

    100% {
        bottom: 1.5rem;
        opacity: 1;
    }
}

.container-toast.show {
    bottom: 1.5rem;
    opacity: 1;
    animation: slideUpBounce 0.6s ease forwards;
}
</style>