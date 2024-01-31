<template>
    <Head title="Rol and Permission" />

    <AuthenticatedLayout>
        <template #header>
            Rol and Permission
        </template>

        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="flex w-12 items-center justify-center bg-blue-500">
                <svg class="h-6 w-6 fill-current text-white" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                </svg>
            </div>
    
            <div class="-mx-3 px-4 py-2">
                <div class="mx-3">
                    <span class="font-semibold text-blue-500">Name Role</span>
                    <p class="text-sm text-gray-600">{{ role.name }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">LIST OF PERMISSIONS FOR THE ROLE</th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="per, i in permission" :key="per.id">
                            <td class="border border-gray-400 px-4 py-4">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ per.name }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <input type="checkbox" :name="'selected[' + key + ']'" v-model="per.selected" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <form @submit.prevent="submitForm" class="mt-6 space-y-6 max-w-xl">
                    <PrimaryButton >
                        <i class="fa-solid fa-save"></i> Save
                    </PrimaryButton>
                </form>

                
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm,usePage} from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    role: { type: Object },
    permission: { type: Object },
    rolpermi: { type: Object },
});

const create = () => {
    
    for (const item of props.permission) {
        if (!item.hasOwnProperty('selected')) {
            item.selected = false;
        }
    }
}

const update = () => {
    const rolpermiIds = props.rolpermi.map(item => item.pivot.permission_id);
    for (const item of props.permission) {
        for (const id of rolpermiIds) {
        if (item.id === id) {
            item.selected = true;
            break;
      }
        
    }
    }
}

const onRolPermiUpdate = () => {
  update();
};
onMounted(() => {
    create();
    update();
    watch(() => props.rolpermi, onRolPermiUpdate);
})

const submitForm = () => {
    const form = useForm({
        permi: props.permission,
        role: props.role
    });

    form.patch(route('roles.update', props.role))

}
</script>
