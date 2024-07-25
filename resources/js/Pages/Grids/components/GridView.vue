<script setup>

import ZoneActionsGrid from "@/Pages/Grids/components/ZoneActionsGrid.vue";

const {
    name
} = defineProps(['name'])

</script>

<template>
    <table class="table w-full border-collapse">
        <tbody>
        <tr>
            <td>
                <zone-actions-grid :zone="1"/>
            </td>
            <td>
                <zone-actions-grid :zone="2"/>
            </td>
            <td>
                <zone-actions-grid :zone="3"/>
            </td>
        </tr>
        <tr>
            <td>
                <zone-actions-grid :zone="8"/>
            </td>
            <td class="font-semibold bg-gray-100 text-lg text-center">{{ name }}</td>
            <td>
                <zone-actions-grid :zone="4"/>
            </td>
        </tr>
        <tr>
            <td>
                <zone-actions-grid :zone="7"/>
            </td>
            <td>
                <zone-actions-grid :zone="6"/>
            </td>
            <td>
                <zone-actions-grid :zone="5"/>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
