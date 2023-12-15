<template>
    <AppSectionHeader :title="__('Roles')" :bread-crumb="breadCrumb">
        <template #right>
            <AppButton
                v-if="can('ACL: Role - Create')"
                class="btn btn-primary"
                @click="$inertia.visit(route('aclRole.create'))"
            >
                {{ __('Create Role') }}
            </AppButton>
        </template>
    </AppSectionHeader>

    <AppDataSearch
        v-if="roles.data.length || route().params.searchTerm"
        :url="route('aclRole.index')"
        fields-to-search="name"
    ></AppDataSearch>

    <AppDataTable v-if="roles.data.length" :headers="headers">
        <template #TableBody>
            <tbody>
                <AppDataTableRow v-for="item in roles.data" :key="item.id">
                    <AppDataTableData>
                        {{ item.id }}
                    </AppDataTableData>

                    <AppDataTableData>
                        {{ item.name }}
                    </AppDataTableData>

                    <AppDataTableData>
                        <!-- role permissions -->
                        <AppTooltip
                            v-if="can('Acl: Role - Manage Permissions')"
                            :text="__('Role Permissions')"
                            class="mr-3"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    $inertia.visit(
                                        route('aclRolePermission.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-shield-keyhole-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- edit role -->
                        <AppTooltip
                            v-if="can('ACL: Role - Edit')"
                            :text="__('Edit Role')"
                            class="mr-3"
                        >
                            <AppButton
                                class="btn btn-icon btn-primary"
                                @click="
                                    $inertia.visit(
                                        route('aclRole.edit', item.id)
                                    )
                                "
                            >
                                <i class="ri-edit-line"></i>
                            </AppButton>
                        </AppTooltip>

                        <!-- delete role -->
                        <AppTooltip
                            v-if="can('ACL: Role - Delete')"
                            :text="__('Delete Role')"
                        >
                            <AppButton
                                class="btn btn-icon btn-destructive"
                                @click="validateRoleDeletion(item.id)"
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
        :links="roles.links"
        class="mt-4 justify-center"
    ></AppPaginator>

    <AppAlert v-if="!roles.data.length" class="mt-4">
        {{ __('No roles found') }}
    </AppAlert>

    <AppConfirmDialog ref="confirmDialogRef"></AppConfirmDialog>

    <AppToast ref="toastRef">
        <AppAlert type="error" class="mb-4">
            It's a demo, please don't delete the root role...
        </AppAlert>
    </AppToast>
</template>

<script setup>
import { ref } from 'vue'
import useAuthCan from '@/Composables/useAuthCan'

const props = defineProps({
    roles: {
        type: Object,
        default: () => {}
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Roles', last: true }
]

const headers = ['ID', 'Name', 'Actions']

const confirmDialogRef = ref(null)
const confirmDelete = (deleteRoute) => {
    confirmDialogRef.value.openModal(deleteRoute)
}

const toastRef = ref(null)
const validateRoleDeletion = (roleId) => {
    //root role, should not be deleted
    if (roleId === 1) {
        toastRef.value.open()
    } else {
        confirmDelete(route('aclRole.destroy', roleId))
    }
}

const { can } = useAuthCan()
</script>
