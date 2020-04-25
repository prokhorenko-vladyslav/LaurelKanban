<template>
    <div class="single-desk">
        <page-header></page-header>
        <div class="single-desk-content" v-if="desk">
            <desk-collumn
                v-for="collumn in desk.collumns"
                :key="desk.id"
                :collumn="collumn"
            ></desk-collumn>
        </div>
    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "Desk",
        data() {
            return {
                desk : null
            }
        },
        async created() {
            let isAuth = await this.isAuth();
            if (!isAuth) {
                this.pushToLoginPage()
            }
            await this.init();
            let response = await this.loadDesk(this.$route.params.desk);
            if (response)
                this.desk = response;
            else
                alert('Desk has not been loaded');
        },
        watch: {
            async $route (to, from) {
                await this.init();
                await this.loadDesk(this.$route.params.desk);
            }
        },
        methods: {
            ...mapActions('Auth', ['isAuth', 'init']),
            ...mapActions('Desk', ['loadDesk']),
            pushToLoginPage() {
                this.$router.push({ name: 'kanban.login' });
            },
        }
    }
</script>

<style lang="scss" scoped>
    .single-desk {
        align-self: flex-start;
        margin-top: 5rem;
        width: 100%;
        height: 100%;
        z-index: 2;

        .single-desk-content {
            box-sizing: border-box;
            display: flex;
            padding: 0 2rem 2rem 2rem;
            height: 92%;
        }
    }
</style>
