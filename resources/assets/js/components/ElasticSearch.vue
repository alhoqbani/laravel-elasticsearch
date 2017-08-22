<template>
        <div class="panel panel-default">
            <div class="panel-heading">ElasticSearch Component</div>

            <div class="panel-body">
                I'm an ElasticSearch component!
            </div>
        </div>
</template>

<script>
    import es from 'elasticsearch';

    export default {
        mounted() {
            let client = new es.Client({
                host: 'localhost:9200',
                log: 'trace'
            });
            client.ping({
                requestTimeout: 30000,
            }, function (error) {
                if (error) {
                    console.error('elasticsearch cluster is down!');
                } else {
                    console.log('All is well');
                }
            });
            console.log('ElasticSearch Component mounted.')
        }
    }
</script>
