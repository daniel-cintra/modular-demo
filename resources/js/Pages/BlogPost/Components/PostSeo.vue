<template>
    <div class="mt-10">
        <h4 class="flex items-end justify-between text-xl">
            <span>SEO - Preview of how it will be listed on Google</span>

            <a
                href="#"
                class="text-sm text-skin-primary-9 hover:underline"
                @click.prevent="toggleSeoForm"
            >
                Edit SEO content
            </a>
        </h4>

        <small
            v-show="postStore.showSeoAlert()"
            class="block text-sm text-skin-neutral-9"
        >
            (fill the title and description to see a preview)
        </small>

        <template v-if="showSeoForm">
            <div>
                <div class="mb-2 mt-2 flex items-center">
                    <div
                        class="mr-4 flex h-10 w-10 rounded-full bg-gradient-to-bl from-skin-neutral-3 to-skin-neutral-6"
                    ></div>

                    <div class="flex flex-col items-start">
                        <p class="text-sm">Your Site Name</p>
                        <p class="-mt-1 text-sm text-skin-neutral-10">
                            https://your-domain.com/blog/post/{{
                                postStore.getSlug()
                            }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-2xl text-skin-primary-11">
                        {{ postStore.post.meta_tag_title }}
                    </p>

                    <p class="">
                        {{ postStore.post.meta_tag_description }}
                    </p>
                </div>
            </div>

            <div class="mt-5 border-t border-dashed pt-5">
                <AppLabel for="meta_tag_title">Meta Tag Title</AppLabel>
                <AppInputText
                    id="meta_tag_title"
                    v-model="postStore.post.meta_tag_title"
                    type="text"
                    maxlength="60"
                    :class="{
                        'input-error': errorsFields.includes('meta_tag_title')
                    }"
                />
                <small class="block text-right text-skin-neutral-9">
                    {{ postStore.getRemainingChars('meta_tag_title', 60) }}
                    of 60
                </small>
            </div>

            <div class="mt-5">
                <AppLabel for="meta_tag_description"
                    >Meta Tag Description</AppLabel
                >
                <AppTextArea
                    id="meta_tag_description"
                    v-model="postStore.post.meta_tag_description"
                    class="h-24"
                    maxlength="160"
                    :class="{
                        'input-error': errorsFields.includes(
                            'meta_tag_description'
                        )
                    }"
                />
                <small class="block text-right text-skin-neutral-9">
                    {{
                        postStore.getRemainingChars('meta_tag_description', 160)
                    }}
                    of 160
                </small>
            </div>
        </template>
    </div>
</template>

<script setup>
import useFormErrors from '@/Composables/useFormErrors'
import useFormContext from '@/Composables/useFormContext'
import { usePostStore } from '../PostStore'
import AppAlert from '@/Components/Message/AppAlert.vue'
import { ref, onMounted } from 'vue'
const postStore = usePostStore()
const { errorsFields } = useFormErrors()

const { isCreate } = useFormContext()

const showSeoForm = ref(false)

onMounted(() => {
    if (!isCreate.value) {
        showSeoForm.value = true
    }
})

const toggleSeoForm = () => {
    if (
        !showSeoForm.value &&
        isCreate.value &&
        !postStore.post.meta_tag_title.length &&
        !postStore.post.meta_tag_description.length
    ) {
        postStore.initSeoTags()
    }

    showSeoForm.value = !showSeoForm.value
}

// postStore.$subscribe((mutation, state) => {
//     console.log('mutation', mutation)
//     console.log('mutation key', mutation.events.key)
//     if (
//         (mutation.events.key === 'title' ||
//             mutation.events.key === 'content') &&
//         postStore.showSeoAlert()
//     ) {
//         postStore.initSeoTags()
//     }
// })
</script>
