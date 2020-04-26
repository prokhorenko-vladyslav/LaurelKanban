<template>
    <div class="single-desk">
        <page-header></page-header>
        <div class="single-desk-content" v-if="desk">
            <draggable
                :list="desk.collumns"
                v-bind="dragOptions"
                @change="saveOrdering"
                draggable=".collumn"
            >
                <transition-group class="single-desk__collumns">
                    <desk-collumn
                        v-for="collumn in desk.collumns"
                        :key="collumn.id"
                        :defaultCollumn="collumn"
                        :deskId="desk.id"
                    ></desk-collumn>
                </transition-group>
            </draggable>
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
                desk : null,
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
            nextOrderIndex() {
                return this.desk.collumns.length;
            },
            dragOptions() {
                return {
                    animation: 200,
                    group: "collumns",
                    ghostClass: "ghost"
                };
            }
        },
        watch: {
            async $route (to, from) {
                await this.init();
                await this.loadDesk(this.$route.params.desk);
            },
        },
        methods: {
            ...mapActions('Auth', ['isAuth', 'init']),
            ...mapActions('Desk', ['loadDesk']),
            ...mapActions('Collumn', ['updateCollumnOrdering']),
            pushToLoginPage() {
                this.$router.push({ name: 'kanban.login' });
            },
            addNewCollumn(newCollumn) {
                this.desk.collumns.push(newCollumn);
            },
            async saveOrdering() {
                let newCollumnsOrdering = {};

                for (let i = 0; i < this.desk.collumns.length; i++) {
                    newCollumnsOrdering[this.desk.collumns[i].id] = i;
                }

                let response = await this.updateCollumnOrdering({
                    newCollumnsOrdering : newCollumnsOrdering,
                    deskId : this.desk.id,
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .flip-list-move {
        transition: transform .5s;
    }


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

            .single-desk__collumns {
                box-sizing: border-box;
                display: flex;
                padding: 0 2rem 2rem 2rem;
                height: 100%;
            }
        }
    }
</style>
