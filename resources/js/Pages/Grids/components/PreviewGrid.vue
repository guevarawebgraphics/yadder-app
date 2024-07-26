<script setup>
import CardSection from "@/Components/CardSection.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GridView from "@/Pages/Grids/components/GridView.vue";
import {useGrid} from "@/Pages/Grids/store/useGrid.js";
import {storeToRefs} from "pinia";

const store = useGrid();
const {setStep, submitForm} = store;

const {form} = storeToRefs(store);

</script>

<template>
    <card-section class="w-fit mx-auto">

        <div>
            <h2 class="text-center font-semibold text-lg mb-3">REVIEW AND EDIT YOUR FINAL YADDER</h2>
            <p class="text-center mb-3">Review the entire Yadder. You can make any final adjustments before saving.</p>
        </div>

        <!--TODO: Change to grid title-->
        <grid-view :data="form"/>

        <div class="flex justify-between mt-3">
            <primary-button role="button" @click.prevent="setStep(2)"> Previous</primary-button>
            <primary-button role="button" type="button" @click.prevent="submitForm"> Save</primary-button>
        </div>
    </card-section>

</template>

<style scoped>

</style>
