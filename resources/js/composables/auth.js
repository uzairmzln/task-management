import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export function auth(){

    const name = ref('');
    const email = ref('');
    const password = ref('');
    const password_confirmation = ref('');
    const errors = ref(null);
    const alertMessage = ref('');
    const router = useRouter();

    const loginUser = async () => {
        try {

            const response = await axios.post('/login', {
                email: email.value,
                password: password.value,
            });
    
            localStorage.setItem('auth_token', response.data.token);
    
            axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
    
            router.push('/dashboard')
        } catch (error) {

            if (error.response && error.response.status === 401) {
                alertMessage.value = error.response.data.message;
            } else {
                alertMessage.value = 'Something went wrong. Please try again.';
            }
        }
        
    }

    const registerUser = async () => {
        try{

            const response = await axios.post('/register', {
                name: name.value,
                email: email.value,
                password: password.value,
                password_confirmation: password_confirmation.value,
            })
    
            localStorage.setItem('auth_token', response.data.token);
    
            axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
    
            router.push('/email-verfication')
        } catch (error) {
            
            if (error.response && error.response.status === 422) {
                
                const errs = error.response.data.errors;

                if (errs.name) alertMessage.value = errs.name[0];
                else if (errs.email) alertMessage.value = errs.email[0];
                else if (errs.password) alertMessage.value = errs.password[0];
                else alertMessage.value = 'Please check your input.';

                errors.value = errs;
            } else {
                alertMessage.value = 'Something went wrong. Please try again.';
            }
        }
    }
    
    const logoutUser = async () => {
        try {
            const response = await axios.post('/logout');
        } catch (error) {

            if (error.response?.status === 500) {
                console.warn('Token expired or invalid, clearing anyway.');
            } else {
                console.error('Logout error:', error);
            }
        } finally {
            localStorage.removeItem('auth_token');
            delete axios.defaults.headers.common['Authorization'];
            router.push('/');
        }
    }

    return {
        name,
        email,
        password,
        password_confirmation,
        errors,
        alertMessage,
        loginUser,
        registerUser,
        logoutUser,
    }
}