<template>
    <AdminLayout>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Utilisateurs</h1>
            <a :href="route('admin.users.create')" class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">
                Ajouter
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Pseudo</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Rôles</th>
                        <th class="px-6 py-3">Inscrit le</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id" class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ user.name }}</td>
                        <td class="px-6 py-4">{{ user.email }}</td>
                        <td class="px-6 py-4">
                            <span
                                v-for="role in user.roles" :key="role"
                                class="me-1 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded dark:bg-blue-900 dark:text-blue-300"
                            >{{ role }}</span>
                        </td>
                        <td class="px-6 py-4">{{ user.created_at }}</td>
                        <td class="px-6 py-4 flex gap-3 justify-end">
                            <a :href="route('admin.users.edit', user.id)" class="text-blue-600 hover:underline dark:text-blue-400">Éditer</a>
                            <button @click="destroy(user.id)" class="text-red-600 hover:underline dark:text-red-400">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps<{
    users: { id: number; name: string; email: string; roles: string[]; created_at: string }[];
}>();

const deleteForm = useForm({});

function destroy(id: number) {
    if (confirm('Supprimer cet utilisateur ?')) {
        deleteForm.delete(route('admin.users.destroy', id));
    }
}
</script>
