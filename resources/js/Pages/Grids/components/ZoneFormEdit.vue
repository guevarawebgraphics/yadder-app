<script setup>

import {FwbInput} from "flowbite-vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GridLegend from "@/Pages/Grids/components/GridLegend.vue";
import ZoneActionsGrid from "@/Pages/Grids/components/ZoneActionsGrid.vue";
import CardSection from "@/Components/CardSection.vue";
import {useGrid} from "@/Pages/Grids/store/useGrid.js";
import {usePage} from "@inertiajs/vue3";
import {storeToRefs} from "pinia";

const {props} = usePage()

const {zone: zoneProp} = props;

const store = useGrid();

const {submitZoneUpdateForm, setZoneForm} = store;

setZoneForm(zoneProp)

const {zoneForm} = storeToRefs(store);

const zone = parseInt(zoneProp.key) + 1;

</script>

<template>
    <card-section class="max-w-2xl mx-auto">
        <zone-actions-grid :data="zoneForm" :zone="zone"/>
        <grid-legend :zone="zone"/>
        <div>
            <form @submit.prevent="submitZoneUpdateForm">

                <h2 class="text-center font-semibold text-lg mb-3">REVIEW AND EDIT GENERATED ACTIONS FOR ZONE 1 OF
                    8</h2>
                <p class="text-center mb-3">Review and edit the actions needed to achieve this zone. These will be added
                    to
                    the
                    corresponding section of
                    your Yadder.</p>

                <!-- Zone name input -->
                <fwb-input
                    v-model="zoneForm.name"
                    class="w-full block "
                    :class="{'mb-3': !zoneForm.errors.name}"
                    :placeholder="`Zone ${zone}` "
                />
                <small class="text-red-500 mb-3 block" v-if="zoneForm.errors.name">{{ zoneForm.errors.name }}</small>

                <!-- actions input -->
                <fwb-input
                    v-for="i in zoneForm.actions.length"
                    v-model="zoneForm.actions[i-1].name"
                    class="w-full block mb-3"
                    :placeholder="`Action ${i}`"
                />

                <div class="flex justify-end gap-2">

                    <primary-button type="submit"> Save Changes
                    </primary-button>
                </div>

            </form>
        </div>
    </card-section>
</template>

<style scoped>

</style>
