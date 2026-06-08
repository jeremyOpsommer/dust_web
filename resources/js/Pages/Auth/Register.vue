<template>
    <GuestLayout>
        <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Créer un compte</h1>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Pseudo</label>
                <input
                    v-model="form.name"
                    type="text"
                    autocomplete="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    :class="{ 'border-red-500': form.errors.name }"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

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
                    autocomplete="new-password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    :class="{ 'border-red-500': form.errors.password }"
                />
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Confirmer le mot de passe</label>
                <input
                    v-model="form.password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                />
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 disabled:opacity-50"
            >
                S'inscrire
            </button>

            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                Déjà un compte ?
                <a :href="route('login')" class="text-blue-600 hover:underline dark:text-blue-400">Se connecter</a>
            </p>
        </form>
    </GuestLayout>
</template>

<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>
