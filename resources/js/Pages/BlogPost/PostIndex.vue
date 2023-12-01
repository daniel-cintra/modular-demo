<template>
    <AppSectionHeader title="Posts" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                class="btn btn-primary"
                @click="$inertia.visit(route('blogPost.create'))"
            >
                Create Post
            </AppButton>
        </template>
    </AppSectionHeader>

    <AppDataSearch
        v-if="posts.data.length || route().params.searchTerm"
        :url="route('blogPost.index')"
        fields-to-search="title"
    ></AppDataSearch>

    <AppDataTable v-if="posts.data.length" :headers="headers">
        <template #TableBody>
            <tbody>
                <AppDataTableRow v-for="item in posts.data" :key="item.id">
                    <AppDataTableData>
                        <img
                            v-if="item.image_url"
                            :src="item.image_url"
                            class="ml-3 h-10 w-10 rounded"
                        />

                        <div
                            v-else
                            class="ml-3 flex h-10 w-10 items-center justify-center rounded bg-gradient-to-bl from-skin-neutral-3 to-skin-neutral-6"
                        >
                            <span class="text-xs text-skin-neutral-9">N/A</span>
                        </div>
                    </AppDataTableData>

                    <AppDataTableData>
                        {{ item.title }}
                    </AppDataTableData>

                    <AppDataTableData>
                        <span
                            class="rounded px-3 py-1 text-sm"
                            :class="getPostStatusClass(item.status)"
                        >
                            {{ item.status }}
                        </span>
                    </AppDataTableData>

                    <AppDataTableData>
                        <!-- edit post -->
                        <AppTooltip text="Edit Post" class="mr-3">
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    $inertia.visit(
                                        route('blogPost.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-edit-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- delete post -->
                        <AppTooltip text="Delete Post">
                            <AppButton
                                class="btn btn-icon btn-destructive"
                                @click="
                                    confirmDelete(
                                        route('blogPost.destroy', item.id)
                                    )
                                "
                            >
                                <i class="ri-delete-bin-line"></i>
                            </AppButton>
                        </AppTooltip>
                    </AppDataTableData>
                </AppDataTableRow>
            </tbody>
        </template>
    </AppDataTable>

    <AppPaginator
        :links="posts.links"
        class="mt-4 justify-center"
    ></AppPaginator>

    <AppAlert v-if="!posts.data.length" class="mt-4">
        No posts found.
    </AppAlert>

    <AppConfirmDialog ref="confirmDialogRef"></AppConfirmDialog>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    posts: {
        type: Object,
        default: () => {}
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Blogs', last: true }
]

const headers = ['Image', 'Title', 'Status', 'Actions']

const getPostStatusClass = (status) => {
    if (status === 'Published') {
        return 'published'
    } else {
        return 'draft'
    }
}

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}
</script>

<style scoped>
.published {
    @apply bg-skin-success-light  text-skin-success;
}

.draft {
    @apply bg-skin-warning-light  text-skin-warning;
}
</style>
