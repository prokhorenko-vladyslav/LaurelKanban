<template>
    <div class="single-desk">
        <page-header></page-header>
        <div class="single-desk-content" v-if="desk">
            <transition-group name="flip-list" tag="div" class="single-desk__collumns">
                <desk-collumn
                    v-for="collumn in sortedCollumns"
                    :key="collumn.id"
                    :defaultCollumn="collumn"
                    :deskId="desk.id"
                    @reorder-collumns="reorderCollumns"
                    @save-ordering="saveOrdering"
                ></desk-collumn>
            </transition-group>
            <new-desk-collumn
                v-if="desk"
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
            ...mapActions('Collumn', ['updateCollumnOrdering']),
            pushToLoginPage() {
                this.$router.push({ name: 'kanban.login' });
            },
            addNewCollumn(newCollumn) {
                this.desk.collumns.push(newCollumn);
            },
            reorderCollumns(draggableCollumnId, targetCollumnId) {
                let draggableCollumnIndex,
                    targetCollumnIndex,
                    sortedCollumns = this.sortedCollumns,
                    draggableCollumn = sortedCollumns.find((collumn, index) => {
                        if (collumn.id === draggableCollumnId) {
                            draggableCollumnIndex = index;
                            return true;
                        }
                    }),
                    targetCollumn = sortedCollumns.find((collumn, index) =>  {
                        if (collumn.id === targetCollumnId) {
                            targetCollumnIndex = index;
                            return true;
                        }
                    }),
                    oldDraggableCollumnOder = draggableCollumn.order;

                draggableCollumn.order = targetCollumn.order;
                if (oldDraggableCollumnOder < targetCollumn.order) {
                    for (let i = draggableCollumnIndex + 1; i <= targetCollumnIndex; i++)
                        sortedCollumns[i].order--;
                } else {
                    for (let i = draggableCollumnIndex - 1; i >= targetCollumnIndex; i--)
                        sortedCollumns[i].order++;
                }

                this.desk.collumns = sortedCollumns;
            },
            async saveOrdering() {
                let newCollumnsOrdering = {},
                    sortedCollumns = this.sortedCollumns;

                for (let i = 0; i < sortedCollumns.length; i++) {
                    newCollumnsOrdering[sortedCollumns[i].id] = sortedCollumns[i].order;
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
    /*.flip-list-move {
        transition: transform .5s;
    }*/

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
