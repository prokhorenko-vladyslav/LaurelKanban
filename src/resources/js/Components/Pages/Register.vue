<template>
    <div id="register">
        <form action="#" @submit.prevent="onSubmit">
            <div class="error" v-for="error in serverErrors">
                {{ error }}
            </div>
            <div class="form-group" :class="{ 'form-group--error': $v.name.$error }">
                <label class="form__label">Name</label>
                <input class="form__input" type="text" v-model.trim="$v.name.$model"/>
            </div>
            <div class="error" v-if="!$v.name.required">Name is required</div>
            <div class="error" v-for="error in nameServerErrors">{{ error }}</div>

            <div class="form-group" :class="{ 'form-group--error': $v.email.$error }">
                <label class="form__label">Email</label>
                <input class="form__input" type="text" v-model.trim="$v.email.$model"/>
            </div>
            <div class="error" v-if="!$v.email.required">Email is required</div>
            <div class="error" v-if="!$v.email.email">Email is invalid</div>
            <div class="error" v-for="error in emailServerErrors">{{ error }}</div>

            <div class="form-group" :class="{ 'form-group--error': $v.password.$error }">
                <label class="form__label">Password</label>
                <input class="form__input" type="password" v-model.trim="$v.password.$model"/>
            </div>
            <div class="error" v-if="!$v.password.required">Password is required</div>
            <div class="error" v-if="!$v.password.alphaNum">Password can contain only alphanumerics characters</div>
            <div class="error" v-if="!$v.password.minLength">Password too short</div>
            <div class="error" v-for="error in passwordServerErrors">{{ error }}</div>

            <div class="form-group" :class="{ 'form-group--error': $v.password_confirmation.$error }">
                <label class="form__label">Password confirmation</label>
                <input class="form__input" type="password" v-model.trim="$v.password_confirmation.$model"/>
            </div>
            <div class="error" v-if="!$v.password_confirmation.required">Please confirm your password</div>
            <div class="error" v-if="!$v.password_confirmation.sameAs">Field must be equal to password</div>
            <div class="error" v-for="error in passwordConfirmationServerErrors">{{ error }}</div>

            <input type="submit">
        </form>
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

                serverErrors : null
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

</style>
