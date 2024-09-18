<template>
    <section id="guides" class="py-16 bg-gray-900">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-pink-500 mb-8">{{ title }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="guide in guides" :key="guide.title" class="bg-gray-700 rounded-lg p-6 shadow-lg hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold mb-2">{{ guide.title }}</h3>
                    <p>{{ guide.description }}</p>
                    <a :href="guide.link" class="text-pink-500 hover:underline mt-4 inline-block">Lire le guide</a>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    title: String,
    guides: Array
});
</script>
