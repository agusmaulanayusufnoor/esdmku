<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
  mdiAccountKey,
  mdiArrowLeftBoldOutline
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'


const form = useForm({
  statuspegawai: '',
})
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Tambah Status Pegawai" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiAccountKey"
        title="Tambah Status Pegawai"
        main
      >
        <BaseButton
          :route-name="route('statuspegawai.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <CardBox
        form
        @submit.prevent="form.post(route('statuspegawai.store'))"
      >

        <FormField
          label="Status pegawai"
          :class="{ 'text-red-400': form.errors.statuspegawai }"
        >
          <FormControl
            v-model="form.statuspegawai"
            type="text"
            placeholder="Masukan Status pegawai"
            :error="form.errors.statuspegawai"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.statuspegawai">
              {{ form.errors.statuspegawai }}
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
