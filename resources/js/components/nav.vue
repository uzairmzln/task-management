<template>
    <v-navigation-drawer
        v-model="drawer"
        :rail="rail"
        permanent
        @click="rail = false"
    >
        <v-list>
            <v-list-item
                prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
                title="John Leider"
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

        <v-divider></v-divider>

        <v-list density="compact" nav>
            <v-list-item
                prepend-icon="mdi-home-city"
                title="Home"
                value="home"
            ></v-list-item>
            <v-list-item
                prepend-icon="mdi-account"
                title="My Account"
                value="account"
            ></v-list-item>
            <v-list-item
                prepend-icon="mdi-account-group-outline"
                title="Users"
                value="users"
            ></v-list-item>
        </v-list>
        
        <template v-slot:append>
            <div>
                <v-btn block prepend-icon="mdi-logout" @click="logoutUser">
                    <span v-if="!rail">Logout</span>
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>
</template>
<script setup>
import { ref } from 'vue';
import { auth } from '../composables/auth';

const drawer = ref(true);
const rail = ref(true);
const logoutUser = auth().logoutUser;

</script>