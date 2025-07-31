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
            <h1 class="text-h4 font-weight-bold mb-3">Create Account</h1>
            <p class="text-body-2 text-medium-emphasis">
                Join us today and start managing<br>
                your tasks efficiently.
            </p>
        </div>

        <!-- Register Form -->
        <v-form @submit.prevent="registerUser">
            <v-text-field
                v-model="name"
                label="Username"
                variant="outlined"
                class="mb-4 custom-input"
                hide-details
            ></v-text-field>

            <v-text-field
                v-model="email"
                label="Email"
                type="email"
                variant="outlined"
                class="mb-4 custom-input"
                hide-details
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
                Register
            </v-btn>
        </v-form>
        
        <!-- Login Link -->
        <div class="text-center">
            <span class="text-body-2 text-medium-emphasis">
                Already have an account? 
                <router-link to="/" class="text-decoration-none register-link">
                    Login here
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
            name,
            email,
            password,
            password_confirmation,
            errors,
            alertMessage,
            registerUser
        } = auth();

        return {
            name,
            email,
            password,
            password_confirmation,
            errors,
            alertMessage,
            registerUser
        };
    }
}
</script>

<style scoped>
/* Same styles as login.vue */
.v-card {
    background-color: white;
    border-radius: 8px;
}

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

.login-btn {
    border-radius: 25px !important;
    text-transform: none;
    font-weight: 500;
    letter-spacing: 0;
}

.register-link {
    color: #1976d2 !important;
    font-weight: 500;
}

.register-link:hover {
    color: #1565c0 !important;
}

.text-h4 {
    color: #333;
}

.text-body-2 {
    line-height: 1.5;
}

@media (max-width: 600px) {
    .v-card {
        margin: 16px;
    }
}
</style>