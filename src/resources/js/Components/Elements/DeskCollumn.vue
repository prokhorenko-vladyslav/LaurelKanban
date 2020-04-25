<template>
    <div class="collumn">
        <div class="collumn__header">
            <div class="collumn__header__name">{{ collumn.name }}</div>
        </div>
        <div class="collumn__body">
            <collumn-card
                v-for="card in collumn.cards"
                :key="card.id"
                :card="card"
            ></collumn-card>
            <button class="new-card-button">+Add new card</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DeskCollumn",
        props: {
            collumn : {
                type : Object,
                required : true
            }
        },
        async created() {

        },
        watch: {
            async $route (to, from) {

            }
        },
        methods: {

        }
    }
</script>

<style lang="scss" scoped>
    .collumn {
        height: max-content;
        width: 15rem;
        margin: 0 1.5rem;
        padding: 1rem;
        overflow-x: hidden;
        overflow-y: auto;
        border-radius: .25rem;
        background: rgba(231, 237, 243, 0.53);
        box-shadow: 0 0 6px 1px rgba(175, 193, 231, .3);

        .collumn__header {
            margin-bottom: 1rem;

            .collumn__header__name {
                color: #475F7B;
                font-size: 1.2rem;
            }
        }

        .collumn__body {
            .new-card-button {
                width: 100%;
                padding: .3rem;
                border: none;
                border-radius: .25rem;
                background: rgba(90, 141, 238, 0.4);
                color: #fff;
                font-size: .9rem;
                font-weight: 500;
                transition: all .3s ease-in-out;
                cursor: pointer;

                &:hover {
                    background: rgba(90, 141, 238, 0.8);
                }
            }
        }
    }
</style>
