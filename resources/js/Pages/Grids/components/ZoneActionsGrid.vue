<script setup>
const {zone} = defineProps(['zone'])
</script>

<template>
    <table class="w-full border border-collaps">
        <tbody>
        <tr class="border">
            <td class=" p-5 text-center border"> Action 1</td>
            <td class=" p-5 text-center border"> Action 2</td>
            <td class=" p-5 text-center border"> Action 3</td>
        </tr>
        <tr class="border">
            <td class=" p-5 text-center border"> Action 8</td>
            <td class=" p-5 text-center border bg-gray-100 font-semibold"> Zone {{ zone }}</td>
            <td class=" p-5 text-center border"> Action 4</td>
        </tr>
        <tr class="border">
            <td class=" p-5 text-center border"> Action 7</td>
            <td class=" p-5 text-center border"> Action 6</td>
            <td class=" p-5 text-center border"> Action 5</td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
