<template>
    <div id="login">
        <form action="#" @submit.prevent="onSubmit">
            <div class="error" v-for="error in serverErrors">
                {{ error }}
            </div>
            <div class="form-group" :class="{ 'form-group--error': $v.email.$error }">
                <label class="form__label">Email</label>
                <input class="form__input" type="text" v-model.trim="$v.email.$model"/>
            </div>
            <div class="error" v-if="!$v.email.required">Field is required</div>
            <div class="error" v-if="!$v.email.email">Field is invalid email</div>

            <div class="form-group" :class="{ 'form-group--error': $v.password.$error }">
                <label class="form__label">Password</label>
                <input class="form__input" type="password" v-model.trim="$v.password.$model"/>
            </div>
            <div class="error" v-if="!$v.password.required">Field is required</div>


            <input type="submit">
        </form>
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
                serverErrors : null
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
        created() {

        },
        methods: {
            ...mapActions('Auth', ['login']),
            clearServerErrors() {
                this.serverErrors = null;
            },
            async onSubmit() {
                if (!this.$v.$invalid) {
                    let response = await this.login({
                        email: this.email,
                        password: this.password
                    });

                    if (response.status) {
                        this.$router.push({ name: 'kanban.home' });
                    } else {
                        this.serverErrors = response.errors;
                    }
                }
            }
        }
    }
</script>

<style lang='scss'>

</style>
