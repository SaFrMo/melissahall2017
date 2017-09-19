import './main.css'
import transitionPageFadeCMP from 'src/components/transitions/PageFade.vue'
import RspImageCMP from 'src/components/shared/ResponsiveImg.vue'
import inViewCMP from 'src/components/shared/InView.vue'
import mainMenuCMP from 'src/components/shared/MainMenu.vue'
import App from './components/App.vue'
import Vue from 'vue'

// register global components
Vue.component('transition-page-fade', transitionPageFadeCMP)
Vue.component('responsive-image', RspImageCMP)
Vue.component('in-view', inViewCMP)
Vue.component('main-menu', mainMenuCMP)

// boot app
new Vue( App )
