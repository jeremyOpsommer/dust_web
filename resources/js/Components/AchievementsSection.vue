<template>
    <section id="achievements" class="py-16 bg-gray-800">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-blue-500 mb-8">{{ title }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="achievement in achievements" :key="achievement.title" class="bg-gray-700 rounded-lg p-6 shadow-lg hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold mb-2">{{ achievement.title }}</h3>
                    <p>{{ achievement.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    title: String,
    achievements: Array
});
</script>
