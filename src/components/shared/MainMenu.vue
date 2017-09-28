<template>

    <nav class="menu-items">
        <a
            v-for="(item, i) in menuItems"
            v-if="item.is_external"
            :class="{ active: $route.path == item.relativePath }"
            :href="item.permalink"
            target="_blank">
            {{ item.title }}
        </a>
        <router-link
            v-else
            :class="{ active: $route.path == item.relativePath }"
            :to="item.relativePath">
            {{ item.title }}
        </router-link>
    </nav>

</template>

<script>

    export default {
        name: 'main-menu',
        computed: {
            menuItems () {
                return this.$store.state.site.menus[0].items || []
            }
        }
    }
</script>

<style scoped lang="scss">

$highlight-color: #35b729;
$main-color: #99e265;

nav {
    background-color: rgba(255, 255, 255, 0.97);
    display: inline-block;
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    padding: 0 25px;
    font-family: sans-serif;
    height: 70px;

    display: flex;
    align-items: center;
    justify-content: flex-end;

    transition: background-color 0.4s;

    &:hover, &:focus-within {
        background-color: rgba(255, 255, 255, 1);
    }

    a {
        margin: 5px 10px;
        padding-bottom: 5px;
        color: #000;
        display: block;
        text-decoration: none;
        letter-spacing: 1px;
        margin-right: 10px;
        position: relative;

        &:focus {
            outline: none;
        }

        &:after {
            content: '';
            position: absolute;
            top: 100%;
            right: 100%;
            left: 0;
            height: 2px;
            background: linear-gradient(-90deg, $highlight-color, $main-color);
            transition: right 0.4s;
        }

        &:hover:after, &:focus:after {
            right: 0;
        }
    }

}

</style>
