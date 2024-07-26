<script setup>

import {FwbInput} from "flowbite-vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GridLegend from "@/Pages/Grids/components/GridLegend.vue";
import ZoneActionsGrid from "@/Pages/Grids/components/ZoneActionsGrid.vue";
import CardSection from "@/Components/CardSection.vue";
import {useGrid} from "@/Pages/Grids/store/useGrid.js";
import {storeToRefs} from "pinia";

const store = useGrid();
const {form, zone} = storeToRefs(store);
const {setStep, setZone} = store;

</script>

<template>
    <card-section class="max-w-2xl mx-auto">
        <zone-actions-grid :data="form.zones[zone-1]" :zone="zone"/>
        <grid-legend :zone="zone"/>
        <div>
            <h2 class="text-center font-semibold text-lg mb-3">REVIEW AND EDIT GENERATED ACTIONS FOR ZONE 1 OF 8</h2>
            <p class="text-center mb-3">Review and edit the actions needed to achieve this zone. These will be added to
                the
                corresponding section of
                your Yadder.</p>

            <!-- Zone name input -->
            <fwb-input
                v-model="form.zones[zone-1].name"
                class="w-full block mb-3"
                :placeholder="`Zone ${zone}` "
            />

            <!-- actions input -->
            <fwb-input
                v-for="i in form.zones[zone-1].actions.length"
                v-model="form.zones[zone-1].actions[i-1].name"
                class="w-full block mb-3"
                :placeholder="`Action ${i}`"
            />

            <div class="flex justify-between">
                <primary-button v-if="zone === 1" role="button" type="button" @click.prevent="setStep(1)"> Previous
                </primary-button>
                <primary-button v-else role="button" type="button" @click.prevent="setZone(zone-1)"> Previous Zone
                </primary-button>

                <primary-button v-if="zone<8" role="button" type="button" @click.prevent="setZone(zone+1)"> Next Zone
                </primary-button>
                <primary-button v-else role="button" type="button" @click.prevent="setStep(3)"> Preview Grid
                </primary-button>
            </div>
        </div>
    </card-section>
</template>

<style scoped>

</style>
