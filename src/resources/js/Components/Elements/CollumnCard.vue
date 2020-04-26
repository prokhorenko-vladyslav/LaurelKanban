<template>
    <div
        class="collumn-card"
        draggable="true"
    >
        <div class="collumn-card__header">
            {{ card.name }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "CollumnCard",
        props: {
            card : {
                type : Object,
                required : true
            }
        }
    }
</script>

<style lang="scss" scoped>
    .collumn-card {
        margin-bottom: 1rem;
        padding: 0.53rem 0.8rem;
        border-radius: 0.267rem;
        box-shadow: -4px 4px 6px 0 rgba(55, 70, 95, 0.12);
        background: #fff;
    }
</style>
