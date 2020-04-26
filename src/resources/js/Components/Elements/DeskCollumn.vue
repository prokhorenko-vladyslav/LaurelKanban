<template>
    <div
        class="collumn"
        draggable="true"
        @drag="dragStart"
        @dragover.prevent
        @dragenter.prevent="reorderCollumns"
        @dragleave.prevent="dragStop"
        @drop.prevent="updateOrdering"
    >
        <div class="collumn__content">
            <div class="collumn__header form">
                <transition name="fade">
                    <template v-if="edit && submitted">
                        <div class="error" v-if="!$v.newName.required">Name is required</div>
                        <div class="error" v-if="!$v.newName.maxLength">Name is too long. Max length is 225 chars</div>
                        <div class="error" v-for="error in newNameServerErrors">{{ error }}</div>
                        <div class="error" v-for="error in serverErrors">{{ error }}</div>
                    </template>
                </transition>
                <div
                    class="collumn__header__name"
                    v-if="!edit"
                    @click="startEdit"
                >{{ collumn.name }}</div>
                <div class="form-group" :class="{ 'form-group--error': $v.newName.$error }" v-else>
                    <input
                        class="collumn__header__input form__input"
                        type="text"
                        v-model.trim="$v.newName.$model"
                        @keypress.enter="saveName"
                    >
                </div>
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
        <div
            class="collumn__drag-element"
        ></div>
    </div>
</template>

<script>
    import {mapActions, mapMutations, mapState} from "vuex";
    import {maxLength, required} from "vuelidate/lib/validators";

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
                collumn : this.defaultCollumn,
                edit : false,
                submitted : false,
                newNameServerErrors : null,
                serverErrors : null,
                newName : this.defaultCollumn.name,
            }
        },
        validations: {
            newName: {
                required,
                maxLength: maxLength(225),
            },
        },
        computed: {
            ...mapState('Collumn', ['dragging', 'draggableCollumn']),
            sortedCards() {
                return this.collumn.cards.sort((firstCard, secondCard) => firstCard.order > secondCard.order);
            },
            nextOrderIndex() {
                let sortedCards = this.sortedCards;
                return sortedCards.length ? sortedCards[sortedCards.length - 1].order + 1 : 0;
            }
        },
        methods: {
            ...mapMutations('Collumn', ['startDragging', 'endDragging', 'setDraggableCollumn']),
            ...mapActions('Collumn', ['updateCollumn']),
            addNewCard() {
                this.isAddingNewCard = true;
            },
            closeNewCardModal() {
                this.isAddingNewCard = false;
            },
            addNewCardToCollumn(newCard) {
                this.collumn.cards.push(newCard);
                this.closeNewCardModal();
            },
            startEdit() {
                this.edit = true;
            },
            endEdit() {
                this.edit = false;
            },
            async saveName() {
                this.submitted = true;

                if (!this.$v.$invalid) {
                    let response = await this.updateCollumn({
                        name: this.newName,
                        order : this.collumn.order,
                        deskId : this.deskId,
                        collumnId : this.collumn.id,
                    });

                    if (response.status) {
                        this.collumn.name = this.newName;
                        this.endEdit();
                    } else {
                        if (response.errors.name) {
                            this.newNameServerErrors = response.errors.name;
                        } else {
                            this.serverErrors = response.errors;
                        }
                    }
                }
            },
            dragStart(event) {
                event.stopPropagation();
                this.setDraggableCollumn(this.collumn);
                this.startDragging();
            },
            dragStop() {
                this.setDraggableCollumn(null);
                this.endDragging();
            },
            reorderCollumns(event) {
                event.stopPropagation();
                if (this.dragging && this.draggableCollumn && this.draggableCollumn.id !== this.collumn.id) {
                    this.$emit('reorder-collumns', this.draggableCollumn.id, this.collumn.id);
                }
            },
            updateOrdering() {
                this.$emit('save-ordering');
                this.dragStop();
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "./packages/laurel/kanban/src/resources/scss/form";

    .collumn {
        display: flex;
        position: relative;
        height: max-content;
        min-width: 16rem;
        width: 16rem;
        max-height: 100%;
        margin: 0 1.5rem;

        .collumn__drag-element {
            max-width: 0;
            min-width: 0;
            width: 0;
            transition: all .3s ease-in-out;
        }

        .collumn__content {
            min-width: 16rem;
            padding: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
            border-radius: .25rem;
            background: rgba(231, 237, 243, 0.53);
            box-shadow: 0 0 6px 1px rgba(175, 193, 231, .3);

            .collumn__header {
                margin-bottom: 1rem;

                &.form {
                    padding: 0;

                    .form-group {
                        margin-top: 0;

                        .form__input {
                            padding: .3rem 1rem;
                        }
                    }
                }

                .collumn__header__name {
                    color: #475F7B;
                    font-size: 1.2rem;
                }
            }

            .collumn__body {
                margin-bottom: 1rem;

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
    }
</style>
