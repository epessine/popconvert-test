<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ title }}</div>

                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: 'Title',
            endPoint: '',
        }
    }
</script>

<style scoped lang="css">
    .container {
        padding: 8rem;
    }
</style>
