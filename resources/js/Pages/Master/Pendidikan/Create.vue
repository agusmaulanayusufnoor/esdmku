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
  nama_pendidikan: '',
})
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Tambah Pendidikan" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiAccountKey"
        title="Tambah Pendidikan"
        main
      >
        <BaseButton
          :route-name="route('pendidikan.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <CardBox
        form
        @submit.prevent="form.post(route('pendidikan.store'))"
      >

        <FormField
          label="Pendidikan"
          :class="{ 'text-red-400': form.errors.nama_pendidikan }"
        >
          <FormControl
            v-model="form.nama_pendidikan"
            type="text"
            placeholder="Masukan Pendidikan"
            :error="form.errors.nama_pendidikan"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.nama_pendidikan">
              {{ form.errors.nama_pendidikan }}
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
