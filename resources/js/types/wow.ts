export type WowStat = {
    item_level: number | null;
    stamina: number | null;
    strength: number | null;
    agility: number | null;
    intellect: number | null;
    critical_strike: number | null;
    haste: number | null;
    mastery: number | null;
    versatility: number | null;
};

export type WowEquipmentSlot = {
    slot: string;
    item_id: number;
    enchantments: number[];
    gems: number[];
};

export type WowRaid = {
    instance_id: number | null;
    name: string;
    normal: { completed: number; total: number };
    heroic: { completed: number; total: number };
    mythic: { completed: number; total: number };
};

export type WowInstance = {
    blizzard_id: number;
    name_en: string;
    name_fr: string | null;
    expansion_id: number | null;
    expansion_name_en: string | null;
    expansion_name_fr: string | null;
    season: string | null;
};

export type WowChar = {
    id: number;
    blizzard_id: number;
    name: string;
    realm_name: string;
    class_name: string;
    level: number;
    avatar_url: string;
    can_refresh: boolean;
    last_refreshed_at: string | null;
    stats: WowStat | null;
    equipment: WowEquipmentSlot[] | null;
    pve_progression: WowRaid[] | null;
};
