<script setup>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ZoneFormEdit from "@/Pages/Grids/components/ZoneFormEdit.vue";

</script>

<template>
    <Head title="Edit zone "/>

    <AuthenticatedLayout>
        <zone-form-edit/>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
