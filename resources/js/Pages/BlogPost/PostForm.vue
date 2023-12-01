<template>
    <AppSectionHeader title="Blogs" :bread-crumb="breadCrumb">
    </AppSectionHeader>

    <AppCard class="w-full md:w-3/4 xl:w-1/2">
        <template #title> {{ title }} </template>
        <template #content>
            <AppFormErrors class="mb-4" />
            <form class="pt-4">
                <div>
                    <AppLabel for="title">Title</AppLabel>
                    <AppInputText
                        id="title"
                        type="text"
                        :class="{
                            'input-error': errorsFields.includes('title')
                        }"
                        :value="postStore.post.title"
                        @input="postStore.update('title', $event.target.value)"
                    />
                </div>

                <!-- <div class="mt-5">
                    <AppLabel for="notes">Content</AppLabel>
                    <AppTipTapEditor
                        v-model="form.content"
                        :class="{
                            'app-tip-tap-error':
                                errorsFields.includes('content')
                        }"
                        :file-upload-url="route('blogPost.uploadEditorImage')"
                    />
                </div>

                <div class="mt-5">
                    <AppInputFile
                        v-model="form.image"
                        :image-preview-url="getImagePreviewURL()"
                        @remove-file="form.remove_previous_image = true"
                    ></AppInputFile>
                </div> -->

                <!-- <div class="mt-8">
                    <h4 class="mb-4 text-xl">
                        SEO - Preview of how it will be listed on Google
                    </h4>

                    <div class="mb-2 flex">
                        <div
                            class="mr-4 flex h-10 w-10 rounded-full bg-gradient-to-bl from-skin-neutral-3 to-skin-neutral-6"
                        ></div>

                        <div>
                            <p class="text-sm">Your Site Name</p>
                            <p class="-mt-1 mb-1 text-sm text-skin-neutral-10">
                                https://your-domain.com/blog/{{ form.slug }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-2xl text-[#1a0dab]">
                            {{ form.meta_tag_title }}
                        </p>

                        <p class="">
                            {{ form.meta_tag_description }}
                        </p>
                    </div>

                    <div class="mt-5">
                        <AppLabel for="meta_tag_title">Meta Tag Title</AppLabel>
                        <AppInputText
                            id="meta_tag_title"
                            v-model="form.meta_tag_title"
                            type="text"
                            :class="{
                                'input-error':
                                    errorsFields.includes('meta_tag_title')
                            }"
                        />
                    </div>

                    <div class="mt-5">
                        <AppLabel for="meta_tag_description"
                            >Meta Tag Description</AppLabel
                        >
                        <AppTextArea
                            id="meta_tag_description"
                            v-model="form.meta_tag_description"
                            class="h-24"
                            :class="{
                                'input-error': errorsFields.includes(
                                    'meta_tag_description'
                                )
                            }"
                        />
                    </div>
                </div> -->
            </form>
        </template>
        <template #footer>
            <AppButton class="btn btn-primary" @click="submitForm">
                {{ __('Save') }}
            </AppButton>
        </template>
    </AppCard>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

import { onMounted } from 'vue'

import useTitle from '@/Composables/useTitle'
import useFormContext from '@/Composables/useFormContext'
import useFormErrors from '@/Composables/useFormErrors'
// import PostSeo from './Components/PostSeo.vue'
import { usePostStore } from './PostStore'
const postStore = usePostStore()

const props = defineProps({
    post: {
        type: Object,
        default: null
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Posts', href: route('blogPost.index') },
    { label: 'Post', last: true }
]

const { title } = useTitle('Blog Post')
const { isCreate } = useFormContext()

if (props.post) {
    postStore.setPost(props.post)
}

const getImagePreviewURL = () => {
    if (!isCreate.value && props.post.image_url) {
        return props.post.image_url
    }

    return null
}

const submitForm = () => {
    const form = useForm(postStore.post)

    if (isCreate.value) {
        form.post(route('blogPost.store'))
    } else {
        form.transform((data) => ({
            ...data,
            _method: 'PUT'
        })).post(route('blogPost.update', props.post.id))
    }
}

const { errorsFields } = useFormErrors()
</script>
