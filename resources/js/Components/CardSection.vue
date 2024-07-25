<script setup>
const {heading} = defineProps(['heading']);

</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <section class="max-w-xl">
            <header v-if="heading">
                <h2 class="text-lg font-medium text-gray-900">{{ heading }}</h2>
            </header>
            <slot/>
        </section>
    </div>
</template>

<style scoped>

</style>
