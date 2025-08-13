import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios'

export function emailVerification() {

    const message = ref('');
    const error = ref('');

    const resendEmailVerification = async () => {
        try {
            
            const token = localStorage.getItem('auth_token');
            const response = await axios.post('/email/resend', {}, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            
            message.value = response.data.message;
            
            alert(message.value);
        } catch (err) {

            if (err.response && err.response.status === 400) {
                message.value = err.response.data.message;
            } else {
                message.value = 'Something went wrong. Please try again.';
            }
        }
    }

    return {
        message,
        error,
        resendEmailVerification
    }
}