<template>
    <v-card class="elevation-0" max-width="400" width="100%">
        <v-alert
            v-if="alertMessage"
            type="error"
            variant="tonal"
            class="mb-4"
            density="comfortable"
        >
            {{ alertMessage }}
        </v-alert>
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-h4 font-weight-bold mb-3">Forgot Your Password?</h1>
            <p class="text-body-2 text-medium-emphasis">
                Please submit your email<br>
                and check your email after Submission.
            </p>
        </div>
        <ForgotPasswordForm />
    </v-card>
</template>
<script setup>
import ForgotPasswordForm from './auth/forgotPasswordForm.vue';
</script>