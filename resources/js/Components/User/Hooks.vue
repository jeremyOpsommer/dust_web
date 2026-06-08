<template>
    <div class="space-y-6">

        <!-- Twitch -->
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="font-semibold text-gray-900 dark:text-white">Twitch</span>
                <span class="w-2.5 h-2.5 rounded-full bg-gray-400 dark:bg-gray-600"></span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Bientôt disponible</p>
        </div>

        <hr class="border-gray-200 dark:border-gray-700" />

        <!-- Battle.net -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <svg fill="#0fafff" width="22px" height="22px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 26.578125 14.339844 C 26.578125 14.339844 28.882813 14.457031 28.882813 13.101563 C 28.882813 11.332031 25.8125 9.738281 25.8125 9.738281 C 25.8125 9.738281 26.292969 8.71875 26.59375 8.148438 C 26.894531 7.578125 27.738281 5.359375 27.8125 4.851563 C 27.90625 4.210938 27.761719 4.011719 27.761719 4.011719 C 27.554688 5.378906 25.328125 9.316406 25.148438 9.449219 C 22.976563 8.433594 19.992188 8.148438 19.992188 8.148438 C 19.992188 8.148438 17.070313 2 14.320313 2 C 11.59375 2 11.609375 7.265625 11.609375 7.265625 C 11.609375 7.265625 10.839844 5.773438 9.871094 5.773438 C 8.457031 5.773438 7.992188 7.90625 7.992188 10.222656 C 5.203125 10.222656 2.855469 10.847656 2.644531 10.90625 C 2.4375 10.964844 1.777344 11.445313 2.074219 11.386719 C 2.6875 11.191406 5.554688 10.746094 8.0625 10.964844 C 8.203125 13.164063 9.488281 16.03125 9.488281 16.03125 C 9.488281 16.03125 6.730469 20.023438 6.730469 22.871094 C 6.730469 23.621094 7.058594 24.992188 9.035156 24.992188 C 10.695313 24.992188 12.558594 23.996094 12.90625 23.796875 C 12.601563 24.230469 12.375 25.0625 12.375 25.445313 C 12.375 25.757813 12.5625 26.644531 13.839844 26.644531 C 15.480469 26.644531 17.316406 25.386719 17.316406 25.386719 C 17.316406 25.386719 19.050781 28.261719 20.53125 29.578125 C 20.929688 29.933594 21.3125 30 21.3125 30 C 21.3125 30 19.839844 28.585938 17.902344 24.9375 C 19.703125 23.828125 21.578125 21.203125 21.578125 21.203125 C 21.578125 21.203125 21.800781 21.210938 23.511719 21.210938 C 26.191406 21.210938 29.996094 20.648438 29.996094 18.519531 C 30 16.324219 26.578125 14.339844 26.578125 14.339844 Z"/>
                    </svg>
                    <span class="font-semibold text-gray-900 dark:text-white">Battle.net</span>
                    <span class="w-2.5 h-2.5 rounded-full" :class="blizzardConnected ? 'bg-green-500' : 'bg-gray-400'"></span>
                </div>
                <a v-if="!blizzardConnected" :href="route('blizzard.oauth.redirect')"
                    class="px-3 py-1.5 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">
                    Se connecter
                </a>
                <span v-else class="text-xs text-green-600 dark:text-green-400 font-medium">Connecté</span>
            </div>

            <!-- WoW -->
            <template v-if="blizzardConnected">
                <div class="flex items-center gap-2 mb-3 mt-4">
                    <img src="../../../images/icons/WoW_icon.svg" alt="wow" class="w-5 h-5" />
                    <span class="font-medium text-gray-900 dark:text-white text-sm">World of Warcraft</span>
                </div>

                <!-- Personnages sauvegardés -->
                <div v-if="wowCharacters.length" class="space-y-2 mb-4">
                    <div v-for="char in wowCharacters" :key="char.id"
                        class="rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden">

                        <!-- En-tête personnage -->
                        <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700">
                            <button @click="toggleCharacter(char.id)" class="flex items-center gap-3 flex-1 text-left">
                                <div class="w-10 h-10 bg-cover rounded-full border border-gray-200 dark:border-gray-600 shrink-0"
                                    :style="`background-image: url(${char.avatar_url})`"></div>
                                <div class="text-xs">
                                    <div class="font-semibold" :style="`color: ${classColor(char.class_name)}`">{{ char.name }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <b>{{ char.level }}</b> {{ char.class_name }}
                                        <span v-if="char.stats?.item_level" class="ml-1 text-yellow-500 dark:text-yellow-400">({{ char.stats.item_level }} iLvl)</span>
                                    </div>
                                    <div class="text-gray-400">{{ char.realm_name }}</div>
                                </div>
                                <svg class="w-4 h-4 ml-2 text-gray-400 transition-transform"
                                    :class="{ 'rotate-180': openCharacter === char.id }"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div class="flex items-center gap-1 ml-2">
                                <span v-if="char.last_refreshed_at" class="text-xs text-gray-400 mr-1">{{ char.last_refreshed_at }}</span>
                                <button @click="refreshCharacter(char.id)" :disabled="!char.can_refresh"
                                    class="p-1 text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 disabled:opacity-30 disabled:cursor-not-allowed"
                                    :title="char.can_refresh ? 'Mettre à jour' : 'Disponible dans 1h'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                                <button @click="removeCharacter(char.id)"
                                    class="p-1 text-red-500 hover:text-red-700 dark:hover:text-red-400" title="Retirer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Données détaillées -->
                        <div v-if="openCharacter === char.id" class="p-3 text-xs space-y-4 bg-white dark:bg-gray-800">

                            <!-- Pas encore de données -->
                            <p v-if="!char.stats && !char.equipment && !char.pve_progression"
                                class="text-gray-500 dark:text-gray-400 italic">
                                Aucune donnée — cliquez sur 🔄 pour synchroniser.
                            </p>

                            <!-- Stats -->
                            <div v-if="char.stats">
                                <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Statistiques</p>
                                <div class="grid grid-cols-2 gap-x-6 gap-y-1 text-gray-600 dark:text-gray-400">
                                    <span>Item level moyen</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.item_level ?? '—' }}</span>
                                    <template v-if="char.stats.strength"><span>Force</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.strength }}</span></template>
                                    <template v-if="char.stats.agility"><span>Agilité</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.agility }}</span></template>
                                    <template v-if="char.stats.intellect"><span>Intelligence</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.intellect }}</span></template>
                                    <span>Endurance</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.stamina ?? '—' }}</span>
                                    <span>Critique</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.critical_strike }}%</span>
                                    <span>Hâte</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.haste }}%</span>
                                    <span>Maîtrise</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.mastery }}%</span>
                                    <span>Polyvalence</span><span class="font-medium text-gray-900 dark:text-white">{{ char.stats.versatility }}%</span>
                                </div>
                            </div>

                            <!-- Équipement -->
                            <div v-if="char.equipment?.length">
                                <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Équipement</p>
                                <div class="space-y-1">
                                    <div v-for="slot in char.equipment" :key="slot.slot"
                                        class="flex items-start gap-2 text-gray-600 dark:text-gray-400">
                                        <span class="w-28 shrink-0">{{ slotName(slot.slot) }}</span>
                                        <span class="font-medium text-gray-900 dark:text-white">#{{ slot.item_id }}</span>
                                        <span v-if="slot.enchantments.length" class="text-purple-500">
                                            ✦ {{ slot.enchantments.join(', ') }}
                                        </span>
                                        <span v-if="slot.gems.length" class="text-cyan-500">
                                            ◆ {{ slot.gems.join(', ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Progression PVE -->
                            <div v-if="char.pve_progression?.length">
                                <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Progression PVE</p>
                                <div class="space-y-2">
                                    <div v-for="raid in char.pve_progression" :key="raid.name">
                                        <p class="font-medium text-gray-800 dark:text-gray-200 mb-1">{{ raidName(raid) }}</p>
                                        <div class="flex gap-4 text-gray-600 dark:text-gray-400">
                                            <span>Normal <b class="text-gray-900 dark:text-white">{{ raid.normal.completed }}/{{ raid.normal.total }}</b></span>
                                            <span>Héroïque <b class="text-gray-900 dark:text-white">{{ raid.heroic.completed }}/{{ raid.heroic.total }}</b></span>
                                            <span>Mythique <b class="text-gray-900 dark:text-white">{{ raid.mythic.completed }}/{{ raid.mythic.total }}</b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <p v-else class="text-sm text-gray-500 dark:text-gray-400 mb-3">Aucun personnage ajouté.</p>

                <!-- Bouton pour ouvrir la sélection -->
                <button @click="togglePicker" type="button"
                    class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">
                    {{ showPicker ? 'Fermer' : '+ Ajouter un personnage' }}
                </button>

                <!-- Picker : liste des personnages Blizzard -->
                <div v-if="showPicker" class="mt-3">
                    <div v-if="loadingCharacters" class="text-sm text-gray-500 dark:text-gray-400">Chargement...</div>
                    <div v-else-if="apiError" class="text-sm text-red-500">{{ apiError }}</div>
                    <div v-else-if="unsavedCharacters.length === 0" class="text-sm text-gray-500 dark:text-gray-400">
                        Tous vos personnages ont été ajoutés.
                    </div>
                    <div v-else class="space-y-2 max-h-72 overflow-y-auto pr-1">
                        <div v-for="char in unsavedCharacters" :key="char.blizzard_id"
                            class="flex items-center justify-between p-2 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-cover rounded-full border border-gray-200 dark:border-gray-600"
                                    :style="`background-image: url(${char.avatar_url})`"></div>
                                <div class="text-xs">
                                    <div class="font-semibold" :style="`color: ${classColor(char.class_name)}`">{{ char.name }}</div>
                                    <div class="text-gray-500 dark:text-gray-400"><b>{{ char.level }}</b> {{ char.class_name }}</div>
                                    <div class="text-gray-400">{{ char.realm_name }}</div>
                                </div>
                            </div>
                            <button @click="addCharacter(char)" type="button"
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-700 rounded hover:bg-blue-800 dark:bg-blue-600">
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <p v-else class="text-sm text-gray-500 dark:text-gray-400">
                Connectez votre compte Battle.net pour gérer vos personnages.
            </p>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

import type { WowChar, WowInstance } from '@/types/wow';

type ApiChar = {
    blizzard_id: number;
    name: string;
    realm_slug: string;
    realm_name: string;
    class_name: string;
    level: number;
    avatar_url: string;
};

const props = defineProps<{
    blizzardConnected: boolean;
    wowCharacters: WowChar[];
    wowInstances: Record<number, WowInstance>;
}>();

const showPicker       = ref(false);
const availableCharacters = ref<ApiChar[]>([]);
const loadingCharacters   = ref(false);
const apiError            = ref('');

const savedBlizzardIds = computed(() => new Set(props.wowCharacters.map(c => c.blizzard_id)));

const openCharacter = ref<number | null>(null);
function toggleCharacter(id: number) {
    openCharacter.value = openCharacter.value === id ? null : id;
}


const unsavedCharacters = computed(() =>
    availableCharacters.value.filter(c => !savedBlizzardIds.value.has(c.blizzard_id))
);

const CLASS_COLORS: Record<string, string> = {
    // Français
    'Guerrier': '#C69B3A', 'Paladin': '#F48CBA', 'Chasseur': '#AAD372',
    'Voleur': '#FFF468', 'Prêtre': '#FFFFFF', 'Chevalier de la mort': '#C41E3A',
    'Chaman': '#0070DD', 'Mage': '#3FC7EB', 'Démoniste': '#8788EE',
    'Moine': '#00FF98', 'Druide': '#FF7C0A', 'Chasseur de démons': '#A330C9',
    'Évocateur': '#33937F',
    // Anglais (fallback)
    'Warrior': '#C69B3A', 'Hunter': '#AAD372', 'Rogue': '#FFF468',
    'Priest': '#FFFFFF', 'Death Knight': '#C41E3A', 'Shaman': '#0070DD',
    'Warlock': '#8788EE', 'Monk': '#00FF98', 'Druid': '#FF7C0A',
    'Demon Hunter': '#A330C9', 'Evoker': '#33937F',
};

function classColor(className: string): string {
    return CLASS_COLORS[className] ?? '#9CA3AF';
}

const SLOT_NAMES: Record<string, string> = {
    HEAD: 'Tête', NECK: 'Cou', SHOULDER: 'Épaules', BACK: 'Dos',
    CHEST: 'Torse', SHIRT: 'Chemise', TABARD: 'Tabard', WRIST: 'Poignets',
    HANDS: 'Mains', WAIST: 'Taille', LEGS: 'Jambes', FEET: 'Pieds',
    FINGER_1: 'Anneau 1', FINGER_2: 'Anneau 2',
    TRINKET_1: 'Bijou 1', TRINKET_2: 'Bijou 2',
    MAIN_HAND: 'Main droite', OFF_HAND: 'Main gauche',
    RANGED: 'À distance',
};

function slotName(slot: string): string {
    return SLOT_NAMES[slot] ?? slot.replace(/_/g, ' ').toLowerCase();
}

function raidName(raid: { instance_id: number | null; name: string }): string {
    if (raid.instance_id && props.wowInstances[raid.instance_id]) {
        const instance = props.wowInstances[raid.instance_id];
        return instance.name_fr ?? instance.name_en;
    }
    return raid.name;
}

async function togglePicker() {
    showPicker.value = !showPicker.value;
    if (showPicker.value && availableCharacters.value.length === 0) {
        await fetchCharacters();
    }
}

async function fetchCharacters() {
    loadingCharacters.value = true;
    apiError.value = '';
    try {
        const res = await fetch(route('wow.characters.available'), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        if (!res.ok) throw new Error('Erreur API');
        availableCharacters.value = await res.json();
    } catch {
        apiError.value = 'Impossible de récupérer les personnages depuis Battle.net.';
    } finally {
        loadingCharacters.value = false;
    }
}

const addForm = useForm<ApiChar & { [key: string]: any }>({
    blizzard_id: 0, name: '', realm_slug: '', realm_name: '', class_name: '', level: 0, avatar_url: '',
});

function addCharacter(char: ApiChar) {
    Object.assign(addForm, char);
    addForm.post(route('wow.characters.store'), {
        preserveScroll: true,
    });
}

function removeCharacter(id: number) {
    router.delete(route('wow.characters.destroy', id), { preserveScroll: true });
}

function refreshCharacter(id: number) {
    router.post(route('wow.characters.refresh', id), {}, { preserveScroll: true });
}
</script>
