<template>
    <div class="new-card-modal">
        <div class="backdrop" @click="fireClose"></div>
        <div class="modal">
            <div class="modal__header">
                <h2>Adding new desk</h2>
            </div>
            <div class="modal__body">
                <form action="#" class="form" @submit.prevent>
                    <div class="errors">
                        <transition name="fade">
                            <div class="error" v-for="error in serverErrors">
                                {{ error }}
                            </div>
                        </transition>
                    </div>
                    <div class="form-group first" :class="{ 'form-group--error': $v.name.$error }">
                        <transition name="fade">
                            <template v-if="submitted">
                                <div class="error" v-if="!$v.name.required">Name is required</div>
                                <div class="error" v-if="!$v.name.maxLength">Name is too long. Max length is 225 chars</div>
                                <div class="error" v-for="error in nameServerErrors">{{ error }}</div>
                            </template>
                        </transition>

                        <input class="form__input" type="text" placeholder="Name" v-model.trim="$v.name.$model"/>
                    </div>
                    <div class="form-group form-group_with-textarea" :class="{ 'form-group--error': $v.description.$error }">
                        <transition name="fade">
                            <template v-if="submitted">
                                <div class="error" v-if="!$v.description.maxLength">Description is too long. Max length is 60000 chars</div>
                                <div class="error" v-for="error in descriptionServerErrors">{{ error }}</div>
                            </template>
                        </transition>

                        <textarea class="form__textarea" placeholder="Description" v-model.trim="$v.description.$model"></textarea>
                    </div>
                    <div class="form-group row">
                        <label class="form__checkbox__label">
                            <input type="checkbox" class="form__checkbox"  v-model="isPrivate">
                            <span class="checkbox__text">Private</span>
                            <span class="checkbox__wrapper">
                                <span class="checkbox__ball"></span>
                            </span>
                        </label>
                        <label class="form__checkbox__label">
                            <input type="checkbox" class="form__checkbox" v-model="isFavorite">
                            <span class="checkbox__text">Favorite</span>
                            <span class="checkbox__wrapper">
                                <span class="checkbox__ball"></span>
                            </span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal__footer">
                <div class="add-button modal-button" @click="onSubmit">Save</div>
                <div class="cancel-button modal-button" @click="fireClose">Cancel</div>
            </div>
        </div>
    </div>
</template>

<script>
    import {maxLength, required} from "vuelidate/lib/validators";
    import {mapActions} from "vuex";

    export default {
        name: "NewDeskModal",
        data() {
            return {
                name : '',
                description : '',
                isFavorite : false,
                isPrivate : false,
                serverErrors : null,
                nameServerErrors : null,
                descriptionServerErrors : null,
                submitted : false
            }
        },
        validations: {
            name: {
                required,
                maxLength: maxLength(225),
            },
            description: {
                maxLength : maxLength(60000)
            }
        },
        methods : {
            ...mapActions('Desk', ['addDesk']),
            fireClose() {
                return this.$emit('close');
            },
            async onSubmit() {
                this.submitted = true;
                if (!this.$v.$invalid) {
                    let response = await this.addDesk({
                        name: this.name,
                        description : this.description,
                        isPrivate : this.isPrivate,
                        isFavorite : this.isFavorite
                    });

                    if (response.status) {
                        this.fireClose();
                        // success message
                    } else {
                        if (response.errors.name) {
                            this.nameServerErrors = response.errors.name;
                        } else if (response.errors.description) {
                            this.nameServerErrors = response.errors.name;
                        } else {
                            this.serverErrors = response.errors;
                        }
                    }
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "./packages/laurel/kanban/src/resources/scss/form";

    .new-card-modal {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 4;

        .backdrop {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 4;
            background: rgba(0, 0, 0, .3);
        }

        .modal {
            width: 600px;
            height: 500px;
            border-radius: .25rem;
            background: #fff;
            z-index: 5;

            .modal__header {
                height: 10%;

                h2 {
                    margin: .75rem 0 0 0;
                    color: #0e1952;
                    text-align: center;
                    font-size: 2rem;
                }
            }

            .modal__body {
                height: 65%;

                .form {
                    height: 55%;

                    .form-group.form-group_with-textarea {
                        height: 100%;

                        .form__textarea {
                            height: 100%;
                        }
                    }
                }
            }

            .modal__footer {
                display: flex;
                align-items: center;
                height: 20%;
                padding: 1rem 1rem;

                .modal-button {
                    width: 30%;
                    height: 2rem;
                    margin: 0 auto;
                    padding: .3rem;
                    border: none;
                    border-radius: .25rem;
                    color: #fff;
                    text-align: center;
                    font-size: .9rem;
                    font-weight: 500;
                    transition: all .3s ease-in-out;
                    cursor: pointer;

                    &.add-button {
                        background: rgba(90, 141, 238, 0.8);

                        &:hover {
                            background: rgba(90, 141, 238, 1);
                        }
                    }

                    &.cancel-button {
                        background: rgba(227, 58, 58, .7);

                        &:hover {
                            background: rgba(227, 58, 58, .9);
                        }
                    }
                }
            }
        }
    }
</style>
