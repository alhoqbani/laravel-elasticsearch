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

## Hunspell
Download hunspell dictionary from:
[Hunspell Github](https://github.com/elastic/hunspell/tree/cc1e74c4ca711f0625f6b73f883197794379aa97/dicts/ar-moz)
 
 You need three files:
 - ar.aff
 - ar.dic
 - settings.yml
 Rename the files and put them in `%ES_HOME%`
 ```
 ├── elasticsearch.yml
 ├── hunspell
 │   └── ar_SA
 │       ├── ar_SA.aff
 │       ├── ar_SA.dic
 │       └── settings.yml
```

### Hunspell Usage
Add Hunspell as a filter when creating the index:
```php
'settings' => [
    'analysis' => [
        'filter' => [
            "arabic_hunspell" => [
                "type"     => "hunspell",
                "language" => "ar_SA",
            ],
        ],
    ],
```
Then you can use it with any custom analyzer:
```php
'settings' => [
    'analysis' => [
        'analyzer' => [
            "arabic_hunspell" => [
                "tokenizer" => "standard",
                "filter"    => [
                    "arabic_stemmer",
                    "arabic_stop",
                    "arabic_hunspell",
                    "lowercase",
                    "arabic_normalization",
                ],
            ],
        ],
    ],
],
```
 