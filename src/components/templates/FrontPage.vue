<template>

    <section class="front-page">
        <div class="title">
            <h1>{{ pageTitle }}</h1>
            <h2>{{ slogan }}</h2>
        </div>

        <nav>
            <router-link
                v-for="(sibling, i) in siblings"
                :key="i"
                :to="sibling.relativePath">

                <h2>{{ sibling.title }}</h2>
                <div></div>

            </router-link>
        </nav>

    </section>

</template>

<script>
import clipboard from 'src/icons/clipboard.svg'
import Zoomhaus from 'zoomhaus'

export default {
    data(){
        return {
            clipboard
        }
    },
    mounted(){
        new Zoomhaus('img')
    },
    computed: {
        pageTitle(){
            return this.$root.getValue('title')
        },
        slogan(){
            return this.$root.getValue('excerpt')
        },
        siblings(){
            return this.$root.getValue('related.siblings')
        }
    }
}

</script>

<style scoped lang="scss">

section {
    min-height: 100vh;
    background-size: cover;
    background-position: center;
}
.breakpoint-mobile section {
    display: flex;
    flex-direction: column;
}
.title {
    text-align: right;
    width: calc(100% * 2 / 3);
    background-color: #fff;
    padding: 50px;
    box-sizing: border-box;
    min-height: 40vh;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;

    h1 {
        margin: 0;
        font-family: 'Oranienbaum';
        text-transform: uppercase;
        font-weight: 200;
        font-size: 72px;
    }
    h2 {
        font-family: 'Aleo';
    }
}
.breakpoint-mobile .title {
    flex: 1;
    width: 100vw;
}
nav {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    display: flex;
    justify-content: space-between;
    width: calc(100% - 40px);
    margin: auto;
}
.breakpoint-mobile nav {
    position: static;
    flex-direction: column;
    bottom: initial;
    align-items: center;
}
nav a,
.copied {
    color: #000;
    text-decoration: none;
    font-family: 'Amaranth';
    min-width: 200px;
    width: calc(25% - 75px);
    max-width: 300px;
    text-align: center;
    font-size: 24px;
    transform: none;
    transition: transform 0.4s;

    $highlight-color: #35b729;
    $main-color: #99e265;

    h2 {
        background-color: $highlight-color;
        padding: 25px 0;
        margin: 0;
        transition: background-color 0.4s
    }
    div {
        background-color: $main-color;
        height: 0;
        padding-bottom: 100%;
        transition: background-color 0.4s
    }

    &:hover, &:focus {
        transform: translateY(-30px);

        h2 {
            background-color: lighten($highlight-color, 10%);
        }
        div {
            background-color: lighten($main-color, 10%);
        }
    }

    &.centered {
        top: 0 !important;
        left: 50% !important;
        transform: translateX(-50%);
        transition: top 0.7s, left 0.7s, transform 0.7s;
    }
}

.breakpoint-mobile nav a {
    width: 100vw;
    max-width: 100vw;

    div {
        padding-bottom: 0;
    }

    &:not(:last-child) div {
        border-bottom: 2px solid #000;
    }
}

.breakpoint-mobile nav a:hover,
.breakpoint-mobile nav a:focus {
    transform: translateY(0);
}

.copied.centered {
    margin: 90px auto;
    background-color: #fff;
    max-width: 400px;
    padding: 50px 20px;
    line-height: 1.6;
}


</style>
