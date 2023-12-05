<template>
    <AppSectionHeader title="Categorys" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                class="btn btn-primary"
                @click="$inertia.visit(route('category.create'))"
            >
                Create Category
            </AppButton>
        </template>
    </AppSectionHeader>

    <AppDataSearch
        v-if="categorys.data.length || route().params.searchTerm"
        :url="route('category.index')"
        fields-to-search="id"
    ></AppDataSearch>

    <AppDataTable v-if="categorys.data.length" :headers="headers">
        <template #TableBody>
            <tbody>
                <AppDataTableRow
                    v-for="item in categorys.data"
                    :key="item.id"
                >
                    <AppDataTableData>
                        {{ item.id }}
                    </AppDataTableData>

                    <!-- <AppDataTableData>
                        {{ item.name }}
                    </AppDataTableData> -->

                    <AppDataTableData>
                        <!-- edit category -->
                        <AppTooltip text="Edit Category" class="mr-3">
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    $inertia.visit(
                                        route(
                                            'category.edit',
                                            item.id
                                        )
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
                                        route(
                                            'category.destroy',
                                            item.id
                                        )
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
        :links="categorys.links"
        class="mt-4 justify-center"
    ></AppPaginator>

    <AppAlert v-if="!categorys.data.length" class="mt-4">
        No categorys found.
    </AppAlert>

    <AppConfirmDialog ref="confirmDialogRef"></AppConfirmDialog>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  categorys: {
    type: Object,
    default: () => {}
  }
})

const breadCrumb = [
  { label: 'Home', href: route('dashboard.index') },
  { label: 'Categorys', last: true }
]

const headers = ['ID', 'Actions']

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}
</script>
