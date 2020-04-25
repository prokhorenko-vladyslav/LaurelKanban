<template>
    <router-link class="desk" :to="{ name : 'kanban.desk', params : { desk : desk.id} }">
        <span class="desk__header">
            <span class="desk__name">{{ desk.name }}</span>
            <span class="desk__menu"></span>
        </span>
        <span class="desk__body">
            <span class="desk__type">{{ desk.is_private ? 'private' : 'public' }}</span>
            <span class="desk__description">{{ desk.description }}</span>
        </span>
    </router-link>
</template>

<script>
    export default {
        name: "DeskComponent",
        props: {
            desk : {
                required : true
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
