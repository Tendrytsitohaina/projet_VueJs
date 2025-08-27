
<template>
  <div :class="['toast', type]">{{ message }}</div>
</template>

<script setup>
defineProps(['message', 'type'])
</script>

<style>
.toast {
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  padding: 12px 24px;
  border-radius: 8px;
  color: white;
  font-weight: bold;
  z-index: 9999;
  animation: slide 0.5s ease, fadeout 0.5s ease 2.5s forwards;
}
.toast.success { background-color: #28a745; }
.toast.error { background-color: #dc3545; }

@keyframes slide {
  from { top: 0; opacity: 0; }
  to { top: 20px; opacity: 1; }
}
@keyframes fadeout {
  to { opacity: 0; top: 0; }
}
</style>
