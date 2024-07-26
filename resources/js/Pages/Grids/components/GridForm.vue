<script setup>

import {FwbCheckbox, FwbInput} from "flowbite-vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CardSection from "@/Components/CardSection.vue";
import {useGrid} from "@/Pages/Grids/store/useGrid.js";
import {storeToRefs} from "pinia";

const store = useGrid();

const {setStep} = store;

const {form} = storeToRefs(store);

</script>

<template>
    <card-section class="max-w-2xl mx-auto">
        <h2 class="text-2xl mb-3 font-medium text-gray-900 text-center">Create Grid</h2>

        <fwb-input
            class="w-full block"
            :class="{'mb-2': !form.errors.name}"
            v-model="form.name"
            placeholder="Enter Grid name"
            label="Grid Name"
        />
        <small class="text-red-500 mb-3 block" v-if="form.errors.name">{{ form.errors.name }}</small>
        <fwb-checkbox class="mb-5" v-model="form.useAi"
                      label="Use AI to assist in creating your radder"/>

        <div class="flex justify-items-end">
            <PrimaryButton @click.prevent="setStep(2)" type="button" role="button" class="ml-auto"
                           :disabled="form.processing">Next
            </PrimaryButton>
        </div>
    </card-section>
</template>

<style scoped>

</style>
