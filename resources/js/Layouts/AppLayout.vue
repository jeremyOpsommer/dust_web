<template>
    <div class="bg-gray-900 text-white min-h-screen flex flex-col">
        <Header />
        <main class="flex-1">
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
</script>
