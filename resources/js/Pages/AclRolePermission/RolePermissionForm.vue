<template>
    <AppSectionHeader :title="__('Role Permissions')" :bread-crumb="breadCrumb">
    </AppSectionHeader>

    <AppCard>
        <template #title>
            {{ __('Role Permissions for') }}:
            <span class="text-skin-primary-10">{{ role.name }}</span>
        </template>
        <template #content>
            <div v-if="chunks.length">
                <AppFormErrors class="mb-4" />
                <form class="mt-5 flex">
                    <div
                        v-for="(column, index) in chunks"
                        :key="index"
                        class="w-1/3"
                    >
                        <div
                            v-for="permission in column"
                            :key="permission.id"
                            class="mb-4 flex items-center"
                        >
                            <AppCheckbox
                                :id="permission.name"
                                v-model="form.rolePermissions"
                                name="permission"
                                :value="permission"
                            />
                            <AppLabel :for="permission.name" class="ml-3">
                                {{ permission.name }}
                            </AppLabel>
                        </div>
                    </div>
                </form>
            </div>

            <AppAlert v-else class="mt-4">
                {{ __('No permissions found') }}
            </AppAlert>
        </template>

        <template #footer>
            <AppButton
                v-if="role.id && role.id !== 1 && chunks.length"
                class="btn btn-primary"
                @click="submitForm"
            >
                {{ __('Save') }}
            </AppButton>

            <AppAlert v-else type="info" class="mb-4">
                The 'root' role will always have all permissions associated and
                cannot be changed. There is no need to manually update them.
            </AppAlert>
        </template>
    </AppCard>
</template>

<script setup>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import chunk from '@/Utils/chunk'

const props = defineProps({
    role: {
        type: Object,
        required: true
    },
    permissions: {
        type: Array,
        required: true
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Roles', href: route('aclRole.index') },
    { label: 'Role Permissions', last: true }
]

const form = useForm({
    rolePermissions: props.role.permissions
})

const chunks = computed(() => {
    const itensPerColumn = props.permissions.length / 3

    return chunk(props.permissions, Math.ceil(itensPerColumn))
})

const submitForm = () => {
    form.put(route('aclRolePermission.update', props.role.id))
}
</script>
