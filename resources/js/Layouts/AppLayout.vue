<template>
    <div class="bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-600
    text-gray-900 dark:text-white
    min-h-screen flex flex-col">
        <Header />
        <main class="flex-1">
            <slot />
        </main>
        <Footer />
        <Toast />
    </div>
</template>

<script setup lang="ts">
import Header from '@/Components/Layout/Header.vue';
import Footer from '@/Components/Layout/Footer.vue';
import Toast from '@/Components/Layout/Toast.vue';
</script>
