<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    album:'',
    artist: '',
    gender: '',
    year: ''
});
</script>

<template>
    <Head title="Create Disc" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Disc</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="form.post(route('discs.store'))" class="mt-6 space-y-6 max-w-xl">
                        <InputLabel for="name" value="Nombre"></InputLabel>
                        <TextInput id="name" v-model="form.name" autofocus required type="text" class="mt-1 block w-full">
                        </TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>
                        <div class="mt-3">
                            <InputLabel for="artist" value="Artist" />
                            <TextInput id="artist" type="text" class="mt-1 block w-full" v-model="form.artist"
                                autocomplete="artist" />
                            <InputError class="mt-2" :message="form.errors.artist" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="album" value="Album" />
                            <TextInput id="album" type="text" class="mt-1 block w-full" v-model="form.album"
                                autocomplete="album" />
                            <InputError class="mt-2" :message="form.errors.album" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="gender" value="Gender" />
                            <TextInput id="gender" type="text" class="mt-1 block w-full" v-model="form.gender"
                                autocomplete="gender" />
                            <InputError class="mt-2" :message="form.errors.gender" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="year" value="Year" />
                            <TextInput id="year" type="text" class="mt-1 block w-full" v-model="form.year"
                                autocomplete="year" />
                            <InputError class="mt-2" :message="form.errors.year" />
                        </div>

                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Save
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>