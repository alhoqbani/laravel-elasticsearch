<?php

namespace App\Services\Elastic;

use App\Models\Post;
use Elasticsearch\ClientBuilder;

class PostIndex
{
    /* @var \Elasticsearch\Client */
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function createIndex()
    {
        $params = [
            'index' => 'post_index',
            'body'  => [
                'settings' => [
                    'number_of_shards'   => 1,
                    'number_of_replicas' => 0,
//                    'mapper.dynamic'     => false, // Automatic mapping creation disabled per-index..
                    'analysis'           => [
                        'filter'    => Analyzer::getFilters(),
                        'tokenizer' => Analyzer::getTokenizers(),
                        'analyzer'  => Analyzer::getAnalyzers(),
                    ],
                ],
                'mappings' => [
                    'post_type' => [
                        '_source'    => [
                            'enabled' => true,
                        ],
                        'properties' => $this->fetchProperties(),
                    ],
                ],
            ],
        ];
//        dd($params);
        $response = $this->client->indices()->create($params);

        return $response;
    }

    public function deleteIndex()
    {
        $params = ['index' => 'post_index'];
        if ($this->client->indices()->exists($params)) {
            $response = $this->client->indices()->delete($params);

            return $response;
        }
    }

    public function getSettings()
    {
        $params = ['index' => 'post_index'];
        $response = $this->client->indices()->getSettings($params);

        return $response;
    }

    public function getMapping()
    {
        $params = ['index' => 'post_index'];
        $response = $this->client->indices()->getMapping($params);

        return $response;
    }

    protected function fetchProperties()
    {
        return [
            'id'           => [
                'type' => 'integer',
            ],
            'author_id'    => [
                'type' => 'integer',
            ],
            'title'        => [
                'type'   => 'text',
                'fields' => [
                    'arabic_default'  => [
                        'type'     => 'text',
                        'analyzer' => 'arabic',
                    ],
                    'arabic_hunspell' => [
                        'type'     => 'text',
                        'analyzer' => 'arabic_hunspell',
                    ],
                    'autocomplete'    => [
                        'type'            => 'text',
                        'analyzer'        => 'autocomplete',
                        'search_analyzer' => 'autocomplete_search',
                    ],
                ],
            ],
            'text'         => [
                'type'   => 'text',
                'fields' => [
                    'arabic_default'  => [
                        'type'     => 'text',
                        'analyzer' => 'default_arabic',
                    ],
                    'arabic'          => [
                        'type'     => 'text',
                        'analyzer' => 'arabic',
                    ],
                    'arabic_hunspell' => [
                        'type'     => 'text',
                        'analyzer' => 'arabic_hunspell',
                    ],
                ],
            ],
            'short_title'         => [
                'type'   => 'text',
                'fields' => [
                    'arabic_default'  => [
                        'type'     => 'text',
                        'analyzer' => 'default_arabic',
                    ],
                    'arabic'          => [
                        'type'     => 'text',
                        'analyzer' => 'arabic',
                    ],
                    'arabic_hunspell' => [
                        'type'     => 'text',
                        'analyzer' => 'arabic_hunspell',
                    ],
                ],
            ],
            'likes'     => [
                'type' => 'integer',
            ],
            'comments'     => [
                'type' => 'integer',
            ],
            'link'       => [
                'type' => 'keyword',
            ],
            'date_h'       => [
                'type'   => 'keyword',
            ],
            'date_g'       => [
                'type'   => 'date',
                'format' => 'yyyy-MM-dd',
            ],
            'published_at' => [
                'type'   => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis',
            ],
            'created_at'   => [
                'type'   => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis',
            ],
            'updated_at'   => [
                'type'   => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis',
            ],
        ];
    }

    public static function indexPost(Post $post)
    {
        $params = [
            'index' => 'post_index',
            'type'  => 'type_index',
            'id'    => $post->id,
            'body'  => $post->toArray(),
        ];
        (new self)->client->index($params);
    }
}
