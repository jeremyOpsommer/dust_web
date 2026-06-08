<template>
    <GuestLayout>
        <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Connexion</h1>

        <div v-if="status" class="mb-4 p-3 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    :class="{ 'border-red-500': form.errors.email }"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                <input
                    v-model="form.password"
                    type="password"
                    autocomplete="current-password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    :class="{ 'border-red-500': form.errors.password }"
                />
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <div class="flex items-center">
                <input
                    v-model="form.remember"
                    id="remember"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                />
                <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</label>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 disabled:opacity-50"
            >
                Se connecter
            </button>

            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                Pas encore de compte ?
                <a :href="route('register')" class="text-blue-600 hover:underline dark:text-blue-400">S'inscrire</a>
            </p>
        </form>
    </GuestLayout>
</template>

<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps<{ status?: string }>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>
