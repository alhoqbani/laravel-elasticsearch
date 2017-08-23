<?php

namespace App\Services\Elastic;

class Analyzer
{
    const DEFAULT_ARABIC_STOP = [
        'arabic_stop' => [
            'type'      => 'stop',
            'stopwords' => '_arabic_',
        ],
    ];

    const DEFAULT_ARABIC_STEMMER = [
        'arabic_stemmer' => [
            'type'     => 'stemmer',
            'language' => 'arabic',
        ],
    ];

    const HUNSPELL_ARABIC_STEMMER = [
        'arabic_hunspell' => [
            'type'     => 'hunspell',
            'language' => 'ar_SA',
        ],
    ];

    const ARABIC_KEYWORDS = [
        'arabic_keywords' => [
            'type'     => 'keyword_marker',
            'keywords' => ['المثال'],
        ],
    ];

    public static function getFilters()
    {
        return array_merge(
            self::DEFAULT_ARABIC_STEMMER,
            self::DEFAULT_ARABIC_STOP,
            self::HUNSPELL_ARABIC_STEMMER,
            self::ARABIC_KEYWORDS
        );
    }

    public static function defaultArabicAnalyzer()
    {
        $filters = array_merge(
            ['lowercase', 'arabic_normalization'],
            array_keys(self::DEFAULT_ARABIC_STOP),
            array_keys(self::DEFAULT_ARABIC_STEMMER)
        );

        $analyzer = [
            'default_arabic' => [
                'tokenizer' => 'standard',
                'filter'    => $filters,
            ],
        ];

        return $analyzer;
    }

    public static function hunspellArabicAnalyzer()
    {
        $filters = array_merge(
            array_keys(self::DEFAULT_ARABIC_STEMMER),
            array_keys(self::DEFAULT_ARABIC_STOP),
            array_keys(self::HUNSPELL_ARABIC_STEMMER),
            ['lowercase', 'arabic_normalization']
        );

        $analyzer = [
            'arabic_hunspell' => [
                'tokenizer' => 'standard',
                'filter'    => $filters,
            ],
        ];

        return $analyzer;
    }

    public static function autocompleteAnalyzer()
    {
        $analyzer = [
            'autocomplete' => [
                'tokenizer' => 'custom_edge_ngram',
                'filter' => ['lowercase', 'arabic_normalization'],
            ],
        ];

        return $analyzer;
    }
    public static function autocompleteSearchAnalyzer()
    {
        $analyzer = [
            'autocomplete_search' => [
                'tokenizer' => 'lowercase',
                'filter' => 'arabic_normalization',
            ],
        ];

        return $analyzer;
    }

    public static function getAnalyzers()
    {
        return array_merge(
            self::defaultArabicAnalyzer(),
            self::hunspellArabicAnalyzer(),
            self::autocompleteAnalyzer(),
            self::autocompleteSearchAnalyzer()
        );
    }

    public static function getTokenizers()
    {
        return array_merge(
            [
                'custom_edge_ngram' => [
                    'type' => 'edge_ngram',
                    'min_gram'    => 2,
                    'max_gram'    => 20,
                    'token_chars' => [
                        'letter',
                        'digit',
                        'punctuation',
                        'symbol',
                    ],
                ],
            ]
        );
    }
}
