# Set Up ElasticSearch:

## CORS:
When accessing elasticsearch cluster from a JS client
and from a different domain/origin, "CORS" settings must by changed.

`elasticsearch.yml`
```yaml
http.cors.enabled: true
http.cors.allow-origin : "*"
http.cors.allow-methods : OPTIONS, HEAD, GET, POST, PUT, DELETE
http.cors.allow-headers : X-Requested-With,X-Auth-Token,Content-Type, Content-Length

#http.cors.allow-origin : "http://laravel-elasticsearch.app"
# Could use regex to allow for both http and https (NOTE: no quotation marks)
#http.cors.allow-origin : /https?:\/\/laravel-elasticsearch.app(:[0-9]+)?/

```

## Plugins:
Install plugin:
`sudo bin/elasticsearch-plugin install analysis-icu`

If you rely on some plugins,
you can define mandatory plugins by adding plugin.mandatory setting
to the `config/elasticsearch.yml`

```yml
plugin.mandatory: analysis-icu
```
 