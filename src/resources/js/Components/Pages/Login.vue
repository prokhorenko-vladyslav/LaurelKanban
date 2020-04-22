<template>
    <div id="login" class="page" :class="{ loaded }">
        <h1 class="page__header">Login</h1>
        <div class="page__content">
            <form action="#" class="form" @submit.prevent="onSubmit">
                <div class="errors">
                <transition name="fade">
                    <div class="error" v-for="error in serverErrors">
                        {{ error }}
                    </div>
                </transition>
                </div>
                <div class="form-group first" :class="{ 'form-group--error': $v.email.$error }">
                    <transition name="fade">
                        <template v-if="submitted">
                            <div class="error" v-if="!$v.email.required">Email is required</div>
                            <div class="error" v-if="!$v.email.email">Email is invalid</div>
                        </template>
                    </transition>

                    <input class="form__input" type="text" placeholder="Email" v-model.trim="$v.email.$model"/>
                </div>

                <div class="form-group" :class="{ 'form-group--error': $v.password.$error }">
                    <transition name="fade">
                        <div class="error" v-if="submitted && !$v.password.required">Password is required</div>
                    </transition>
                    <input class="form__input" type="password" placeholder="Password" v-model.trim="$v.password.$model"/>
                </div>

                <div class="form-group">
                    <input class="form__submit" type="submit" value="Enter">
                </div>
            </form>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { mapActions } from "vuex";
    import { required, email } from 'vuelidate/lib/validators';

    export default {
        name: "Login",
        data() {
            return {
                email : null,
                password : null,
                serverErrors : null,
                submitted : false,
                loaded : false
            }
        },
        validations: {
            email: {
                required,
                email
            },
            password: {
                required
            }
        },
        watch: {
            email() {
                this.clearServerErrors();
            },
            password() {
                this.clearServerErrors();
            }
        },
        async created() {
            let isAuth = await this.isAuth();
            if (isAuth) {
                this.pushToHome();
            }
        },
        mounted() {
            setTimeout(() => this.loaded = true, 500);
        },
        methods: {
            ...mapActions('Auth', ['login', 'isAuth']),
            clearServerErrors() {
                this.serverErrors = null;
            },
            pushToHome() {
                this.$router.push({ name: 'kanban.home' });
            },
            async onSubmit() {
                this.submitted = true;
                if (!this.$v.$invalid) {
                    let response = await this.login({
                        email: this.email,
                        password: this.password
                    });

                    if (response.status) {
                        this.pushToHome();
                    } else {
                        this.serverErrors = response.errors;
                    }
                }
            }
        }
    }
</script>

<style lang='scss'>
    .page {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border-radius: .5rem;
        background: #fff;
        box-shadow: 0 0 15px 5px rgba(0, 0, 0, .08);
        z-index: 2;

        &#login {
            position: relative;
            right: -100%;
            width: 500px;
            transition: all .3s ease-in-out;

            &.loaded {
                right: 0;
            }
        }

        .page__header {
            margin: 2rem 0 0 0;
            color: #0e1952;
            font-size: 2.7rem;
        }

        .page__content {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;

            .form {
                width: 100%;
                padding-left: 3rem;
                padding-right: 3rem;

                .errors {
                    margin-top: 1rem;
                }

                .error {
                    margin: 0 0 .25rem 0;
                    text-align: left;
                    color: #f54d4d;
                    font-size: .8rem;
                }

                .form-group {
                    display: flex;
                    justify-content: center;
                    flex-direction: column;
                    margin-top: 1rem;

                    &.first {
                        margin-top: .5rem;
                    }

                    .form__input {
                        width: 100%;
                        padding: 1rem;
                        border: 1px solid rgba(202, 216, 245, 0.76);
                        border-radius: .25rem;
                        transition: all .3s ease-in-out;

                        &:focus {
                            box-shadow: 0 0 15px 3px rgba(187, 205, 241, .5);
                        }
                    }

                    .form__submit {
                        width: 10rem;
                        height: 2.5rem;
                        margin: 1rem auto 2rem auto;
                        padding: .25rem 2rem;
                        border: 1px solid #0e63f4;
                        border-radius: .25rem;
                        background: #0e63f4;
                        color: #fff;
                        font-size: 1.2rem;
                        cursor: pointer;
                        box-shadow: 0px 5px 15px 3px rgb(175, 193, 231);
                        transition: all .3s ease-in-out;

                        &:hover {
                            box-shadow: 0px 5px 20px 6px rgb(175, 193, 231);
                        }
                    }
                }
            }
        }
    }
</style>
