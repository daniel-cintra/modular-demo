<template>
    <div class="mt-8">
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
                    'input-error': errorsFields.includes('meta_tag_title')
                }"
            />
        </div>

        <div class="mt-5">
            <AppLabel for="meta_tag_description">Meta Tag Description</AppLabel>
            <AppTextArea
                id="meta_tag_description"
                v-model="form.meta_tag_description"
                class="h-24"
                :class="{
                    'input-error': errorsFields.includes('meta_tag_description')
                }"
            />
        </div>
    </div>
</template>

<script setup></script>
