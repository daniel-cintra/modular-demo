<template>
    <AppSectionHeader title="Posts" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                v-if="can('Blog: Post - Create')"
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
                            class="h-10 w-10 rounded"
                        />

                        <AppImageNotAvailable v-else />
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
                        <AppTooltip
                            v-if="can('Blog: Post - Edit')"
                            text="Edit Post"
                            class="mr-3"
                        >
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
                        <AppTooltip
                            v-if="can('Blog: Post - Delete')"
                            text="Delete Post"
                        >
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
import useAuthCan from '@/Composables/useAuthCan'

const props = defineProps({
    posts: {
        type: Object,
        default: () => {}
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Posts', last: true }
]

const headers = ['Image', 'Title', 'Status', 'Actions']

const getPostStatusClass = (status) => {
    return status === 'Published' ? 'published' : 'draft'
}

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}

const { can } = useAuthCan()
</script>

<style scoped>
.published {
    @apply bg-skin-success-light  text-skin-success;
}

.draft {
    @apply bg-skin-warning-light  text-skin-warning;
}
</style>
