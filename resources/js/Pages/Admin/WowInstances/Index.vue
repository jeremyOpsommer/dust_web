<template>
    <AdminLayout>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Instances WoW</h1>
        </div>

        <div v-if="instances.length === 0" class="text-sm text-gray-500 dark:text-gray-400">
            Aucune instance enregistrée. Les instances apparaissent automatiquement lors du rafraîchissement d'un personnage.
        </div>

        <template v-else>
            <div v-for="(group, expansionId) in groupedInstances" :key="expansionId" class="mb-8">
                <!-- En-tête extension -->
                <div class="flex items-center gap-3 mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ group.expansion_name_fr ?? group.expansion_name_en }}
                            <span class="text-xs text-gray-400 ml-1">({{ group.expansion_name_en }})</span>
                        </h2>
                        <div v-if="editingExpansion === String(expansionId)" class="flex items-center gap-2 mt-1">
                            <input v-model="expansionForm.expansion_name_fr" type="text"
                                class="px-2 py-1 text-sm border border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Nom FR extension"
                                @keyup.escape="editingExpansion = null" />
                            <input v-model="expansionForm.season" type="text"
                                class="px-2 py-1 text-sm border border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Saison (ex: Saison 2)"
                                @keyup.enter="saveExpansion(group)"
                                @keyup.escape="editingExpansion = null" />
                            <button @click="saveExpansion(group)"
                                class="px-3 py-1 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700">
                                OK
                            </button>
                            <button @click="editingExpansion = null"
                                class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                                Annuler
                            </button>
                        </div>
                        <div v-else class="flex items-center gap-2 mt-0.5">
                            <span v-if="group.season" class="text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ group.season }}
                            </span>
                            <button @click="startEditExpansion(group)"
                                class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 underline">
                                Modifier extension / saison
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tableau des instances -->
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">ID Blizzard</th>
                                <th class="px-6 py-3">Nom (EN)</th>
                                <th class="px-6 py-3">Nom (FR)</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="instance in group.instances" :key="instance.id"
                                class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 text-gray-400">{{ instance.blizzard_id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ instance.name_en }}</td>
                                <td class="px-6 py-4">
                                    <template v-if="editingId === instance.id">
                                        <input v-model="editForm.name_fr" type="text"
                                            class="w-full px-2 py-1 text-sm border border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                            :placeholder="instance.name_en"
                                            @keyup.enter="save(instance)"
                                            @keyup.escape="editingId = null" />
                                    </template>
                                    <span v-else class="text-gray-900 dark:text-white">
                                        {{ instance.name_fr ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <template v-if="editingId === instance.id">
                                        <button @click="save(instance)"
                                            class="px-3 py-1 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700">
                                            Enregistrer
                                        </button>
                                        <button @click="editingId = null"
                                            class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                                            Annuler
                                        </button>
                                    </template>
                                    <button v-else @click="startEdit(instance)"
                                        class="px-3 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded hover:bg-blue-100 dark:bg-blue-900 dark:text-blue-300">
                                        Modifier
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

type Instance = {
    id: number;
    blizzard_id: number;
    name_en: string;
    name_fr: string | null;
    expansion_id: number | null;
    expansion_name_en: string | null;
    expansion_name_fr: string | null;
    season: string | null;
};

type ExpansionGroup = {
    expansion_id: number | null;
    expansion_name_en: string | null;
    expansion_name_fr: string | null;
    season: string | null;
    instances: Instance[];
};

const props = defineProps<{ instances: Instance[] }>();

// Regrouper par extension
const groupedInstances = computed(() => {
    const groups: Record<string, ExpansionGroup> = {};
    for (const instance of props.instances) {
        const key = String(instance.expansion_id ?? 'unknown');
        if (!groups[key]) {
            groups[key] = {
                expansion_id: instance.expansion_id,
                expansion_name_en: instance.expansion_name_en,
                expansion_name_fr: instance.expansion_name_fr,
                season: instance.season,
                instances: [],
            };
        }
        groups[key].instances.push(instance);
    }
    return groups;
});

// Édition nom instance
const editingId = ref<number | null>(null);
const editForm = useForm({ name_fr: '' as string | null });

function startEdit(instance: Instance) {
    editingId.value = instance.id;
    editForm.name_fr = instance.name_fr ?? '';
}

function save(instance: Instance) {
    editForm.put(route('admin.wow-instances.update', instance.id), {
        preserveScroll: true,
        onSuccess: () => { editingId.value = null; },
    });
}

// Édition extension / saison
const editingExpansion = ref<string | null>(null);
const expansionForm = useForm({
    expansion_id: null as number | null,
    expansion_name_fr: '' as string | null,
    season: '' as string | null,
});

function startEditExpansion(group: ExpansionGroup) {
    editingExpansion.value = String(group.expansion_id);
    expansionForm.expansion_id = group.expansion_id;
    expansionForm.expansion_name_fr = group.expansion_name_fr ?? '';
    expansionForm.season = group.season ?? '';
}

function saveExpansion(group: ExpansionGroup) {
    expansionForm.put(route('admin.wow-instances.update-expansion'), {
        preserveScroll: true,
        onSuccess: () => { editingExpansion.value = null; },
    });
}
</script>
