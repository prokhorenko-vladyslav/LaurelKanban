<template>
    <div class="collumn">
        <div class="collumn__header">
            <div class="collumn__header__name">{{ collumn.name }}</div>
        </div>
        <div class="collumn__body">
            <collumn-card
                v-for="card in sortedCards"
                :key="card.id"
                :card="card"
            ></collumn-card>
            <button
                class="new-card-button"
                @click="addNewCard"
            >+Add new card</button>
        </div>
        <transition name="fade">
            <new-card-modal
                v-if="isAddingNewCard"
                :collumnId="collumn.id"
                :deskId="deskId"
                :order="this.nextOrderIndex"
                @adding-new-card="addNewCardToCollumn"
                @close="closeNewCardModal"
            ></new-card-modal>
        </transition>
    </div>
</template>

<script>
    export default {
        name: "DeskCollumn",
        props: {
            defaultCollumn : {
                type : Object,
                required : true
            },
            deskId : {
                type : Number,
                required : true
            }
        },
        data() {
            return {
                isAddingNewCard : false,
                collumn : this.defaultCollumn
            }
        },
        computed: {
            sortedCards() {
                return this.collumn.cards.sort((firstCard, secondCard) => firstCard.order > secondCard.order);
            },
            nextOrderIndex() {
                let sortedCards = this.sortedCards;
                return sortedCards.length ? sortedCards[sortedCards.length - 1].order + 1 : 0;
            }
        },
        methods: {
            addNewCard() {
                this.isAddingNewCard = true;
            },
            closeNewCardModal() {
                this.isAddingNewCard = false;
            },
            addNewCardToCollumn(newCard) {
                this.collumn.cards.push(newCard);
                this.closeNewCardModal();
            }
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
