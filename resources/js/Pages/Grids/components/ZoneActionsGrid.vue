<script setup>
import Action from "@/Pages/Grids/components/Action.vue";
import ZoneRow from "@/Pages/Grids/components/ZoneRow.vue";

const {data, zone} = defineProps(['data', 'zone']);

const getName = (i) => {
    return data.actions[i - 1].name?.length ? data.actions[i - 1].name : 'Action ' + i;
}

const getZoneName = () => {
    return data.name?.length ? data.name : `Zone ${zone}`;
}

</script>

<template>
    <table class="w-full">
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
</template>

<style scoped>

</style>
