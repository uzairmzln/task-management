<style scoped>
.main {
    background-color: #eeeeee;
}
</style>
<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer"
            :rail="rail"
            permanent
            @click="rail = false"
            elevation="0"
        >
            <v-list>
                <v-list-item
                    :prepend-avatar="user?.avatar || 'https://ui-avatars.com/api/?name=' + (user?.name || 'User')"
                    :title="user?.name || 'Loading...'"
                >
                    <template v-slot:append>
                        <v-btn
                            icon="mdi-chevron-left"
                            variant="text"
                            @click.stop="rail = !rail"
                        >
                        </v-btn>
                    </template>
                </v-list-item>
            </v-list>


            <!-- Main nav items -->
            <v-list density="compact" nav>
                <v-list-item
                    prepend-icon="mdi mdi-view-dashboard-outline"
                    title="Home"
                    value="home"
                    to="/dashboard"
                    router
                    exact
                />

                <v-list-item
                    prepend-icon="mdi mdi-file-tree-outline"
                    title="Manages"
                    value="manage"
                    to="/dashboard/manages"
                    router
                    exact
                />
            </v-list>

            <!-- Bottom section with Settings and Logout -->
            <template v-slot:append>
                <div>
                    
                    <!-- Settings list item -->
                    <v-list density="compact" nav>
                    <v-list-item
                        prepend-icon="mdi-cog-outline"
                        title="Settings"
                        value="settings"
                        to="/dashboard/settings"
                        router
                        exact
                    />
                    </v-list>
                    
                    <!-- Logout button -->
                    <v-list density="compact" nav>
                        <v-list-item
                            prepend-icon="mdi mdi-location-exit"
                            title="Logout"
                            value="Logout"
                            @click="logoutUser"
                        />
                    </v-list>
                </div>
            </template>
        </v-navigation-drawer>

        <v-main class="main">
            <v-container>
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import { ref, onMounted  } from 'vue';
import { auth } from '../../composables/auth';
import { dashboard } from '../../composables/dashboard';

const drawer = ref(true);
const rail = ref(true);
const logoutUser = auth().logoutUser;

const user = ref({});
const {index} = dashboard();

onMounted(async ()=> {
    
    await index();

    const storedUser = localStorage.getItem('user_auth');
    if (storedUser) {
        user.value = JSON.parse(storedUser);
    }
});
</script>