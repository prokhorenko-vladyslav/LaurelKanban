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
        },
        methods: {

        }
    }
</script>

<style lang='scss'>
    @import url('https://fonts.googleapis.com/css2?family=Baloo+Bhai+2:wght@400;500&display=swap');

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    html, body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;

        &, * {
            font-family: 'Baloo Bhai 2', cursive;
        }

        #app {
            width: 100%;
            height: 100%;

            #kanban-application {
                width: 100%;
                height: 100%;
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                background-image: url('../../images/background.jpg');
                background-size: cover;

                &:before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background: #bed5fc;
                    z-index: 1;
                    opacity: .35;
                }

                &, * {
                    box-sizing: border-box;
                    outline: none;

                    &::-moz-focus-inner {
                        border: 0;
                    }
                }
            }
        }
    }
</style>
