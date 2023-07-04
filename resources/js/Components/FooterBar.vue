<script setup>
import { computed } from 'vue'
import { containerMaxW } from '@/config.js';
import BaseLevel from '@/Components/BaseLevel.vue'
import JustboilLogo from '@/Components/JustboilLogo.vue'

const year = computed(() => new Date().getFullYear())
</script>

<template>
  <footer class="py-2 px-6 fixed inset-x-30 bottom-0">
    <BaseLevel :class="containerMaxW">
      <div class="text-center md:text-left">
        <b>SUGA&copy;{{ year }}, <a
          href="https://bprku.com/"
          target="_blank"
        >bprku.com</a></b>

      </div>
      <div class="md:py-2">
        <!-- <a href="https://justboil.me">
          <JustboilLogo class="w-auto h-8 md:h-6" />
        </a> -->
      </div>
    </BaseLevel>
  </footer>
</template>
