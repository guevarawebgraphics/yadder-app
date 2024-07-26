import {defineStore} from 'pinia';
import {useForm} from "@inertiajs/vue3";

export const useGrid = defineStore('gridForm', {
    state: () => ({
        form: useForm({
            name: '',
            useAi: false,
            zones: [
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
                {
                    name: '',
                    actions: [
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                        {name: ''},
                    ]
                },
            ],
        }),
        zone: 1,
        step: 1,
        loading: false,
    }),
    actions: {
        submitForm() {
            this.form.post(route('grids.store'), {
                onSuccess: () => {
                    console.log('Form submitted successfully!');
                },
                onError: () => {
                    console.error('There was an error submitting the form.');
                },
            });
        },
        updateForm(key, value) {
            this.form[key] = value;
        },
        updateNestedForm(index, key, value) {
            this.form.zones[index][key] = value;
        },
        updateAction(index, actionIndex, key, value) {
            this.form.zones[index].actions[actionIndex][key] = value;
        },
        setZone(value) {
            this.zone = value
        },
        setStep(value) {
            if (!this.validateForm()) return

            this.step = value
        },
        validateForm() {

            if (!this.form.name.length) {
                this.form.errors.name = 'Please enter your grid name!';

                return false;
            }

            return true
        }
    },
    getters: {
        zoneName(state) {
            return state.form.zones[state.zone - 1]?.name?.length ? state.form.zones[state.zone - 1].name : `Zone ${state.zone}`
        },
        actionName: (state) => {
            return (key) => state.form.zones[state.zone - 1]?.actions[key - 1]?.name?.length ? state.form.zones[state.zone - 1].actions[key - 1].name : `Action ${key}`
        },
        getZoneNameByKey: (state) => {
            return (key) => state.form.zones[key - 1]?.name?.length ? state.form.zones[key - 1].name : `Zone ${key}`
        }
    },
});
