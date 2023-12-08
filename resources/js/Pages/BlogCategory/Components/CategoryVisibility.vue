<template>
    <div class="mt-5 flex items-center">
        <AppCheckbox
            id="term"
            v-model="categoryStore.category.is_visible"
            name="term"
            :value="true"
        />
        <AppLabel for="term" class="ml-3"> Turn Category visible </AppLabel>
    </div>
</template>

<script setup>
import { useCategoryStore } from '../CategoryStore'
const categoryStore = useCategoryStore()
</script>
