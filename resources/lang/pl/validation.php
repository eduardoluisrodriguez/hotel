<?php

return [

    'accepted'             => ':Attribute musi zostać zaakceptowany.',
    'active_url'           => ':Attribute jest nieprawidłowym adresem URL.',
    'after'                => ':Attribute musi być datą późniejszą od :date.',
    'alpha'                => ':Attribute może zawierać jedynie litery.',
    'alpha_dash'           => ':Attribute może zawierać jedynie litery, cyfry i myślniki.',
    'alpha_num'            => ':Attribute może zawierać jedynie litery i cyfry.',
    'array'                => ':Attribute musi być tablicą.',
    'before'               => ':Attribute musi być datą wcześniejszą od :date.',
    'between'              => [
        'numeric' => ':Attribute musi zawierać się w granicach :min - :max.',
        'file'    => ':Attribute musi zawierać się w granicach :min - :max kilobajtów.',
        'string'  => ':Attribute musi zawierać się w granicach :min - :max znaków.',
        'array'   => ':Attribute musi składać się z :min - :max elementów.',
    ],
    'boolean'              => ':Attribute musi mieć wartość prawda albo fałsz',
    'confirmed'            => 'Potwierdzenie :attribute nie zgadza się.',
    'date'                 => ':Attribute nie jest prawidłową datą.',
    'date_format'          => ':Attribute nie jest w formacie :format.',
    'different'            => ':Attribute oraz :other muszą się różnić.',
    'digits'               => ':Attribute musi składać się z :digits cyfr.',
    'digits_between'       => ':Attribute musi mieć od :min do :max cyfr.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Format :attribute jest nieprawidłowy.',
    'exists'               => 'Zaznaczony :attribute jest nieprawidłowy.',
    'filled'               => 'Pole :attribute jest wymagane.',
    'image'                => ':Attribute musi być obrazkiem.',
    'in'                   => 'Zaznaczony :attribute jest nieprawidłowy.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':Attribute musi być liczbą całkowitą.',
    'ip'                   => ':Attribute musi być prawidłowym adresem IP.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':Attribute nie może być większy niż :max.',
        'file'    => ':Attribute nie może być większy niż :max kilobajtów.',
        'string'  => ':Attribute nie może być dłuższy niż :max znaków.',
        'array'   => ':Attribute nie może mieć więcej niż :max elementów.',
    ],
    'mimes'                => ':Attribute musi być plikiem typu :values.',
    'min'                  => [
        'numeric' => ':Attribute musi być nie mniejszy od :min.',
        'file'    => ':Attribute musi mieć przynajmniej :min kilobajtów.',
        'string'  => ':Attribute musi mieć przynajmniej :min znaków.',
        'array'   => ':Attribute musi mieć przynajmniej :min elementów.',
    ],
    'not_in'               => 'Zaznaczony :attribute jest nieprawidłowy.',
    'numeric'              => ':Attribute musi być liczbą.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Format :attribute jest nieprawidłowy.',
    'required'             => 'Pole :attribute jest wymagane.',
    'required_if'          => 'Pole :attribute jest wymagane gdy :other jest :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Pole :attribute jest wymagane gdy :values jest obecny.',
    'required_with_all'    => 'Pole :attribute jest wymagane gdy :values jest obecny.',
    'required_without'     => 'Pole :attribute jest wymagane gdy :values nie jest obecny.',
    'required_without_all' => 'Pole :attribute jest wymagane gdy żadne z :values nie są obecne.',
    'same'                 => 'Pole :attribute i :other muszą się zgadzać.',
    'size'                 => [
        'numeric' => ':Attribute musi mieć :size.',
        'file'    => ':Attribute musi mieć :size kilobajtów.',
        'string'  => ':Attribute musi mieć :size znaków.',
        'array'   => ':Attribute musi zawierać :size elementów.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => ':Attribute musi być prawidłową strefą czasową.',
    'unique'               => 'Taki :attribute już występuje.',
    'url'                  => 'Format :attribute jest nieprawidłowy.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule' to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of 'email'. This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        'comment'  => 'komentarz',
        'date'     => 'data',
        'email'    => 'adres e-mail',
        'name'     => 'nazwa',
        'password' => 'hasło',
        'value'    => 'wartość',
    ],

];
