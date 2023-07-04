<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import UserAvatar from '@/Components/UserAvatar.vue'
// import { useMainStore } from "@/stores/main";
// const mainStore = useMainStore();
const userName = computed(() => usePage().props.auth.user.name)
</script>

<template>
  <UserAvatar
    :username="userName"
    api="bottts"
  />
  <!-- <slot /> -->
</template>
