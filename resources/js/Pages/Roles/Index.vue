<template>
    <Head title="Rols" />

    <AuthenticatedLayout>
        <template #header>
            Rols
        </template>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="mt-3 mb-3 flex">
                <Link :href="route('roles.create')"
                    :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                <i class="fa-solid fa-plus-circle"></i> Add
                </Link>
            </div>
        </div>
        <div class="bg-white grid v-screen place-items-center table-responsive">
            <table class="table-auto border border-gray-400">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-4">#</th>
                        <th class="px-4 py-4">LIST ROLE</th>
                        <th class="px-4 py-4"></th>
                        <th class="px-4 py-4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="rol, i in roles" :key="rol.id">
                        <td class="border border-gray-400 px-4 py-4">{{ (i + 1) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ rol.name }}</td>
                        <td class="border border-gray-400 px-4 py-4">
                            <Link :href="route('roles.edit', rol.id)"
                                :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                            <i class="fa-solid fa-edit"></i>
                            </Link>
                        </td>
                        <td class="border border-gray-400 px-4 py-4">
                            <DangerButton @click="deleteRol(rol.id, rol.name)">
                                <i class="fa-solid fa-trash"></i>
                            </DangerButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';


const props = defineProps({
    roles: { type: Object },
    userpermission: { type: Object }
});
const form = useForm({
    id: ''
})

const deleteRol = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Are you sure delete ' + name + ' ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('roles.destroy', id));
        }
    });
}

</script>
