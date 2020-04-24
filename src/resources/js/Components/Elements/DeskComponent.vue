<template>
    <div class="desk">
        <div class="desk__name">{{ desk.name }}</div>
    </div>
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
    .desk {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 17rem;
        height: 17rem;
        margin-left: 2rem;
        margin-right: 2rem;
        padding-left: 2rem;
        padding-right: 2rem;
        border-radius: .25rem;
        box-shadow: 0 5px 15px 3px rgb(175, 193, 231);
        background: rgba(231, 237, 243, 0.82);
        color: #0e63f4;
        font-size: 1.8rem;
        transition: transform .3s ease-in-out;
        cursor: pointer;

        &:hover {
            transform: scale(1.02);
        }
    }
</style>
