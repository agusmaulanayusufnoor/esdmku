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
  statuspajak: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  _method: 'put',
  statuspajak: props.statuspajak.statuspajak
})
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Update Status Pajak" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiOfficeBuildingCog"
        title="Update Status Pajak"
        main
      >
        <BaseButton
          :route-name="route('statuspajak.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <CardBox
        form
        @submit.prevent="form.post(route('statuspajak.update', props.statuspajak.id))"
      >

        <FormField
          label="Status Pajak"
          :class="{ 'text-red-400': form.errors.statuspajak }"
        >
          <FormControl
            v-model="form.statuspajak"
            type="text"
            placeholder="Masukan Status Pajak"
            :error="form.errors.statuspajak"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.statuspajak">
              {{ form.errors.statuspajak }}
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
