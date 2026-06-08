<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
        <div class="mb-8">
            <a :href="route('home')" class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $page.props.app.name }}
            </a>
        </div>
        <div class="w-full max-w-md bg-white rounded-lg shadow dark:bg-gray-800 dark:border dark:border-gray-700 p-8">
            <slot />
        </div>
    </div>
</template>
