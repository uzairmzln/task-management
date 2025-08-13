<style scoped>
.status-indicator {
  position: absolute;
  bottom: 8px;
  right: 8px;
  width: 16px;
  height: 16px;
  background-color: #ff9800;
  border: 2px solid white;
  border-radius: 50%;
}

.v-list-item {
  transition: background-color 0.2s ease;
}

.v-list-item:hover {
  background-color: rgba(0, 0, 0, 0.04);
  cursor: pointer;
}
.submit-btn {
    border-radius: 25px !important;
    text-transform: none;
    font-weight: 500;
    letter-spacing: 0;
}
</style>
<template>
    <v-row class="mx-auto" md="justify-start" sm="justify-center">
        <v-col cols="12" md="6">
            <v-card class="pa-6" rounded="lg" elevation="0">
                <!-- Profile Section -->
                <div class="text-center mb-6">
                    <v-avatar size="80" class="mb-4">
                        <v-img
                        :src="user?.avatar || 'https://ui-avatars.com/api/?name=' + (user?.name || 'User')"
                        alt="Profile Picture"
                        />
                        <!-- Status indicator -->
                        <div class="status-indicator"></div>
                    </v-avatar>
                
                    <h2 class="text-h6 font-weight-bold mb-1">{{ user?.name }}</h2>
                    <p class="text-body-2 text-medium-emphasis">Programmer</p>
                </div>

                <!-- Menu Items -->
                <v-list class="pa-0" density="compact">
                    <v-list-item
                        prepend-icon="mdi-account"
                        title="Personal Information"
                        class="rounded-lg mb-2"
                        :active="selectedMenu === 'info'"
                        @click="handlePersonalInfo"
                    >
                        <template v-slot:prepend>
                            <v-icon size="20"></v-icon>
                        </template>
                    </v-list-item>

                    <v-list-item
                        prepend-icon="mdi-lock"
                        title="Login & Password"
                        class="rounded-lg mb-2"
                        :active="selectedMenu === 'login'"
                        @click="handleLoginPassword"
                    >
                        <template v-slot:prepend>
                            <v-icon size="20"></v-icon>
                        </template>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-col>

        <v-col cols="12" md="6">
            <v-card class="pa-6" rounded="lg" elevation="0">
                <div v-if="selectedMenu === 'info'">

                </div>

                <div v-else-if="selectedMenu === 'login'">
                    <div>
                        <h1 class="mb-5 font-bold"><span class="mdi mdi-key-variant me-2"></span>Forgot Password</h1>
                        <p class="mb-5 text-body-2 text-medium-emphasis">
                            Please check your email after submission.
                        </p>
                        <ForgotPasswordForm :preFilledEmail="user.email"/>
                    </div>

                    <v-divider></v-divider>
                    <div>
                        <h1 class="mt-5 mb-5 font-bold"><span class="mdi mdi-email-check me-2"></span>Email Verification</h1>
                        <p class="mb-5 text-body-2 text-medium-emphasis">
                            Please check your email after submission.
                        </p>
                        <v-alert
                            v-if="message"
                            :type="message === 'Email already verified' ? 'success' : 'error'"
                            variant="tonal"
                            class="mb-4"
                            closable
                        >
                            {{ message }}
                        </v-alert>

                        <v-btn
                            color="black"
                            size="large"
                            block
                            class="mb-6 submit-btn"
                            elevation="0"
                            :loading="loading"
                            :disabled="loading || !!user?.email_verified_at"
                            @click.prevent="resendEmailVerification"
                        >
                            {{user?.email_verified_at ? 'Already Verified' : 'submit'}}
                        </v-btn>
                    </div>
                </div>
            </v-card>
        </v-col>
    </v-row>
</template>
<script setup>
import { ref,onMounted } from 'vue';
import { dashboard } from '../../composables/dashboard';
import { emailVerification } from '../../composables/emailVerfifcation';
import ForgotPasswordForm from '../auth/forgotPasswordForm.vue';

const selectedMenu = ref('info');
const handlePersonalInfo = () => {
    selectedMenu.value = 'info';
};

const handleLoginPassword = () => {
    selectedMenu.value = 'login';
};


const {
    message,
    error,
    resendEmailVerification: resendEmailAction
} = emailVerification();

const loading = ref(false);
const resendEmailVerification = async () => {
    if(loading.value) return;
    loading.value = true;
    try {
        await resendEmailAction();
    } finally {
        loading.value = false;
    }
}

const {index,user} = dashboard();
onMounted(async()=> {
    
    await index();

    const storedUser = localStorage.getItem('user_auth');
    if (storedUser) {
        user.value = JSON.parse(storedUser);
    }
}) 

</script>