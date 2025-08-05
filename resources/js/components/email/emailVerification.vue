<template>
    <v-alert
            v-if="error"
            type="error"
            variant="tonal"
            class="mb-4"
            density="comfortable"
        >
            {{ error }}
    </v-alert>
    <v-card>
        <v-card-item>
            <v-card-title>
                Verify Your Email
            </v-card-title>
            <v-card-text>
                Account verification is required to access your dashboard. Please check your email for the verification link.

                <a href="#" @click.prevent="resendEmailVerification" class="text-blue-600">Didn't get the email? Send it again</a>
            </v-card-text>
        </v-card-item>
    </v-card>
</template>
<script>
import { emailVerification } from '../../composables/emailVerfifcation';

export default {
    setup() {
        const { 
            message,
            error,
            resendEmailVerification 
        } = emailVerification();

        return {
            message,
            error,
            resendEmailVerification
        };
    }
};
</script>