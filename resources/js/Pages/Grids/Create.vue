<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PreviewGrid from "@/Pages/Grids/components/PreviewGrid.vue";
import ZoneForm from "@/Pages/Grids/components/ZoneForm.vue";
import {useGrid} from "@/Pages/Grids/store/useGrid.js";
import {storeToRefs} from "pinia";
import GridForm from "@/Pages/Grids/components/GridForm.vue";

const store = useGrid();

const {form, zone, step} = storeToRefs(store);

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>

        <div class="mx-auto sm:px-6 space-y-6 py-12">
            <form @submit.prevent="form.post(route('grids.store'))">
                <grid-form v-if="step===1"/>
                <zone-form v-if="step===2"/>
                <preview-grid v-if="step===3"/>
            </form>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
