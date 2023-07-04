<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
  mdiArrowLeftBoldOutline,
mdiOfficeBuildingCog
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'

const props = defineProps({
  jabatan: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  _method: 'put',
  nama_jabatan: props.jabatan.nama_jabatan
})
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Update Jabatan" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiOfficeBuildingCog"
        title="Update Jabatan"
        main
      >
        <BaseButton
          :route-name="route('jabatan.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <CardBox
        form
        @submit.prevent="form.post(route('jabatan.update', props.jabatan.id))"
      >

        <FormField
          label="Nama Jabatan"
          :class="{ 'text-red-400': form.errors.nama_jabatan }"
        >
          <FormControl
            v-model="form.nama_jabatan"
            type="text"
            placeholder="Masukan Nama Jabatan"
            :error="form.errors.nama_jabatan"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.nama_jabatan">
              {{ form.errors.nama_jabatan }}
            </div>
          </FormControl>
        </FormField>

        <template #footer>
          <BaseButtons>
            <BaseButton
              type="submit"
              color="info"
              label="Submit"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            />
          </BaseButtons>
        </template>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
