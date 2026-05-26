<template>
    <AppLayout>
        <HeroSection
            title="Bienvenue sur Gaming Hub"
            subtitle="Découvrez les meilleurs streamers, guides de jeux, et les réalisations de notre communauté."
            ctaLink="#guides"
            ctaText="Explorez les Guides"
            backgroundImage="/hero-bg.jpg"
        />
        <StreamersSection
            title="Streamers en vedette"
            :streamers="streamers"
        />
        <GuidesSection
            title="Guides de jeu"
            :guides="guides"
        />
        <AchievementsSection
            title="Réalisations des utilisateurs"
            :achievements="achievements"
        />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import HeroSection from '@/Components/Homepage/HeroSection.vue';
import StreamersSection from '@/Components/Homepage/StreamersSection.vue';
import GuidesSection from '@/Components/Homepage/GuidesSection.vue';
import AchievementsSection from '@/Components/Homepage/AchievementsSection.vue';

interface Streamer {
    name: string
    image: string
    description: string
}

interface Guide {
    title: string
    description: string
    link: string
}

interface Achievement {
    title: string
    description: string
}

const streamers: Streamer[] = [
    { name: 'Streamer 1', image: '/streamer1.jpg', description: 'Joueur pro et expert en FPS.' },
    { name: 'Streamer 2', image: '/streamer2.jpg', description: 'Streamer de jeux d\'aventure.' },
    { name: 'Streamer 3', image: '/streamer3.jpg', description: 'Expert en jeux de stratégie.' },
];

const guides: Guide[] = [
    {
        title: 'Guide pour le jeu XYZ',
        description: 'Tout ce qu\'il faut savoir pour maîtriser le jeu XYZ.',
        link: '#'
    },
    {
        title: 'Guide pour le jeu ABC',
        description: 'Conseils essentiels et astuces pour dominer dans le jeu ABC.',
        link: '#'
    },
    {
        title: 'Guide pour le jeu DEF',
        description: 'Analyse approfondie et tactiques pour exceller dans DEF.',
        link: '#'
    },
];

const achievements: Achievement[] = [
    {
        title: 'Utilisateur 1',
        description: 'A atteint le niveau 50 dans XYZ avec des statistiques impressionnantes !'
    },
    {
        title: 'Utilisateur 2',
        description: 'A remporté le tournoi ABC avec une performance incroyable.'
    },
    {
        title: 'Utilisateur 3',
        description: 'Premier à terminer le jeu DEF en mode difficile. Bravo !'
    },
];
</script>
