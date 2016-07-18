<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Localise.biz api url
    |--------------------------------------------------------------------------
    */
    'api' => 'https://localise.biz/api/export/locale/',

    /*
    |--------------------------------------------------------------------------
    | Loco Projects
    |--------------------------------------------------------------------------
    | Define your Loco projects. Name can be chosen freely. The project
    | api key can be found in the loco project settings.
    */
    'projects' => [
        'name' => 'loco-project-api-key'
    ],

    /*
    |--------------------------------------------------------------------------
    | Available languages
    |--------------------------------------------------------------------------
    | Your translated languages in Loco.
    */
    'languages' => [
        'en_US',
        'de_DE'
    ],

    /*
    |--------------------------------------------------------------------------
    | Loco api index
    |--------------------------------------------------------------------------
    | The {index} parameter specifies whether the translations in your
    | file are indexed by asset IDs or source texts.
    | options: name, id, text
    */
    'loco_index' => 'name',
];
