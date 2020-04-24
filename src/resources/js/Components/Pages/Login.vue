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
                    <router-link :to="{ name : 'kanban.register' }" class="form__link">Don`t have an account?</router-link>
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
                this.pushToDesks();
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
            pushToDesks() {
                this.$router.push({ name: 'kanban.desks' });
            },
            async onSubmit() {
                this.submitted = true;
                if (!this.$v.$invalid) {
                    let response = await this.login({
                        email: this.email,
                        password: this.password
                    });

                    if (response.status) {
                        this.pushToDesks();
                    } else {
                        this.serverErrors = response.errors;
                    }
                }
            }
        }
    }
</script>

<style lang='scss'>
    @import "./packages/laurel/kanban/src/resources/scss/page";

    .page {
        &#login {
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
