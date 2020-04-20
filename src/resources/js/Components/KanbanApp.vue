<template>
    <div id="kanban-application">
        <router-view/>
    </div>
</template>

<script type="text/javascript">
    import AxiosMixin from "../Mixins/AxiosMixin";
    import { mapActions } from "vuex";

    export default {
        name: "KanbanApplication",
        mixins: [AxiosMixin],
        data() {
            return {

            }
        },
        async created() {
            this.appendInterceptors();
            await this.init();
            await this.login({
                email: 'random.person.1907@gmail.com',
                password : 'K5S41U4c6f'
            })
        },
        methods: {
            ...mapActions('Auth', ['init', 'login']),
        }
    }
</script>

<style lang='scss'>

</style>
