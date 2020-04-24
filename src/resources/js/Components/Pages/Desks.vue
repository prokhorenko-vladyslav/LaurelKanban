<template>
    <div id="desks">

    </div>
</template>

<script type="text/javascript">
    import {mapActions, mapState} from "vuex";

    export default {
        name: "Desks",
        data() {
            return {

            }
        },
        computed: {
            ...mapState('Auth', ['user']),
            ...mapState('Desk', ['desks']),
        },
        async created() {
            let isAuth = await this.isAuth();
            if (!isAuth) {
                this.pushToLoginPage()
            }
            await this.init();
            await this.loadDesks();
        },
        methods: {
            ...mapActions('Auth', ['isAuth', 'init']),
            ...mapActions('Desk', ['loadDesks']),
            pushToLoginPage() {
                this.$router.push({ name: 'kanban.login' });
            },
        }
    }
</script>

<style lang='scss'>

</style>
