<template>
    <button class="desk" @click="addNewDesk">
        <span class="desk__body">

        </span>
    </button>
</template>

<script>
    export default {
        name: "NewDesk",
        methods: {
            addNewDesk() {
                console.log('adding new desk')
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "./packages/laurel/kanban/src/resources/scss/page.scss";
</style>
