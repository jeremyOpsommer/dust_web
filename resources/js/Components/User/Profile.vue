<template>
    <div class="space-y-4">
        <template v-if="!editing">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-3">
                    <dl>
                        <dt class="font-semibold text-gray-900 dark:text-white">Pseudo</dt>
                        <dd class="text-gray-500 dark:text-gray-400">{{ user?.name ?? '—' }}</dd>
                    </dl>
                    <dl>
                        <dt class="font-semibold text-gray-900 dark:text-white">Email</dt>
                        <dd class="text-gray-500 dark:text-gray-400">{{ user?.email ?? '—' }}</dd>
                    </dl>
                    <dl>
                        <dt class="font-semibold text-gray-900 dark:text-white">Inscrit le</dt>
                        <dd class="text-gray-500 dark:text-gray-400">{{ formatDate(user?.created_at) }}</dd>
                    </dl>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Dernière modification : {{ formatDate(user?.updated_at) }}
                </div>
            </div>
            <div class="flex justify-end">
                <button
                    type="button"
                    @click="startEdit"
                    class="px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Editer
                </button>
            </div>
        </template>

        <template v-else>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Pseudo</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        :class="{ 'border-red-500': form.errors.name }"
                    />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

                <hr class="border-gray-200 dark:border-gray-700" />
                <p class="text-sm text-gray-500 dark:text-gray-400">Laisser vide pour ne pas changer le mot de passe.</p>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Mot de passe actuel</label>
                    <input
                        v-model="form.current_password"
                        type="password"
                        autocomplete="current-password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        :class="{ 'border-red-500': form.errors.current_password }"
                    />
                    <p v-if="form.errors.current_password" class="mt-1 text-sm text-red-600">{{ form.errors.current_password }}</p>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nouveau mot de passe</label>
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

                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        @click="cancelEdit"
                        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700"
                    >
                        Annuler
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-50"
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
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    user: { name: string; email: string; created_at: string; updated_at: string } | null;
}>();

const editing = ref(false);

const form = useForm({
    name: props.user?.name ?? '',
    current_password: '',
    password: '',
    password_confirmation: '',
});

function startEdit() {
    form.name = props.user?.name ?? '';
    form.current_password = '';
    form.password = '';
    form.password_confirmation = '';
    editing.value = true;
}

function cancelEdit() {
    form.reset();
    form.clearErrors();
    editing.value = false;
}

function submit() {
    form.put(route('user.update'), {
        onSuccess: () => {
            form.current_password = '';
            form.password = '';
            form.password_confirmation = '';
            editing.value = false;
        },
    });
}

function formatDate(dateStr?: string): string {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleString('fr-FR', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit',
    });
}
</script>
