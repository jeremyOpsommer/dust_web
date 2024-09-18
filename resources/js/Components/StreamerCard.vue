<template>
    <div class="bg-gray-700 p-4 rounded-lg shadow-lg">
        <img :src="streamer.avatar" :alt="streamer.name" class="w-full h-32 object-cover rounded-lg" />
        <h3 class="text-xl font-semibold mt-2">{{ streamer.name }}</h3>
        <p class="text-gray-400 mt-1">{{ streamer.description }}</p>
    </div>
</template>

<script>
export default {
    props: {
        streamer: Object,
    },
};
</script>
