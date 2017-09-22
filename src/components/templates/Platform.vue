<template>

    <section>

        <main-menu/>

        <article v-html="$root.getValue('content')"></article>

    </section>

</template>

<script>

export default {
    
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
