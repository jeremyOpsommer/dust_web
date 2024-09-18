<template>
    <header class="bg-gray-800 p-4 shadow-md">
        <nav class="container mx-auto flex items-center justify-between">
            <a href="#" class="text-3xl font-bold text-pink-500">
                <img src="https://via.placeholder.com/150" alt="Gaming Hub Logo" class="w-12 h-12 inline-block" />
                Gaming Hub
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="#streamers" class="hover:text-pink-500 transition">Streamers</a>
                <a href="#guides" class="hover:text-pink-500 transition">Guides</a>
                <a href="#achievements" class="hover:text-pink-500 transition">Réalisations</a>
            </div>
            <button @click="toggleMenu" class="md:hidden text-white text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
        <!-- Mobile Menu -->
        <div v-if="isMenuOpen" class="md:hidden fixed inset-0 bg-gray-800 bg-opacity-80 flex flex-col items-center justify-center">
            <a href="#streamers" @click="closeMenu" class="text-white text-xl py-2">Streamers</a>
            <a href="#guides" @click="closeMenu" class="text-white text-xl py-2">Guides</a>
            <a href="#achievements" @click="closeMenu" class="text-white text-xl py-2">Réalisations</a>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue';

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const closeMenu = () => {
    isMenuOpen.value = false;
};
</script>
