<template>
    <div id="kanban-application">
        <router-view/>
    </div>
</template>

<script type="text/javascript">
    import AxiosMixin from "../Mixins/AxiosMixin";

    export default {
        name: "KanbanApplication",
        mixins: [AxiosMixin],
        data() {
            return {

            }
        },
        async created() {
            this.appendInterceptors();
        },
        methods: {

        }
    }
</script>

<style lang='scss'>

</style>
