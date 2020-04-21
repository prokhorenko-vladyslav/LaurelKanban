<template>
    <div id="home">
        <span v-if="user">
            Hello, {{ user.name }}
            <a href="#" @click.prevent="logout">Logout</a>
        </span>
        <span v-else>
            <router-link :to="{ name : 'kanban.login' }">Login</router-link>
        </span>
    </div>
</template>

<script type="text/javascript">
    import {mapActions, mapState} from "vuex";

    export default {
        name: "Home",
        data() {
            return {

            }
        },
        computed: {
            ...mapState('Auth', ['user'])
        },
        async created() {
            let isAuth = await this.isAuth();
            if (isAuth) {
                await this.init();
            }
        },
        methods: {
            ...mapActions('Auth', ['isAuth', 'init', 'logout'])
        }
    }
</script>

<style lang='scss'>

</style>
