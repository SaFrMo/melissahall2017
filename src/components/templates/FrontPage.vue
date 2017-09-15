<template>

    <main>

        <div class="title">
            <h1>{{ pageTitle }}</h1>
            <h2>{{ slogan }}</h2>
        </div>

        <nav>
            <router-link
                v-for="(child, i) in children"
                :key="i"
                :to="child.relativePath">

                <h2>{{ child.title }}</h2>
                <div></div>

            </router-link>
        </nav>

    </main>

</template>

<script>
import clipboard from 'src/icons/clipboard.svg'

export default {
    methods: {
        getValue(val){
            return _.get(this, '$store.state.queryData.data[0].' + val)
        }
    },
    data(){
        return {
            clipboard
        }
    },
    computed: {
        pageTitle(){
            return this.getValue('title')
        },
        slogan(){
            return this.getValue('excerpt')
        },
        children(){
            return this.getValue('children')
        }
    }
}

</script>

<style scoped lang="scss">

main {
    min-height: 100vh;
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

    a {
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
    }
    a + a {
        margin-left: 45px;
    }
}


</style>
