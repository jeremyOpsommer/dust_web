<template>
    <div class="space-y-4">
        <template v-if="!editing">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-3">
                    <dl>
                        <dt class="font-semibold text-gray-900 dark:text-white">Pseudo</dt>
                        <dd class="text-gray-500 dark:text-gray-400">PlayerOne</dd>
                    </dl>
                    <dl>
                        <dt class="font-semibold text-gray-900 dark:text-white">Email</dt>
                        <dd class="text-gray-500 dark:text-gray-400">player@example.com</dd>
                    </dl>
                    <dl>
                        <dt class="font-semibold text-gray-900 dark:text-white">Inscrit le</dt>
                        <dd class="text-gray-500 dark:text-gray-400">01/01/2025 10:00</dd>
                    </dl>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Dernière modification : 01/02/2025 15:00
                </div>
            </div>
            <div class="flex justify-end">
                <button
                    type="button"
                    @click="editing = true"
                    class="px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Editer
                </button>
            </div>
        </template>

        <template v-else>
            <form @submit.prevent="editing = false" class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Pseudo</label>
                    <input
                        v-model="name"
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                </div>

                <hr class="border-gray-200 dark:border-gray-700" />
                <p class="text-sm text-gray-500 dark:text-gray-400">Laisser vide pour ne pas changer le mot de passe.</p>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Mot de passe actuel</label>
                    <input
                        type="password"
                        autocomplete="current-password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nouveau mot de passe</label>
                    <input
                        type="password"
                        autocomplete="new-password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Confirmer le mot de passe</label>
                    <input
                        type="password"
                        autocomplete="new-password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                </div>

                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        @click="editing = false"
                        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700"
                    >
                        Annuler
                    </button>
                    <button
                        type="submit"
                        class="px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Enregistrer
                    </button>
                </div>
            </form>
        </template>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const editing = ref(false);
const name = ref('PlayerOne');
</script>
