<template>
    <div
        class="sticky top-0 z-40 flex h-16 flex-shrink-0 justify-between bg-skin-neutral-2 py-3 pl-3 pr-9 text-skin-neutral-11 shadow-sm"
    >
        <div class="flex items-center">
            <AppButton
                class="btn btn-icon hover:bg-skin-neutral-4"
                @click="$emit('sidebar:toggle')"
            >
                <i class="ri-menu-line"></i>
            </AppButton>

            <h1 class="flex items-center">{{ title }}</h1>
        </div>

        <div class="flex items-center">
            <a
                class="z-0 inline-block h-10 w-10 rounded-md py-2.5 text-center text-sm font-medium transition-colors hover:bg-skin-neutral-4 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                href="https://github.com/daniel-cintra/modular-demo"
                target="_blank"
            >
                <i class="ri-github-fill"></i>
            </a>

            <AppButton
                href="#"
                class="btn btn-icon hover:bg-skin-neutral-4"
                @click="toggleTheme"
            >
                <i :class="iconThemeClass"></i>
            </AppButton>

            <AppButton
                class="btn btn-icon hover:bg-skin-neutral-4"
                @click="$inertia.visit(route('adminAuth.logout'))"
            >
                <i class="ri-logout-circle-r-line"></i>
            </AppButton>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    title: {
        type: String,
        default: ''
    }
})

defineEmits(['sidebar:toggle'])

const iconThemeClass = ref('ri-sun-line')

onMounted(() => {
    if (localStorage.getItem('modular-theme') === 'dark-theme') {
        document.documentElement.classList.add('dark-theme')
        iconThemeClass.value = 'ri-sun-line'
    } else {
        document.documentElement.classList.remove('dark-theme')
        iconThemeClass.value = 'ri-moon-line'
    }
})

const toggleTheme = () => {
    if (document.documentElement.classList.contains('dark-theme')) {
        document.documentElement.classList.remove('dark-theme')
        iconThemeClass.value = 'ri-moon-line'
        localStorage.removeItem('modular-theme')
    } else {
        localStorage.setItem('modular-theme', 'dark-theme')
        document.documentElement.classList.add('dark-theme')
        iconThemeClass.value = 'ri-sun-line'
    }
}
</script>
