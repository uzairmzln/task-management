import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export function dashboard() {

    const alertMessage = ref('');
    const name = ref('');
    const user = ref(null);
    const categories = ref([]);
    const tasks = ref([]); 
    const token = localStorage.getItem('auth_token');

    const index = async () => {

        try{

            const response = await axios.get('/user', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            
            user.value = response.data.user;
            categories.value = response.data.categories;

            localStorage.setItem('user_auth', JSON.stringify(response.data.user));

            alertMessage.value = response.data.message;
        } catch (error) {

            if (error.response && error.response.status === 401) {
                alertMessage.value = error.response.data.message;
            } else {
                alertMessage.value = 'Something went wrong. Please try again.';
            }
        }
        
    }

    const fetchTasks =  async (categoryId) => {

        try{

            const response = await axios.get(`/tasks/${categoryId}`, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            
            tasks.value = response.data.tasks;
        } catch (error) {

            if (error.response && error.response.status === 401) {
                alertMessage.value = error.response.data.message;
            } else {
                alertMessage.value = 'Something went wrong. Please try again.';
            }
        }
    }
    
    const addCategory = async () => {
        
        try {
            
            const response = await axios.post('/category/add', {
                name: name.value
            },
            {
                headers: {
                    Authorization: `Bearer ${token}`
                },
            });
    
            categories.value.push(response.data.category);
            alertMessage.value = response.data.message;
        } catch (error) {

            if (error.response && error.response.status === 401) {
                alertMessage.value = error.response.data.message;
            } else {
                alertMessage.value = 'Something went wrong. Please try again.';
            }
        }
    }

    const delCategory = async (categoryId) => {

        try {
            
            const response = await axios.delete(`/category/delete/${categoryId}`, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
    
            categories.value = categories.value.filter(c => c.id !== categoryId);
            alertMessage.value = response.data.message;
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
        user,
        name,
        categories,
        tasks,
        index,
        fetchTasks,
        addCategory,
        delCategory
    }
}