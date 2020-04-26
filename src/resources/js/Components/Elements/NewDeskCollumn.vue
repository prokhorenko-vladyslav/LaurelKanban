<template>
    <div class="collumn">
        <div class="collumn__header form" v-if="edit">
            <transition name="fade">
                <template v-if="submitted">
                    <div class="error" v-if="!$v.name.required">Name is required</div>
                    <div class="error" v-if="!$v.name.maxLength">Name is too long. Max length is 225 chars</div>
                    <div class="error" v-for="error in nameServerErrors">{{ error }}</div>
                    <div class="error" v-for="error in serverErrors">{{ error }}</div>
                </template>
            </transition>
            <div class="form-group" :class="{ 'form-group--error': $v.name.$error }">
                <input
                    class="collumn__header__input form__input"
                    type="text"
                    v-model.trim="$v.name.$model"
                    @keypress.enter="addNewCollumn"
                >
            </div>
        </div>
        <div class="collumn__body">
            <button class="new-collumn-button" @click="startEdit" v-if="!edit">Add new collumn </button>
            <button class="new-collumn-button" @click="addNewCollumn" v-if="edit">Save</button>
            <button class="new-collumn-button" @click="endEdit"v-if="edit">Cancel</button>
        </div>
    </div>
</template>

<script>
    import {maxLength, required} from "vuelidate/lib/validators";
    import {mapActions} from "vuex";

    export default {
        name: "NewDeskCollumn",
        props: {
            deskId : {
                type : Number,
                required : true
            },
            order : {
                type : Number,
                required : true
            }
        },
        data() {
            return {
                edit : false,
                submitted : false,
                nameServerErrors : null,
                serverErrors : null,
                name : ''
            }
        },
        validations: {
            name: {
                required,
                maxLength: maxLength(225),
            },
        },
        methods : {
            ...mapActions('Collumn', ['addCollumn']),
            startEdit() {
                this.edit = true;
            },
            endEdit() {
                this.submitted = false;
                this.nameServerErrors = null;
                this.serverErrors = null;
                this.name = '';
                this.edit = false;
            },
            async addNewCollumn() {
                this.submitted = true;

                if (!this.$v.$invalid) {
                    let response = await this.addCollumn({
                        name: this.name,
                        order : this.order,
                        deskId : this.deskId,
                    });

                    if (response.status) {
                        this.$emit('adding-new-collumn', {
                            id : response.data.id,
                            name : this.name,
                            order : this.order,
                            cards : []
                        });
                        this.endEdit();
                    } else {
                        if (response.errors.name) {
                            this.newNameServerErrors = response.errors.name;
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
    .collumn {
        height: max-content;
        min-width: 15rem;
        margin: 0 1.5rem;
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
            display: flex;

            .new-collumn-button {
                width: 100%;
                margin-left: .5rem;
                margin-right: .5rem;
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
