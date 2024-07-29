<script setup>
const {action, isTitle} = defineProps(['action', 'isTitle'])
</script>

<template>
    <td class="max-w-1/3">
        <div class="p-5 text-center border rounded-lg min-w-[200px] h-[100px]"
             :class="{'bg-gray-100 font-semibold': isTitle}"
        >
            {{ action }}
        </div>
    </td>
</template>

<style scoped>

</style>
