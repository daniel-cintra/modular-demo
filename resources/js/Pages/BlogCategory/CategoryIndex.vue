<template>
    <AppSectionHeader title="Categories" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                class="btn btn-primary"
                @click="$inertia.visit(route('blogCategory.create'))"
            >
                Create Category
            </AppButton>
        </template>
    </AppSectionHeader>

    <AppDataSearch
        v-if="categories.data.length || route().params.searchTerm"
        :url="route('blogCategory.index')"
        fields-to-search="name"
    ></AppDataSearch>

    <AppDataTable v-if="categories.data.length" :headers="headers">
        <template #TableBody>
            <tbody>
                <AppDataTableRow v-for="item in categories.data" :key="item.id">
                    <AppDataTableData>
                        {{ item.id }}
                    </AppDataTableData>

                    <AppDataTableData>
                        {{ item.name }}
                    </AppDataTableData>

                    <AppDataTableData>
                        <!-- edit category -->
                        <AppTooltip text="Edit Category" class="mr-3">
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    $inertia.visit(
                                        route('blogCategory.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-edit-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- delete category -->
                        <AppTooltip text="Delete Category">
                            <AppButton
                                class="btn btn-icon btn-destructive"
                                @click="
                                    confirmDelete(
                                        route('blogCategory.destroy', item.id)
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
        :links="categories.links"
        class="mt-4 justify-center"
    ></AppPaginator>

    <AppAlert v-if="!categories.data.length" class="mt-4">
        No categories found.
    </AppAlert>

    <AppConfirmDialog ref="confirmDialogRef"></AppConfirmDialog>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    categories: {
        type: Object,
        default: () => {}
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Categories', last: true }
]

const headers = ['ID', 'Name', 'Actions']

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}
</script>
