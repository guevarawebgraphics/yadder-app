<script setup>

import ZoneActionsGrid from "@/Pages/Grids/components/ZoneActionsGrid.vue";

const {
    data,
} = defineProps(['data'])

</script>

<template>
    <table class="table w-full border-separate">
        <tbody>
        <tr>
            <td>
                <zone-actions-grid :data="data.zones[0]" zone="1"/>
            </td>
            <td>
                <zone-actions-grid :data="data.zones[1]" zone="2"/>
            </td>
            <td>
                <zone-actions-grid :data="data.zones[2]" zone="3"/>
            </td>
        </tr>
        <tr>
            <td>
                <zone-actions-grid :data="data.zones[7]" zone="8"/>
            </td>
            <td class="font-semibold bg-gray-100 text-lg text-center rounded-xl border ">
                {{ data.name.length ? data.name : 'MAIN GOAL' }}
            </td>
            <td>
                <zone-actions-grid :data="data.zones[3]" zone="4"/>
            </td>
        </tr>
        <tr>
            <td>
                <zone-actions-grid :data="data.zones[6]" zone="7"/>
            </td>
            <td>
                <zone-actions-grid :data="data.zones[5]" zone="6"/>
            </td>
            <td>
                <zone-actions-grid :data="data.zones[4]" zone="5"/>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
