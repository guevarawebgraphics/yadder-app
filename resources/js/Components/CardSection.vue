<script setup>
import {useSlots} from 'vue';

const slots = useSlots();

</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <header v-if="slots.heading">
            <slot name="heading"></slot>
        </header>
        <slot/>
    </div>
</template>

<style scoped>

</style>
