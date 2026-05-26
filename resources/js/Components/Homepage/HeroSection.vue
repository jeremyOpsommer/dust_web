<template>
    <section class="relative bg-cover bg-center h-screen flex items-center justify-center text-center" :style="{ backgroundImage: `url(${backgroundImage})` }">
        <div class="absolute inset-0 bg-opacity-50"></div>
        <div class="relative z-10 px-4 py-8 md:px-8 md:py-16 max-w-2xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4">{{ title }}</h1>
            <p class="text-lg mb-8">{{ subtitle }}</p>
            <a :href="ctaLink" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-semibold transition">{{ ctaText }}</a>
        </div>
    </section>
</template>

<script setup lang="ts">
defineProps<{
    title: string
    subtitle: string
    ctaLink: string
    ctaText: string
    backgroundImage: string
}>()
</script>
