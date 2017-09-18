<template>
    <div :class="['main', `breakpoint-${ breakpoint }`]">

        <router-view></router-view>

    </div>
</template>

<script>
    import { sizer, scroller } from 'src/morlock'
    import router from 'src/router'
    import store from 'src/store'

    export default {
        el: '#app',
        data () {
            return {
                winHeight: window.innerHeight,
                winWidth: window.innerWidth,
                sTop: 0
            }
        },
        created () {
            sizer.on('resize', e => {
                this.winWidth = e[0]
                this.winHeight = e[1]
            })
            scroller.on('scroll', top => this.sTop = top)
        },
        computed: {
            breakpoint () {
                return this.winWidth >= 750 ? 'desktop' : 'mobile'
            }
        },
        methods: {
            getValue(val){
                return _.get(this, '$store.state.queryData.data[0].' + val)
            }
        },
        store,
        router
    }
</script>

<style>

body {
    margin: 0;
    min-height: 100vh;
    background-color: #999;
}
.main {
    min-height: 100vh;
}

</style>
