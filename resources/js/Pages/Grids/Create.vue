<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {FwbCheckbox, FwbInput} from "flowbite-vue";
import CardSection from "@/Components/CardSection.vue";
import {ref} from "vue";
import PreviewGrid from "@/Pages/Grids/components/PreviewGrid.vue";
import SingleZoneForm from "@/Pages/Grids/components/ZoneForm.vue";

const form = useForm({
    name: '',
    useAi: false,
});

let step = ref(1);

const setStep = (value) => {
    step.value = value
}

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>

        <div class="mx-auto sm:px-6 lg:px-8 space-y-6 py-12">
            <form @submit.prevent="form.post(route('grids.store'))">
                <card-section v-if="step===1" class="max-w-2xl mx-auto">
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
                <single-zone-form v-if="step===2" :setStep="setStep" :step="step"/>
                <preview-grid v-if="step===3" :set-step="setStep" :step="step"/>
            </form>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
