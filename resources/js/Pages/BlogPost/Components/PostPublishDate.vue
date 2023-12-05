<template>
    <div class="mt-4">
        <AppInputDate
            v-model="postStore.post.published_at"
            label="Publish Date"
            name="publish_date"
        ></AppInputDate>
    </div>
</template>

<script setup>
// import useFormErrors from '@/Composables/useFormErrors'
import { usePostStore } from '../PostStore'
const postStore = usePostStore()
// const { errorsFields } = useFormErrors()
</script>
