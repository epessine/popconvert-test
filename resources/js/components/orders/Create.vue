<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ title }}</div>

                    <div class="card-body">
                        <div v-if="errors">
                            <h4>Fake Articles:</h4>
                            <p>(Refresh page to generate other fake articles)</p>
                            <a href="/orders">
                                See Orders
                            </a>
                            <div class="article-container">
                                <div class="article-card" v-for="article in articles" :key="article.id">
                                    <p>Name: {{ article.name }}</p>
                                    <p>Code: {{ article.code }}</p>
                                    <p>Unit Price: {{ article.unit_price }}</p>
                                    <p>Quantity: {{ article.quantity }}</p>
                                </div>
                            </div>
                        </div>

                        <button @click="generateOrder">Generate Order</button>

                        <div v-if="errors[0]">
                            <h4>Errors:</h4>
                            <div v-for="error in errors" :key="error[0]">
                                {{ error[0] }}
                            </div>
                        </div>

                        <div class="order-container" v-if="createdOrder.id">
                            <h4>Order Created:</h4>
                            <p>ID: {{ createdOrder.id }}</p>
                            <p>Code: {{ createdOrder.code }}</p>
                            <p>Total: {{ createdOrder.total }}</p>
                            <p>Total with discount: {{ createdOrder.total_with_discount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: '',
            endPoint: '',
            articles: [],
        },
        mounted() {
            this.createdOrder = {};
            this.errors = {};
        },
        data() {
            return {
                createdOrder: {},
                errors: {},
            }
        },
        methods: {
            async generateOrder() {
                try {
                    const data = this.articles.map((article) => {
                        return {
                            ArticleCode: article.code,
                            ArticleName: article.name,
                            UnitPrice: article.unit_price,
                            Quantity: article.quantity,
                        }
                    });

                    var results = await axios.post(this.endPoint, {
                        articles: data,
                    });

                    this.createdOrder = results.data
                } catch (error) {
                    this.errors = JSON.parse(error.request.response).errors;
                }
            },
        },
    }
</script>

<style scoped lang="css">
    .container {
        padding: 8rem;
    }
    .article-container {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }
    .article-card {
        padding: 1rem 2rem;
        margin: 1rem 1rem;
        border: 1px black solid;
    }
    .order-container {
        padding: 2rem 0;
    }
</style>
