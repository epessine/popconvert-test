<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Orders</div>

                    <div class="card-body">
                        <a href="/orders/create">
                            Create Order
                        </a>

                        <table>
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Code</td>
                                    <td>Total</td>
                                    <td>Total with Discount</td>
                                    <td>Created</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders" :key="order.id">
                                    <td>{{ order.id }}</td>
                                    <td>{{ order.code }}</td>
                                    <td>{{ order.total }}</td>
                                    <td>{{ order.total_with_discount }}</td>
                                    <td>{{ order.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            orders: [],
        },
    }
</script>

<style scoped lang="css">
    .container {
        padding: 8rem;
    }
    tr {
        border-top: 1px black solid;
    }
    td {
        padding-right: 0.5rem;
    }
</style>
