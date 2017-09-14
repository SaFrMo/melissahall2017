<template>

    <main>

        <div class="title">
            <h1>{{ pageTitle }}</h1>
            <h2>{{ slogan }}</h2>
        </div>

    </main>

</template>

<script>

export default {
    methods: {
        getValue(val){
            return _.get(this, '$store.state.queryData.data[0].' + val)
        }
    },
    computed: {
        pageTitle(){
            return this.getValue('title')
        },
        slogan(){
            return this.getValue('excerpt')
        }
    }
}

</script>

<style scoped>

.title {
    text-align: right;
    width: calc(100% * 2 / 3);
    background-color: #fff;
    padding: 50px;
    box-sizing: border-box;
}
.title h1 {
    margin: 0;
    font-family: 'Oranienbaum';
    text-transform: uppercase;
    font-weight: 200;
    font-size: 72px;
}
.title h2 {
    font-family: 'Aleo';
}

</style>
