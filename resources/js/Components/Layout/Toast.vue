<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-4"
    >
        <div
            v-if="visible"
            class="fixed bottom-5 right-5 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert"
        >
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg"
                :class="styles.icon">
                <svg v-if="type === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <svg v-else-if="type === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
            </div>
            <div class="ms-3 text-sm font-normal">{{ message }}</div>
            <button
                @click="visible = false"
                type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            >
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const visible = ref(false);
const message = ref('');
const type = ref<'success' | 'error'>('success');
let timer: ReturnType<typeof setTimeout>;

const styles = computed(() => ({
    icon: type.value === 'success'
        ? 'bg-green-100 text-green-500 dark:bg-green-800 dark:text-green-200'
        : 'bg-red-100 text-red-500 dark:bg-red-800 dark:text-red-200',
}));

watch(
    () => page.props.flash,
    (flash: any) => {
        if (flash?.success) {
            show(flash.success, 'success');
        } else if (flash?.error) {
            show(flash.error, 'error');
        }
    },
    { deep: true }
);

function show(msg: string, t: 'success' | 'error' = 'success') {
    message.value = msg;
    type.value = t;
    visible.value = true;
    clearTimeout(timer);
    timer = setTimeout(() => { visible.value = false; }, 4000);
}
</script>
