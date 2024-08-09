<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import draggable from 'vuedraggable';
import axios from 'axios';
import GridView from "@/Pages/Grids/components/GridView.vue";

const showModal = ref(false); // Control modal visibility
const newColumnName = ref(''); // To store the new column name

const { props } = usePage();
const stages = ref(props.stages);
const zones = ref(props.zones);
const gridId = ref(props.grid_id); // Added to get grid_id from props
const {grid} = props;

const columns = ref(stages.value.map(stage => ({
    id: stage.id,
    name: stage.name,
    status: stage.slug
})));

const tasks = ref([]);

// Populate tasks from zones actions
zones.value.forEach(zone => {
    zone.actions.forEach((action, index) => {
        if (action.kanban_status) {
            tasks.value.push({
                id: action.id,
                title: action.name ? action.name : `Action ${index + 1}`,
                status: action.kanban_status ? action.kanban_status : 'to-schedule'
            });
        }
    });
});

const getColumnTasks = (status) => computed(() => tasks.value.filter(task => task.status === status));

const onTaskDrop = async (event) => {
    console.log('Drop Event:', event);
    const { newIndex, oldIndex, to, from, item } = event;

    const newStatus = to ? to.closest('[data-status]')?.getAttribute('data-status') : null;
    const oldStatus = from ? from.closest('[data-status]')?.getAttribute('data-status') : null;

    if (!newStatus || !oldStatus) {
        console.error('Dropped element does not have a valid status');
        return;
    }

    if (!item || !item.__draggable_context) {
        console.error('Dropped item is undefined');
        return;
    }

    const taskElement = item.__draggable_context.element;

    if (!taskElement || !taskElement.id) {
        console.error('Dropped element is undefined or does not have an id');
        return;
    }

    const task = tasks.value.find(task => task.id === taskElement.id);
    if (task) {
        task.status = newStatus;

        const taskIndex = tasks.value.indexOf(task);
        tasks.value.splice(taskIndex, 1);
        tasks.value.splice(newIndex, 0, task);

        try {
            await axios.post('/kanban/tasks/update-status', {
                taskId: task.id,
                kanbanStatus: newStatus
            });
            console.log('Status updated successfully');
        } catch (error) {
            console.error('Failed to update status:', error);
        }
    }

    console.log('Updated Tasks:', tasks.value);
};

const updateColumnName = async (column) => {
    try {
        await axios.post('/kanban/stages/update-name', {
            stageId: column.id,
            name: column.name
        });
        console.log('Column name updated successfully');
    } catch (error) {
        console.error('Failed to update column name:', error);
    }
};

const addNewColumn = async () => {
    if (newColumnName.value) {
        try {
            const response = await axios.post('/kanban/stages/create', {
                name: newColumnName.value,
                grid_id: gridId.value // Use the grid_id from props
            });
            columns.value.push({
                id: response.data.id,
                name: response.data.name,
                status: response.data.slug
            });
            console.log('Column created successfully');
            newColumnName.value = ''; // Clear the input after adding
        } catch (error) {
            console.error('Failed to create column:', error);
        }
    }
    showModal.value = false; // Close the modal after adding the column
};

const addNewTask = (status) => {
    const newTask = {
        id: tasks.value.length ? tasks.value[tasks.value.length - 1].id + 1 : 1,
        title: `Task ${tasks.value.length + 1}`,
        status: status,
    };
    tasks.value.push(newTask);
};

const deleteColumn = async (column) => {
    const tasksInColumn = getColumnTasks(column.status).value;

    if (tasksInColumn.length > 0) {
        console.error('Cannot delete column with tasks.');
        return;
    }

    try {
        await axios.post('/kanban/stages/delete', {
            stageId: column.id
        });

        const columnIndex = columns.value.indexOf(column);
        if (columnIndex > -1) {
            columns.value.splice(columnIndex, 1);
        }

        console.log('Column deleted successfully');
    } catch (error) {
        console.error('Failed to delete column:', error);
    }
};

</script>

<template>
    <Head title="Kanban" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kanban</h2>
        </template>

        <div class="mx-auto sm:px-6 lg:px-8 p-5">
            <div v-if="grid" class="shadow-sm sm:rounded-lg bg-white p-2 w-fit">
                <grid-view :data="grid"/>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2">Kanban Board</h2>
                    </div>
                    <div class="text-right p-4">
                        <button @click="showModal = true" class="bg-blue-500 text-white p-2 rounded">+ Add Column</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex space-x-4">
                    <div
                        v-for="column in columns"
                        :key="column.status"
                        class="w-1/3 bg-gray-200 p-4 rounded"
                        :data-status="column.status"
                    >
                        <div class="flex justify-between items-center mb-4">
                            <input
                                type="text"
                                class="font-semibold text-lg bg-transparent border-none"
                                v-model="column.name"
                                @blur="updateColumnName(column)"
                                @keydown.enter.prevent="updateColumnName(column)"
                            />
                            <!-- <button @click="addNewTask(column.status)" class="bg-blue-500 text-white p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button> -->

                            <div>
                                <!-- Add the delete button -->
                                <button
                                    @click="deleteColumn(column)"
                                    v-if="getColumnTasks(column.status).value.length === 0" 
                                    class="bg-red-500 text-white p-2 rounded">
                                    Delete
                                </button>
                            </div>
                        </div>
                        <draggable 
                            :list="getColumnTasks(column.status).value" 
                            group="tasks" 
                            @end="onTaskDrop"
                            itemKey="id"
                            class="min-h-[50px]"
                        >
                            <template #item="{ element }">
                                <div 
                                    class="bg-white p-2 mb-2 rounded shadow"
                                >
                                    {{ element.title }}
                                </div>
                            </template>
                            <template #footer>
                                <div v-if="getColumnTasks(column.status).value.length === 0" class="h-10"></div>
                            </template>
                        </draggable>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Add New Column
                                </h3>
                                <div class="mt-2">
                                    <input
                                        v-model="newColumnName"
                                        type="text"
                                        class="border p-2 rounded w-full"
                                        placeholder="Enter column name"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="addNewColumn" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Add Column
                        </button>
                        <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style>
.draggable {
    min-height: 300px;
}
input {
    display: block;
    width: 100%;
    padding: 0;
    margin: 0;
    border: none;
    background: none;
}
input:focus {
    outline: none;
    border-bottom: 1px solid #000;
}
</style>
