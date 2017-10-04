<template>
    <main :class="[`breakpoint-${ breakpoint }`]" :style="{ 'background-image': `url(${bgImage})` }">

        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>

    </main>
</template>

<script>
    import throttle from 'lodash/throttle'
    import router from 'src/router'
    import store from 'src/store'
    import _get from 'lodash.get'

    export default {
        el: '#app',
        store,
        router,
        data () {
            return {
                winHeight: window.innerHeight,
                winWidth: window.innerWidth,
                sTop: 0
            }
        },
        mounted () {
            window.addEventListener('resize', throttle(this.setWinSize, 30))
            window.addEventListener('scroll', throttle(this.setWinScroll, 10))
        },
        methods: {
            setWinSize () {
                this.winWidth = window.innerWidth
                this.winHeight = window.innerHeight
            },
            setWinScroll () {
                this.sTop = document.body.scrollTop
            },
            getValue(val){
                return _get(this, '$store.state.page[0]' + val)
            }
        },
        computed: {
            breakpoint () {
                return this.winWidth >= 820 ? 'desktop' : 'mobile'
            },
            bgImage(){
                return this.getValue('related.featured_attachment.sizes.full.url')
            }
        }
    }
</script>

<style>

body {
    margin: 0;
    min-height: 100vh;
}
main {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-position: center;
    background-size: cover;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.4s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}

</style>
