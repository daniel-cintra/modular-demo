<template>
    <AppSectionHeader :title="__('Users')" :bread-crumb="breadCrumb">
    </AppSectionHeader>

    <AppCard class="w-full md:w-3/4 xl:w-1/2">
        <template #title> {{ title }} </template>
        <template #content>
            <AppFormErrors class="mb-4" />
            <form>
                <div>
                    <AppLabel for="name">{{ __('Name') }}</AppLabel>
                    <AppInputText
                        id="name"
                        v-model="form.name"
                        type="text"
                        :class="{
                            'input-error': errorsFields.includes('name')
                        }"
                        autocomplete="off"
                    />
                </div>

                <div class="mt-6">
                    <AppLabel for="email">{{ __('Email') }}</AppLabel>
                    <AppInputText
                        id="email"
                        v-model="form.email"
                        type="text"
                        :class="{
                            'input-error': errorsFields.includes('email')
                        }"
                        autocomplete="off"
                    />
                </div>

                <div class="mt-6">
                    <AppLabel for="email">{{ __('Password') }}</AppLabel>
                    <AppInputPassword
                        id="password"
                        v-model="form.password"
                        :class="{
                            'input-error': errorsFields.includes('password')
                        }"
                    />
                </div>
            </form>
        </template>
        <template #footer>
            <AppButton
                v-if="!user || user.id !== 1"
                class="btn btn-primary"
                @click="submitForm"
            >
                {{ __('Save') }}
            </AppButton>

            <AppAlert v-else type="info" class="mb-4">
                For demo purposes, the example user cannot be edited...
            </AppAlert>
        </template>
    </AppCard>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

import useTitle from '@/Composables/useTitle'
import useFormContext from '@/Composables/useFormContext'
import useFormErrors from '@/Composables/useFormErrors'

const props = defineProps({
    user: {
        type: Object,
        default: null
    }
})

const breadCrumb = [
    { label: 'Home', href: route('dashboard.index') },
    { label: 'Users', href: route('user.index') },
    { label: 'User', last: true }
]

const { title } = useTitle('User')

const form = useForm({
    name: props.user ? props.user.name : '',
    email: props.user ? props.user.email : '',
    password: ''
})

const { isCreate } = useFormContext()

const submitForm = () => {
    if (isCreate.value) {
        form.post(route('user.store'))
    } else {
        form.put(route('user.update', props.user.id))
    }
}

const { errorsFields } = useFormErrors()
</script>

<!-- <style scoped>
.p-card::v-deep(.p-card-footer) {
  padding-top: 0;
}
</style> -->
