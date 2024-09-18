<template>
    <div class="bg-gray-900 text-white min-h-screen">
        <header class="bg-gray-800 p-4">
            <nav class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Gaming Hub</h1>
                <ul class="flex space-x-4">
                    <li><a href="#streamers" class="hover:underline">Streamers</a></li>
                    <li><a href="#guides" class="hover:underline">Guides</a></li>
                    <li><a href="#achievements" class="hover:underline">Achievements</a></li>
                </ul>
            </nav>
        </header>
        <main class="container mx-auto p-6">
            <!-- Streamers Section -->
            <section id="streamers" class="my-12">
                <h2 class="text-3xl font-bold mb-4">Top Streamers</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <StreamerCard v-for="streamer in streamers" :key="streamer.id" :streamer="streamer" />
                </div>
            </section>

            <!-- Guides Section -->
            <section id="guides" class="my-12">
                <h2 class="text-3xl font-bold mb-4">Game Guides</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <GuideCard v-for="guide in guides" :key="guide.id" :guide="guide" />
                </div>
            </section>

            <!-- Achievements Section -->
            <section id="achievements" class="my-12">
                <h2 class="text-3xl font-bold mb-4">User Achievements</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <UserAchievementCard v-for="achievement in achievements" :key="achievement.id" :achievement="achievement" />
                </div>
            </section>
        </main>
        <footer class="bg-gray-800 p-4 text-center">
            <p>&copy; 2024 Gaming Hub. All rights reserved.</p>
        </footer>
    </div>
</template>

<script>
import StreamerCard from '@/Components/StreamerCard.vue';
import GuideCard from '@/Components/GuideCard.vue';
import UserAchievementCard from '@/Components/UserAchievementCard.vue';

export default {
    props: {
        streamers: Array,
        guides: Array,
        achievements: Array,
    },
    components: {
        StreamerCard,
        GuideCard,
        UserAchievementCard,
    },
};
</script>
