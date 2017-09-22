<template>

    <section class="front-page">
        <div class="title">
            <h1>{{ pageTitle }}</h1>
            <h2>{{ slogan }}</h2>
        </div>

        <nav>
            <a
                v-for="(sibling, i) in siblings"
                :key="i"
                :href="sibling.relativePath"
                @click.prevent="clickLink($event)">

                <h2>{{ sibling.title }}</h2>
                <div></div>

            </a>
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
    computed: {
        pageTitle(){
            return this.$root.getValue('title')
        },
        slogan(){
            return this.$root.getValue('excerpt')
        },
        siblings(){
            return this.$root.getValue('siblings')
        }
    },
    methods: {
        clickLink(evt){
            console.log(evt.currentTarget)

            // copy dom element
            const copy = evt.currentTarget.cloneNode(true)
            copy.classList.add('copied')

            // place copy at target position
            copy.style.position = 'absolute';
            const rect = evt.currentTarget.getBoundingClientRect()
            copy.style.top = rect.top + 'px'
            copy.style.left = rect.left + 200 + 'px'

            // append to dom
            const nav = document.querySelector('.front-page')
            nav.appendChild(copy)

            // animate to center of screen

            // populate with content
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
nav {
    position: absolute;
    bottom: 0;
    display: flex;
    justify-content: center;
    width: 100%;
}
nav a,
.copied {
    color: #000;
    text-decoration: none;
    font-family: 'Amaranth';
    min-width: 250px;
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

    & + a {
        margin-left: 45px;
    }
}


</style>
