<template>
    <Head title="Discs" />

    <AuthenticatedLayout>
        <template #header>
            Discs
        </template>
        <div v-for="permission in userpermission" :key="permission.id">
            <div v-if="checkAndDisplay(permission)">
                <div v-if="hasCreatePermission(permission)">
                    <!-- Mostrar el div y el link solo si el permiso es "create" -->
                    <div>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="mt-3 mb-3 flex">
                                <Link :href="route('discs.create')"
                                    :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                                <i class="fa-solid fa-plus-circle"></i> Add
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="bg-white grid v-screen place-items-center table-responsive">
                
                <table id="sampleTable" class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">DISCS</th>
                            <th class="px-4 py-4">ALBUM</th>
                            <th class="px-4 py-4">ARTIST</th>
                            <th class="px-4 py-4">GENDER</th>
                            <th class="px-4 py-4">YEAR</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dis, i in discs" :key="dis.id">
                            <td class="border border-gray-400 px-4 py-4">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ dis.name }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ dis.album }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ dis.artist }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ dis.gender }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ dis.year }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <Link :href="route('discs.edit', dis.id)"
                                    :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                                <i class="fa-solid fa-edit"></i>
                                </Link>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="deleteDiscs(dis.id, dis.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <DataTable :data="discs" :columns="columns1"
                    class="w-full border border-gray-400" 
                    :options="{responsive:true, autoWidth:false}"
                    @edit="handleEditClicked"
                    @delete="handleDeleteClicked"
                    >
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">NAME</th>
                            <th class="px-2 py-2">ALBUM</th>
                            <th class="px-2 py-2">ARTIST</th>
                            <th class="px-2 py-2">ACTIONS</th>
                        </tr>
                    </thead>
                    </DataTable> -->
            </div>
        

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';
import { ref, reactive, onMounted, onUnmounted, nextTick } from 'vue';
import 'datatables.net-bs4';
import $ from 'jquery';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';


const props = defineProps({
    discs: { type: Object },
    userpermission: { type: Object }
});
const form = useForm({
    id: ''
})

const deleteDiscs = (id, name) => {
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
            form.delete(route('discs.destroy', id));
        }
    });
}

onMounted(() => {
    tabla();
})

const tabla = () => {
    nextTick(() => {
        $('#sampleTable').DataTable();
    })
    
}

//logica permisos
const foundNames = {};

const checkAndDisplay = (permission) => {
    // Verificar si el nombre ya ha sido encontrado antes
    if (foundNames[permission.name]) {
        return false; // Nombre ya encontrado, no mostrar
    }

    // Nombre no encontrado, establecerlo en el objeto y mostrar
    foundNames[permission.name] = true;
    return true;
};
const hasCreatePermission = (permission) => {
    // Verificar si hay algún rol asociado que tenga el permiso "create disc"
    return (
        permission.name === 'Create Disc'
    );
};

</script>
