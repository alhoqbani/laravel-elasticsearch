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
                host: '46.101.52.160:9200',
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
            client.search({
                index: 'post_index',
                type: 'post_type',
                body: {
                    query: {
                        match: {
                            title: 'السعودية'
                        }
                    }
                }
            }).then(function (resp) {
                var hits = resp.hits.hits;
                console.log(hits);
            }, function (err) {
                console.trace(err.message);
            });

            client.search({
                q: 'السعودية'
            }).then(function (body) {
                console.log("Body: ");
                console.log(body);
                let hits = body.hits.hits;
            }, function (error) {
                console.trace(error.message);
            });
            console.log('ElasticSearch Component mounted.')
        }
    }
</script>
