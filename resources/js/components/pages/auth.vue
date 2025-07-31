<style scoped>
.container {
    min-height: 100vh;
}

.highlight-col {
    background-color: #333;
}
</style>
<template>
    <v-container class="fill-height pa-0" fluid>
        <v-row class="fill-height">
            <v-col cols="12" md="6" class="d-flex justify-center align-center">
                <router-view />
            </v-col>
            <v-col cols="12" md="6" class="highlight-col d-flex align-center justify-center">
                
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>

</script>
