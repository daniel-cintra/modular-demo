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
                        v-model="form.title"
                        type="text"
                        :class="{
                            'input-error': errorsFields.includes('title')
                        }"
                    />
                </div>

                <div class="mt-5">
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
                        :image-preview-url="post.image_url"
                        @remove-file="form.remove_previous_image = true"
                    ></AppInputFile>
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

const form = useForm({
    title: props.post ? props.post.title : '',
    content: props.post ? props.post.content : '',
    image: props.post ? props.post.image : null,

    meta_tag_title: props.post ? props.post.meta_tag_title : '',
    meta_tag_description: props.post ? props.post.meta_tag_description : '',

    remove_previous_image: false
})

const { isCreate } = useFormContext()

const submitForm = () => {
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
