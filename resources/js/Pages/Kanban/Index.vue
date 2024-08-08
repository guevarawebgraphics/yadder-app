<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import draggable from 'vuedraggable';
import axios from 'axios';

const { props } = usePage();
const stages = ref(props.stages);
const zones = ref(props.zones);
const gridId = ref(props.grid_id); // Added to get grid_id from props

const columns = ref(stages.value.map(stage => ({
    id: stage.id,
    name: stage.name,
    status: stage.slug
})));

const tasks = ref([]);

// Populate tasks from zones actions
zones.value.forEach(zone => {
    zone.actions.forEach((action, index) => {
        tasks.value.push({
            id: action.id,
            title: action.name ? action.name : `Action ${index + 1}`,
            status: action.kanban_status ? action.kanban_status : 'to-schedule'
        });
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
    const columnName = prompt('Enter column name:');
    if (columnName) {
        try {
            const response = await axios.post('/kanban/stages/create', {
                name: columnName,
                grid_id: gridId.value // Use the grid_id from props
            });
            columns.value.push({
                id: response.data.id,
                name: response.data.name,
                status: response.data.slug
            });
            console.log('Column created successfully');
        } catch (error) {
            console.error('Failed to create column:', error);
        }
    }
};

const addNewTask = (status) => {
    const newTask = {
        id: tasks.value.length ? tasks.value[tasks.value.length - 1].id + 1 : 1,
        title: `Task ${tasks.value.length + 1}`,
        status: status,
    };
    tasks.value.push(newTask);
};
</script>

<template>
    <Head title="Kanban" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kanban</h2>
        </template>

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
                    <!-- Add new column button -->
                    <div class="w-1/3 bg-gray-200 p-4 rounded flex justify-center items-center">
                        <button @click="addNewColumn" class="bg-blue-500 text-white p-2 rounded">+ Add Column</button>
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
