<template>
    <AdminLayout>
        <div class="max-w-lg">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Ajouter un utilisateur</h1>

            <form @submit.prevent="submit" class="space-y-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Pseudo</label>
                    <input v-model="form.name" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        :class="{ 'border-red-500': form.errors.name }" />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input v-model="form.email" type="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        :class="{ 'border-red-500': form.errors.email }" />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                    <input v-model="form.password" type="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        :class="{ 'border-red-500': form.errors.password }" />
                    <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Confirmer</label>
                    <input v-model="form.password_confirmation" type="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                <div v-if="roles.length">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Rôles</label>
                    <div v-for="role in roles" :key="role" class="flex items-center gap-2 mb-1">
                        <input :id="'role-' + role" type="checkbox" :value="role" v-model="form.roles"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded dark:bg-gray-700" />
                        <label :for="'role-' + role" class="text-sm text-gray-700 dark:text-gray-300">{{ role }}</label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a :href="route('admin.users.index')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                        Annuler
                    </a>
                    <button type="submit" :disabled="form.processing"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 disabled:opacity-50 dark:bg-blue-600 dark:hover:bg-blue-700">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps<{ roles: string[] }>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [] as string[],
});

function submit() {
    form.post(route('admin.users.store'));
}
</script>
