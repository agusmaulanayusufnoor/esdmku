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
  kantor: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  _method: 'put',
  kode_kantor: props.kantor.kode_kantor,
  nama_kantor: props.kantor.nama_kantor
})
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Update kantor" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiOfficeBuildingCog"
        title="Update kantor"
        main
      >
        <BaseButton
          :route-name="route('kantor.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <CardBox
        form
        @submit.prevent="form.post(route('kantor.update', props.kantor.id))"
      >
      <FormField
          label="Kode Kantor"
          :class="{ 'text-red-400': form.errors.kode_kantor }"
        >
          <FormControl
            v-model="form.kode_kantor"
            type="text"
            placeholder="Masukan Kode Kantor"
            :error="form.errors.kode_kantor"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.kode_kantor">
              {{ form.errors.kode_kantor }}
            </div>
          </FormControl>
        </FormField>
        <FormField
          label="Nama Kantor"
          :class="{ 'text-red-400': form.errors.nama_kantor }"
        >
          <FormControl
            v-model="form.nama_kantor"
            type="text"
            placeholder="Masukan Nama Kantor"
            :error="form.errors.nama_kantor"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.nama_kantor">
              {{ form.errors.nama_kantor }}
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
