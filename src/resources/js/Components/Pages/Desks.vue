<template>
    <div id="desks">
        <page-header></page-header>
        <div class="desks__list">
            <desk-component
                v-for="desk in desks"
                :key="desk.id"
                :desk="desk"
            ></desk-component>
            <new-desk></new-desk>
        </div>
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
        watch: {
            async $route (to, from){
                await this.init();
                await this.loadDesks();
            }
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

<style lang='scss' scoped>
    #desks {
        z-index: 3;

        .desks__list {
            display: flex;
            justify-content: flex-start;
        }
    }
</style>
