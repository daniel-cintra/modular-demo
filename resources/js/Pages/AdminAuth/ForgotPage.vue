<template>
    <AppAuthShell>
        <AppAuthLogo />

        <AppCard class="space-y-6 px-16">
            <template #title>
                <h3 class="text-2xl font-semibold tracking-tight">
                    {{ __('Forgot your password?') }}
                </h3>
            </template>

            <template #description>
                <h2 class="mt-2">
                    {{ __('Enter your email to reset your password.') }}
                </h2>
            </template>

            <template #content>
                <AppFormErrors class="mb-4" />

                <form>
                    <div>
                        <AppLabel for="email">{{ __('Your Email') }}</AppLabel>
                        <AppInputText
                            id="email"
                            v-model="form.email"
                            type="text"
                            class="w-full"
                            :class="{
                                'p-invalid': errorsFields.includes('email')
                            }"
                        />
                    </div>
                </form>
            </template>

            <template #footer>
                <AppButton class="btn btn-primary" @click="submitForm">
                    {{ __('Send') }}
                </AppButton>
            </template>
        </AppCard>

        <AppToast ref="toastRef">
            <AppAlert type="warning" class="mb-4">
                The Demo App version will not send the email to reset
                passwords...
            </AppAlert>
        </AppToast>
    </AppAuthShell>
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayout.vue'

export default {
    layout: GuestLayout
}
</script>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import useFormErrors from '@/Composables/useFormErrors'

const form = useForm({
    email: ''
})

const toastRef = ref(null)

function submitForm() {
    toastRef.value.close()
    toastRef.value.open()
    // form.post(route('adminAuth.sendResetLinkEmail'))
}

const { errorsFields } = useFormErrors()
</script>
