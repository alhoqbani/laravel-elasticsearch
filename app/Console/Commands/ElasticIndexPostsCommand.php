<?php

namespace App\Console\Commands;

use App\Models\Post;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class ElasticIndexPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app-elastic:index-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var \Elasticsearch\Client
     */
    protected $client;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $hosts = [
            '46.101.52.160:9200',         // IP + Port
        ];
        $this->client = ClientBuilder::create()           // Instantiate a new ClientBuilder
        ->setHosts($hosts)      // Set the hosts
        ->build();              // Build the client object
    
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->deleteIndex();
        $this->createIndex();
    
        $posts = Post::with(['author.city'])->get();

        $params = [];
        foreach($posts as $post) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'post_index',
                    '_type' => 'post_type',
                    '_id' => $post->id
                ]
            ];

            $params['body'][] = $post->toArray();
        }
        
        $responses = $this->client->bulk($params);
        \Log::info($responses);
        if ($responses['errors'] == 'true') {
            $this->error("Error!! Check log file");
        } else {
            $this->alert("Done !!");
        }
    }
    
    private function createIndex()
    {
        $params = [
            'index' => 'post_index',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    'post_type' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'date_h' => [
                                'type' => 'string',
                                'analyzer' => 'standard'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        try {
            $this->client->indices()->create($params);
            $this->info("Index Created");
        } catch (BadRequest400Exception $e) {
            dump(json_decode($e->getMessage()));
        }
    }
    
    private function deleteIndex()
    {
        $params = ['index' => 'post_index'];
        try {
            $this->client->indices()->delete($params);
            $this->warn("Index deleted");
        } catch (Missing404Exception $e) {
            dump(json_decode($e->getMessage()));
        }
    }
    
}
