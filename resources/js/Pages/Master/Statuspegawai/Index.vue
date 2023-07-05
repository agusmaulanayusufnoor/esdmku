<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
    mdiAccountKey,
    mdiPlus,
    mdiSquareEditOutline,
    mdiTrashCan,
    mdiAlertBoxOutline,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import BaseButton from "@/Components/BaseButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButtons from "@/Components/BaseButtons.vue"
import NotificationBar from "@/Components/NotificationBar.vue"
import Pagination from "@/Components/Admin/Pagination.vue"
import Sort from "@/Components/Admin/Sort.vue"
import Swal from 'sweetalert2'

// const Swal = require('sweetalert2')

const props = defineProps({
    statuspegawais: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})
// console.log(props.statuspegawais.data);
const form = useForm({
    search: props.filters.search,
})

const formDelete = useForm({})

function destroy(id) {

    Swal.fire({
        title: 'Data Status Pegawai Mau Dihapus?',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        confirmButtonColor: '#3085d6',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#d33',
        customClass: {
            actions: 'my-actions',
            cancelButton: 'order-1 right-gap',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            formDelete.delete(route("statuspegawai.destroy", id))
            Swal.fire('OK dihapus!', '', 'success')
        }
    })
}
</script>

<template>
    <LayoutAuthenticated>

        <Head title="status pegawai" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiAccountKey" title="Daftar status pegawai" main>

                <BaseButton v-if="can.delete" :route-name="route('statuspegawai.create')" :icon="mdiPlus" label="Add" color="info"
                    rounded-full small />
            </SectionTitleLineWithButton>
            <NotificationBar v-if="$page.props.flash.message" color="success" :icon="mdiAlertBoxOutline">
                {{ $page.props.flash.message }}
            </NotificationBar>
            <CardBox class="mb-6" has-table>
                <form @submit.prevent="form.get(route('statuspegawai.index'))">
                    <div class="py-2 flex">
                        <div class="flex pl-8">
                            <input type="search" v-model="form.search" class="
                  rounded-md
                  shadow-sm
                  border-gray-300
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " placeholder="Search" />
                            <BaseButton label="Search" type="submit" color="info"
                                class="ml-4 inline-flex items-center px-4 py-2" />
                        </div>
                    </div>
                </form>
            </CardBox>
            <CardBox class="mx-auto max-w-max" has-table>
                <table>
                    <thead>
                        <tr>
                            <th>
                                <Sort label="Status Pegawai" attribute="statuspegawai" />
                            </th>
                            <th v-if="can.edit || can.delete">Ubah|Hapus</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="statuspegawai in statuspegawais.data" :key="statuspegawai.id">

                            <td data-label="Nama Status Pegawai">

                                <Link :href="route('statuspegawai.show', statuspegawai.id)" class="
                    no-underline
                    hover:underline
                    text-cyan-600
                    dark:text-cyan-400
                  ">
                                {{ statuspegawai.statuspegawai }}
                                </Link>
                            </td>
                            <td v-if="can.edit || can.delete" class="before:hidden lg:w-1 whitespace-nowrap">
                                <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                    <BaseButton v-if="can.edit" :route-name="route('statuspegawai.edit', statuspegawai.id)" color="info"
                                        :icon="mdiSquareEditOutline" small />
                                    <BaseButton v-if="can.delete" color="danger" :icon="mdiTrashCan" small
                                        @click="destroy(statuspegawai.id)" />
                                </BaseButtons>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="py-4">
                    <Pagination :data="statuspegawais" />
                </div>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
