<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Welcome</div>

                    <div class="card-body">
                        <a :href="link">
                            {{ text }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            link: '',
            text: '',
        }
    }
</script>

<style scoped lang="css">
    .container {
        padding: 8rem;
    }
</style>
