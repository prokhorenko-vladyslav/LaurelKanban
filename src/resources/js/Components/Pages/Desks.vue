<template>
    <div id="desks">

    </div>
</template>

<script type="text/javascript">
    import { mapActions } from "vuex";

    export default {
        name: "Desks",
        data() {
            return {

            }
        },
        async created() {
            let isAuth = await this.isAuth();
            if (!isAuth) {
                this.pushToLoginPage()
            }
        },
        methods: {
            ...mapActions('Auth', ['isAuth']),
            pushToLoginPage() {
                this.$router.push({ name: 'kanban.login' });
            },
        }
    }
</script>

<style lang='scss'>

</style>
