import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export function dashboard() {

    const alertMessage = ref('');

    const index = async () => {

        try{

            const response = await axios.get('/user');
    
            localStorage.setItem('user_auth', JSON.stringify(response.data.user));
        } catch (error) {

            if (error.response && error.response.status === 401) {
                alertMessage.value = error.response.data.message;
            } else {
                alertMessage.value = 'Something went wrong. Please try again.';
            }
        }
        
    }

    return {
        alertMessage,
        index
    }
}