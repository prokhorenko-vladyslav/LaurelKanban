<template>
    <div class="page-header">
        <div class="page-header__user" v-if="user">
            <div class="page-header__user__name">Hello, {{ user.name }}</div>
            <div class="page-header__user__dropdown">
                <div class="dropdown__item" @click="onLogout">Logout</div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "PageHeader",
        computed: {
            ...mapState('Auth', ['user']),
        },
        methods: {
            ...mapActions('Auth', ['logout']),
            async onLogout() {
                let response = await this.logout();
                if (response) {
                    this.$router.push({ name : 'kanban.home' })
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .page-header {
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
        height: 3rem;
        padding-left: 3rem;
        padding-right: 3rem;
        box-shadow: 0 5px 6px 1px rgba(175, 193, 231, .2);
        background: rgba(231, 237, 243, 0.53);
        z-index: 3;

        .page-header__user {
            position: relative;
            cursor: pointer;

            &:hover {
                .page-header__user__dropdown {
                    visibility: visible;
                }
            }

            .page-header__user__name {
                color: #0e63f4;
                font-weight: 500;
            }

            .page-header__user__dropdown {
                position: absolute;
                bottom: -3rem;
                visibility: hidden;
                transition: all .3s ease-in-out;
            }
        }
    }
</style>
