<script setup>
import {router} from '@inertiajs/vue3';

import Action from "@/Pages/Grids/components/Action.vue";
import ZoneRow from "@/Pages/Grids/components/ZoneRow.vue";

const {gridId, data, zone} = defineProps({
    gridId: {
        type: Number,
        required: false,
    },
    data: Object,
    zone: Number | String
});

const getName = (i) => {
    return data.actions[i - 1].name?.length ? data.actions[i - 1].name : 'Action ' + i;
}

const getZoneName = () => {
    return data.name?.length ? data.name : `Zone ${zone}`;
}

const handleZoneEdit = () => {
    if (!gridId) {
        return;
    }

    router.visit(route('grids.zone.edit', {grid: gridId, zone: data.id}),
        {method: 'get'})
}
</script>

<template>
    <div @click.prevent="handleZoneEdit" class="rounded-lg transition duration-300" :class="{'cursor-pointer hover:shadow-primary hover:shadow': gridId}">
        <table class="w-full h-full">
            <tbody>
            <zone-row>
                <action :action="getName(1)"/>
                <action :action="getName(2)"/>
                <action :action="getName(3)"/>
            </zone-row>
            <zone-row>
                <action :action="getName(8)"/>
                <action :action="getZoneName()"
                        :is-title="true"/>
                <action :action="getName(4)"/>
            </zone-row>
            <zone-row>
                <action :action="getName(7)"/>
                <action :action="getName(6)"/>
                <action :action="getName(5)"/>
            </zone-row>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
