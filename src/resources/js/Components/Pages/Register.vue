<template>
    <div id="register" class="page" :class="{ loaded }">
        <div class="page__header">Register</div>
        <div class="page__content">
        <form action="#" class="form" @submit.prevent="onSubmit">
            <div class="errors">
                <transition name="fade">
                    <div class="error" v-for="error in serverErrors">
                        {{ error }}
                    </div>
                </transition>
            </div>
            <div class="form-group" :class="{ 'form-group--error': $v.name.$error }">
                <transition name="fade">
                    <template v-if="submitted">
                        <div class="error" v-if="!$v.name.required">Name is required</div>
                        <div class="error" v-for="error in nameServerErrors">{{ error }}</div>
                    </template>
                </transition>
                <input class="form__input" type="text" placeholder="Name" v-model.trim="$v.name.$model"/>
            </div>

            <div class="form-group" :class="{ 'form-group--error': $v.email.$error }">
                <transition name="fade">
                    <template v-if="submitted">
                        <div class="error" v-if="!$v.email.required">Email is required</div>
                        <div class="error" v-if="!$v.email.email">Email is invalid</div>
                        <div class="error" v-for="error in emailServerErrors">{{ error }}</div>
                    </template>
                </transition>
                <input class="form__input" type="text" placeholder="Email" v-model.trim="$v.email.$model"/>
            </div>

            <div class="form-group" :class="{ 'form-group--error': $v.password.$error }">
                <transition name="fade">
                    <template v-if="submitted">
                        <div class="error" v-if="!$v.password.required">Password is required</div>
                        <div class="error" v-if="!$v.password.alphaNum">Password can contain only alphanumerics characters</div>
                        <div class="error" v-if="!$v.password.minLength">Password too short</div>
                        <div class="error" v-for="error in passwordServerErrors">{{ error }}</div>
                    </template>
                </transition>
                <input class="form__input" type="password" placeholder="Password"  v-model.trim="$v.password.$model"/>
            </div>

            <div class="form-group" :class="{ 'form-group--error': $v.password_confirmation.$error }">
                <transition name="fade">
                    <template v-if="submitted">
                        <div class="error" v-if="!$v.password_confirmation.required">Please confirm your password</div>
                        <div class="error" v-if="!$v.password_confirmation.sameAs">Field must be equal to password</div>
                        <div class="error" v-for="error in passwordConfirmationServerErrors">{{ error }}</div>
                    </template>
                </transition>
                <input class="form__input" type="password" placeholder="Password confirmation" v-model.trim="$v.password_confirmation.$model"/>
            </div>

            <div class="form-group">
                <router-link :to="{ name : 'kanban.login' }" class="form__link">Already have an account?</router-link>
            </div>

            <div class="form-group">
                <input class="form__submit" type="submit" value="Create">
            </div>
        </form>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { mapActions } from "vuex";
    import { required, minLength, alphaNum, email, sameAs } from "vuelidate/lib/validators";

    export default {
        name: "Register",
        data() {
            return {
                name : null,
                nameServerErrors: [],

                email : null,
                emailServerErrors: [],

                password : null,
                passwordServerErrors: [],

                password_confirmation : null,
                passwordConfirmationServerErrors: [],

                serverErrors : null,
                submitted: false,
                loaded : false
            }
        },
        validations: {
            name: {
                required,
                minLength: minLength(4),
                alphaNum
            },
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(8),
                alphaNum
            },
            password_confirmation: {
                required,
                sameAs : sameAs('password')
            }
        },
        watch: {
            /*email() {
                this.clearServerErrors();
            },
            password() {
                this.clearServerErrors();
            }*/
        },
        async created() {
            /*let isAuth = await this.isAuth();
            if (isAuth)
                this.pushToHome();*/
        },
        mounted() {
            setTimeout(() => this.loaded = true, 500);
        },
        methods: {
            ...mapActions('Auth', ['register', 'isAuth']),
            clearServerErrors() {
                this.serverErrors = null;
            },
            pushToHome() {
                this.$router.push({ name: 'kanban.home' });
            },
            pushToLoginPage() {
                this.$router.push({ name: 'kanban.login' });
            },
            async onSubmit() {
                this.submitted = true;
                if (!this.$v.$invalid) {
                    let response = await this.register({
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    });

                    if (response.status) {
                        this.pushToLoginPage();
                    } else {
                        if (response.errors.name) {
                            this.nameServerErrors = response.errors.name;
                        } else if (response.errors.email) {
                            this.emailServerErrors = response.errors.email;
                        } else if (response.errors.password) {
                            this.emailServerErrors = response.errors.password;
                        } else if (response.errors.password_confirmation) {
                            this.passwordConfirmationServerErrors = response.errors.password_confirmation;
                        } else {
                            this.serverErrors = response.errors;
                        }
                    }
                }
            }
        }
    }
</script>

<style lang='scss'>
    @import "./packages/laurel/kanban/src/resources/scss/page";
    @import "./packages/laurel/kanban/src/resources/scss/form";

    .page {
        &#register {
            position: relative;
            right: -100%;
            width: 500px;
            transition: all .4s ease-in-out;

            &.loaded {
                right: 0;
            }
        }
    }
</style>
