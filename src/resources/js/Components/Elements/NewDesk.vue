<template>
    <div class="desk" @click="fireClick">
        +
    </div>
</template>

<script>
    export default {
        name: "NewDesk",
        methods: {
            fireClick() {
                this.$emit('adding-new-desk');
            }
        }
    }
</script>

<style lang="scss" scoped>
    .desk {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
