<template>
    <div class="grid grid-cols-2">
        <div>
            <dl class="">
                <dt class="font-semibold text-gray-900 dark:text-white">Pseudo</dt>
                <dd class="text-gray-500 dark:text-gray-400">Test</dd>
            </dl>
            <dl class="">
                <dt class="font-semibold text-gray-900 dark:text-white">Email</dt>
                <dd class="text-gray-500 dark:text-gray-400">test@example.com</dd>
            </dl>
            <dl class="">
                <dt class="font-semibold text-gray-900 dark:text-white">Inscrit le</dt>
                <dd class="text-gray-500 dark:text-gray-400">01/01/2025 10:00</dd>
            </dl>
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Date de dernière modification : 01/02/2025 15:00
        </div>
        <!-- TODO mettre un bouton changement de pseudo + formulaire changement de mdp -->
        <div class="col-span-2">
            <button type="button" class="mr-5 float-right px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Editer
            </button>
        </div>
    </div>
</template>

<script setup>

</script>
