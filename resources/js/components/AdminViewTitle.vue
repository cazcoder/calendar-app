
<template>
  <button @click="fired">click me</button>
</template>

<script>
export default {
  name: "HelloWorld",
  emits: ["updatedcount"],
  setup(_,{ emit }) {

    const fired = () => {
      emit("updatedcount", 'tsting');
    };

    return {
      fired
    };
  },
};
</script>
