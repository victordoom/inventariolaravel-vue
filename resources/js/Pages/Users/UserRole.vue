<template>
    <Head title="Rol and Permission" />

    <AuthenticatedLayout>
        <template #header>
            User and Rol
        </template>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                {{ user.name }}
                {{ role }}
                {{ userrole }}
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">NAME</th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="rol, i in role" :key="rol.id">
                            <td class="border border-gray-400 px-4 py-4">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ rol.name }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <input type="checkbox" :name="'selected[' + key + ']'" v-model="rol.selected" />
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
    user: { type: Object },
    userrole: { type: Object },
});

const create = () => {
    
    for (const item of props.role) {
        if (!item.hasOwnProperty('selected')) {
            item.selected = false;
        }
    }
}

const update = () => {
    const userroleIds = props.userrole.map(item => item.pivot.role_id);
    for (const item of props.role) {
        for (const id of userroleIds) {
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
    watch(() => props.userrole, onRolPermiUpdate);
})

const submitForm = () => {
    const form = useForm({
        //permi: props.role,
        role: props.role
    });

    form.patch(route('users.update', props.user))

}
</script>
