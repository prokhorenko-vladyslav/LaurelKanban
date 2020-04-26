<template>
    <div id="desks">
        <page-header></page-header>
        <div class="desks__list">
            <desk-component
                v-for="desk in desks"
                :key="desk.id"
                :desk="desk"
            ></desk-component>
            <new-desk
                @adding-new-desk="showNewDeskModal"
            ></new-desk>
        </div>

        <transition name="fade">
            <new-desk-modal
                v-if="isAddingNewDesk"
                @close="closeNewDeskModal"
            ></new-desk-modal>
        </transition>
    </div>
</template>

<script type="text/javascript">
    import {mapActions, mapState} from "vuex";

    export default {
        name: "Desks",
        data() {
            return {
                isAddingNewDesk : false
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
            ...mapActions('Desk', ['loadDesks', 'addDesk']),
            pushToLoginPage() {
                this.$router.push({ name: 'kanban.login' });
            },
            showNewDeskModal() {
                this.isAddingNewDesk = true;
            },
            closeNewDeskModal() {
                this.isAddingNewDesk = false;
            }
        }
    }
</script>

<style lang='scss'>
    #desks {
        z-index: 3;

        .desks__list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }
    }
</style>
