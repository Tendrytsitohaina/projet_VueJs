<template>
    <Transition name="fade">
        <slot></slot>
    </Transition>
</template>

<script setup>

</script>
<style>

.fade-enter-active, .fade-leave-active{
  transition: transform 0.5s ease, opacity 0.5s ease;
}
.fade-enter-from{
  transform: translateY(100%);
  opacity: 0;
}
.fade-enter-to{
  opacity: 1;
}
.fade-leave-from{
  
  opacity: 1;
}
.fade-leave-to{
  transform: translateY(100%);
  opacity: 0;
}

</style>