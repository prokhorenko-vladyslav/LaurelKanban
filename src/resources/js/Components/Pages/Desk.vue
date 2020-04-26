<template>
    <div class="single-desk">
        <page-header></page-header>
        <div class="single-desk-content" v-if="desk">
            <desk-collumn
                v-for="collumn in sortedCollumns"
                :key="collumn.id"
                :defaultCollumn="collumn"
                :deskId="desk.id"
            ></desk-collumn>
            <new-desk-collumn
                :deskId="desk.id"
                :order="nextOrderIndex"
                @adding-new-collumn="addNewCollumn"
            ></new-desk-collumn>
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
        computed: {
            sortedCollumns() {
                return this.desk.collumns.sort((firstCollumn, secondCollumn) => firstCollumn.order > secondCollumn.order);
            },
            nextOrderIndex() {
                let sortedCollumns = this.sortedCollumns;
                return sortedCollumns.length ? sortedCollumns[sortedCollumns.length - 1].order + 1 : 0;
            }
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
            addNewCollumn(newCollumn) {
                this.desk.collumns.push(newCollumn);
            }
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
            overflow-y: auto;

            &:after {
                content: '';
                display: block;
                height: 100%;
                min-width: 2rem;
            }
        }
    }
</style>
