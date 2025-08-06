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
            <h1 class="text-h4 font-weight-bold mb-3">Welcome !</h1>
            <p class="text-body-2 text-medium-emphasis">
                Boost your productivity<br>
                with Tasks-Management App. Get started for free.
            </p>
        </div>

        <!-- Login Form -->
        <v-form @submit.prevent="loginUser">
            <v-text-field
                v-model="email"
                label="Email"
                variant="outlined"
                class="mb-4 custom-input"
                hide-details
            ></v-text-field>

            <v-text-field
                v-model="password"
                label="Password"
                type="password"
                variant="outlined"
                class="mb-2 custom-input"
                hide-details
                :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append-inner="showPassword = !showPassword"
                :type="showPassword ? 'text' : 'password'"
            ></v-text-field>

            <div class="text-right mb-6">
                <router-link to="/forgotpassword" class="text-decoration-none text-body-2 forgot-link">
                    Forgot Password?
                </router-link>
            </div>

            <v-btn
                color="black"
                size="large"
                block
                class="mb-6 login-btn"
                elevation="0"
                type="submit" 
            >
                Login
            </v-btn>
        </v-form>
        <!-- Register Link -->
        <div class="text-center">
            <span class="text-body-2 text-medium-emphasis">
                Not a member? 
                <router-link to="/register" class="text-decoration-none register-link">
                    Register now
                </router-link>
            </span>
        </div>
    </v-card>
</template>
<script>
import { auth } from '../composables/auth';

export default {
    setup(){
        const {
            email,
            password,
            errors,
            alertMessage,
            loginUser
        } = auth();

        return {
            email,
            password,
            errors,
            alertMessage,
            loginUser
        };
    }
}
</script>