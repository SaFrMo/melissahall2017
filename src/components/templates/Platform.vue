<template>

    <main>

        <main-menu/>

        <article v-html="getValue('content')"></article>

    </main>

</template>

<script>

export default {
    methods: {
        getValue(val){
            return _.get(this, '$store.state.queryData.data[0].' + val)
        }
    }
}

</script>

<style lang="scss">

article {
    margin: 90px auto;
    background-color: #fff;
    max-width: 400px;
    padding: 50px 20px;
    line-height: 1.6;
    font-family: 'Open Sans';
}
article * {
    max-width: 100%;
    height: auto;
}

</style>
