<style scoped>
.container {
    min-height: 100vh;
}

.highlight-col {
    background-color: #333;
}

.v-card {
    background-color: white;
    border-radius: 8px;
}

/* Custom input styling */
:deep(.custom-input .v-field) {
    border-radius: 25px;
    background-color: #f5f5f5;
}

:deep(.custom-input .v-field--focused) {
     background-color: white;
}

:deep(.custom-input .v-field__outline) {
    --v-field-border-opacity: 0;
}

:deep(.custom-input .v-field--focused .v-field__outline) {
     --v-field-border-opacity: 0.3;
}

/* Login button styling */
.login-btn {
    border-radius: 25px !important;
    text-transform: none;
    font-weight: 500;
    letter-spacing: 0;
}

/* Social buttons */
.social-btn {
    background-color: black !important;
    color: white !important;
    border-radius: 50% !important;
    width: 48px;
    height: 48px;
}

/* Link styling */
.forgot-link {
    color: #666 !important;
    font-size: 0.875rem;
}

.forgot-link:hover {
    color: #333 !important;
}

.register-link {
    color: #1976d2 !important;
    font-weight: 500;
}

.register-link:hover {
    color: #1565c0 !important;
}

/* Typography adjustments */
.text-h4 {
    color: #333;
}

.text-body-2 {
    line-height: 1.5;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .v-card {
        margin: 16px;
    }
}
</style>
<template>
    <v-form @submit.prevent="resetPassword" class="w-50">
        <v-alert
            v-if="alertMessage"
            :type="status === 'passwords.reset' ? 'error' : 'success'"
            variant="tonal"
            class="mb-4"
            closable
            >
            {{ alertMessage }},
        </v-alert>
        <v-text-field
            v-model="email"
            label="Email"
            variant="outlined"
            class="mb-4 custom-input"
            hide-details
            readonly 
        ></v-text-field>

        <v-text-field
            v-model="password"
            label="Password"
            variant="outlined"
            class="mb-4 custom-input"
            hide-details
            :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append-inner="showPassword = !showPassword"
            :type="showPassword ? 'text' : 'password'"
        ></v-text-field>

        <v-text-field
            v-model="password_confirmation"
            label="Confirm Password"
            variant="outlined"
            class="mb-6 custom-input"
            hide-details
            :append-inner-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append-inner="showConfirmPassword = !showConfirmPassword"
            :type="showConfirmPassword ? 'text' : 'password'"
        ></v-text-field>

        <v-btn
            color="black"
            size="large"
            block
            class="mb-6 login-btn"
            elevation="0"
            type="submit" 
        >
            submit
        </v-btn>
        <div class="text-center">
            <span class="text-body-2 text-medium-emphasis">
                Back to
                <router-link to="/" class="text-decoration-none register-link mdi mdi-arrow-left">
                    Login Page
                </router-link>
            </span>
        </div>
    </v-form>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { auth } from '../../composables/auth';

const route = useRoute();
const token = ref('');
const email = ref('');

onMounted(() => {
    token.value = route.query.token || ''
    email.value = route.query.email || ''
});

const {
    alertMessage,
    password,
    password_confirmation,
    resetPassword: originalResetPassword
    } = auth();

const resetPassword = () => {
  if (!token.value) {
    alert('Token is missing')
    return
  }

  originalResetPassword({
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
    token: token.value
  });
}

</script>