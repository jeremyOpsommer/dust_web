<template>
    <AdminLayout>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Utilisateurs</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.users }}</p>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps<{
    stats: { users: number };
}>();
</script>
