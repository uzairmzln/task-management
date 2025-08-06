<template>
  <v-navigation-drawer
    v-model="drawer"
    :rail="rail"
    permanent
    @click="rail = false"
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

    <v-divider></v-divider>

    <!-- Main nav items -->
    <v-list density="compact" nav>
      <v-list-item
        prepend-icon="mdi-home-city"
        title="Home"
        value="home"
      />
    </v-list>

    <!-- Bottom section with Settings and Logout -->
    <template v-slot:append>
      <div>
        <!-- Divider above settings -->
        <v-divider />
        
        <!-- Settings list item -->
        <v-list density="compact" nav>
          <v-list-item
            prepend-icon="mdi-cog-outline"
            title="Settings"
            value="settings"
          />
        </v-list>
        
        <!-- Logout button -->
         <v-list density="compact" nav>
            <v-list-item
                prepend-icon="mdi-logout"
                title="Logout"
                value="Logout"
                @click="logoutUser"
            />
        </v-list>
      </div>
    </template>
  </v-navigation-drawer>
</template>

<script setup>
import { ref, onMounted  } from 'vue';
import { auth } from '../composables/auth';
import { dashboard } from '../composables/dashboard';

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