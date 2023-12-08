<template>
    <AppSectionHeader title="Blogs" :bread-crumb="breadCrumb">
    </AppSectionHeader>

    <div class="flex">
        <AppCard class="w-full md:w-3/4 xl:w-1/2">
            <template #title> {{ title }} </template>
            <template #content>
                <AppFormErrors class="mb-4" />
                <form class="pt-4">
                    <PostBody />

                    <PostImage />

                    <PostSeo />
                </form>
            </template>
            <template #footer>
                <AppButton class="btn btn-primary" @click="submitForm">
                    Save
                </AppButton>
            </template>
        </AppCard>

        <AppCard class="ml-5 md:w-1/4">
            <template #title> Post Info </template>
            <template #content>
                <PostPublishDate />

                <PostCategories :categories="categories" />
            </template>
        </AppCard>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

import { onUnmounted } from 'vue'

import useTitle from '@/Composables/useTitle'
import useFormContext from '@/Composables/useFormContext'
import PostBody from './Components/PostBody.vue'
import PostImage from './Components/PostImage.vue'
import PostSeo from './Components/PostSeo.vue'
import PostPublishDate from './Components/PostPublishDate.vue'
import PostCategories from './Components/PostCategories.vue'
import { usePostStore } from './PostStore'
const postStore = usePostStore()

const props = defineProps({
    post: {
        type: Object,
        default: null
    },

    categories: {
        type: Object,
        default: () => {}
    }
})

if (props.post) {
    postStore.setPost(props.post)
}

onUnmounted(() => {
    postStore.$reset()
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Posts', href: route('blogPost.index') },
    { label: 'Post', last: true }
]

const { title } = useTitle('Blog Post')
const { isCreate } = useFormContext()

const submitForm = () => {
    const form = useForm(postStore.post)

    if (isCreate.value) {
        form.transform((data) => ({
            ...data,
            blog_category_id: data.blog_category_id
                ? data.blog_category_id.value
                : null
        })).post(route('blogPost.store'))
    } else {
        form.transform((data) => ({
            ...data,
            blog_category_id: data.blog_category_id
                ? data.blog_category_id.value
                : null,
            _method: 'PUT'
        })).post(route('blogPost.update', props.post.id))
    }
}
</script>
