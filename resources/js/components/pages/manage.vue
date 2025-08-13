<style scoped>
.v-list-item {
  transition: background-color 0.2s ease;
}

.v-list-item:hover {
  background-color: rgba(0, 0, 0, 0.04);
  cursor: pointer;
}
</style>
<template>
    <v-row class="mx-auto justify-start">
        <v-col cols="12" md="4">
            <v-card class="pa-6" rounded="lg" elevation="0">
                <v-card-title class="d-flex justify-space-between align-center pa-0">
                    <span class="text-h6 font-weight-bold">Category</span>
                    <v-btn
                        color="primary"
                        variant="contained"
                        size="small"
                        @click="dialog = true"
                    >
                        <v-icon left small>mdi-plus</v-icon>
                        Add
                    </v-btn>
                </v-card-title>

                <v-dialog v-model="dialog" width="400">
                    <v-card
                        max-width="400"
                        prepend-icon="mdi-update"
                        title="Add new category"
                        rounded="lg"
                        elevation="0"
                    >
                        <v-form @submit.prevent="addCategory">
                            <v-card-text>
                                <v-text-field
                                v-model="name"
                                label="Category Name*"
                                variant="outlined"
                                class="mb-4 custom-input"
                                />
                            </v-card-text>

                            <v-divider></v-divider>

                            <v-card-actions>
                                <v-btn
                                text="Close"
                                variant="plain"
                                @click="dialog = false"
                                />

                                <v-btn
                                color="primary"
                                text="Save"
                                variant="tonal"
                                type="submit"
                                />
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-dialog>

                <v-card-text class="pa-0 mt-4">
                    <v-list>
                        <v-list-item
                            class="rounded-lg mb-2"
                            v-for="category in categories"
                            :key="category.id"
                            :active="selectedMenu === category.id"
                            @click="categoryEvent(category.id)"
                        >
                            <v-list-item-title>
                                {{ category.name }}
                            </v-list-item-title>
                            
                            <!-- Inline buttons on the right -->
                            <template v-slot:append>
                                <v-btn
                                    variant="text"
                                    icon
                                    @click.stop="edit(category)"
                                    >
                                    <v-icon color="green-darken-4">mdi-pencil-outline</v-icon>
                                </v-btn>
                                
                                <v-btn
                                    variant="text"
                                    icon
                                    @click.stop="remove(category.id)"
                                    >
                                    <v-icon color="red-darken-4">mdi-delete-outline</v-icon>
                                </v-btn>
                            </template>
                        </v-list-item>
                    </v-list>
                    <p v-if="!categories?.length" class="text-grey-darken-1">You dont have any category task..</p>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="8">
            <v-card
                class="pa-6"
                rounded="lg"
                elevation="0"
                v-for="category in categories"
                :key="category.id"
                v-show="selectedMenu === category.id"
            >
                <v-card-title>{{ category.name }}</v-card-title>
                <v-card-text>
                    <div v-for="task in tasks" :key="task.id">
                        <p>{{ task.name }}</p>
                    </div>
                </v-card-text>
            </v-card>

            <v-card
                class="pa-6"
                rounded="lg"
                elevation="0"
                v-if="!selectedMenu && categories?.length"
            >
                <v-card-title>Select a Category</v-card-title>
                <v-card-text>
                    <p class="text-grey-darken-1">Please select a category from the list to view its details.</p>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { dashboard } from '../../composables/dashboard';

const dialog = ref(false);
const selectedMenu =  ref(null);

const categoryEvent = async (categoryId) => {
    selectedMenu.value = categoryId;
    await fetchTasks(categoryId);
}

const addCategory = async () => {
    try {
        await addCategoryAction();
    } finally {
        dialog.value = false;
    }
}

const remove = async (categoryId) => {
    if (!confirm('Are you sure you want to delete this category?')) {
        return; 
    }

    await delCategory(categoryId);
}

const {
    alertMessage,
    user,
    name,
    categories,
    tasks,
    index,
    fetchTasks,
    addCategory: addCategoryAction,
    delCategory
} = dashboard();

onMounted(() => {
    index(); // ✅ fetch data on mount
});

</script>