<template>

    <section class="front-page">
        <div class="title">
            <h1>{{ pageTitle }}</h1>

            <div class="entry" v-html="$store.state.page[0].content"></div>

            <h2>{{ slogan }}</h2>
        </div>

        <div class="spacer"></div>

        <nav class="contact">
            <ul>
                <li><a href="https://www.facebook.com/fallcreekvoice/" target="_blank">Facebook</a></li>
                <li><a href="mailto:melhall_274@hotmail.com">Email</a></li>
            </ul>
        </nav>

        <nav class="main-links">
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
    width: 100vw;
    padding-top: 150px;
    flex: 1;
}
.contact {
    background-color: #fff;
    position: absolute;
    top: 0;
    right: 0;
    padding: 20px;

    ul {
        padding: 0 20px;
    }

    a {
        color: #000;
        font-family: 'Aleo';
        text-decoration: none;
        font-size: 20px;
        line-height: 1.6;

        &:hover, &:focus {
            text-decoration: underline;
        }
    }
}
.spacer {
    flex: 1;
}
.breakpoint-mobile .spacer {
    display: none;
}
.main-links {
    display: flex;
    justify-content: space-between;
    width: calc(100% - 40px);
    margin: 30px auto 0;
}
.breakpoint-mobile .main-links {
    flex-direction: column;
    align-items: center;
    margin-top: 0;
}
.main-links a,
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

.breakpoint-mobile .main-links a {
    width: 100vw;
    max-width: 100vw;

    div {
        padding-bottom: 0;
    }

    &:not(:last-child) div {
        border-bottom: 2px solid #000;
    }
}

.breakpoint-mobile .main-links a:hover,
.breakpoint-mobile .main-links a:focus {
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
