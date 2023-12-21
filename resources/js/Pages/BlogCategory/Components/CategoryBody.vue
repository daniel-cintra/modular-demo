<template>
    <div>
        <AppLabel for="name">Name</AppLabel>
        <AppInputText
            id="name"
            v-model="categoryStore.category.name"
            type="text"
            :class="{
                'input-error': errorsFields.includes('name')
            }"
            autocomplete="off"
        />
    </div>

    <div class="mt-5">
        <AppLabel for="description">Description</AppLabel>
        <AppTipTapEditor
            v-model="categoryStore.category.description"
            editor-id="description"
            :class="{
                'app-tip-tap-error': errorsFields.includes('description')
            }"
            :file-upload-url="route('blogCategory.uploadEditorImage')"
        />
    </div>
</template>

<script setup>
import useFormErrors from '@/Composables/useFormErrors'
import { useCategoryStore } from '../CategoryStore'
const categoryStore = useCategoryStore()
const { errorsFields } = useFormErrors()
</script>
