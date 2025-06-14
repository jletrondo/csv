<?php

use Jletrondo\Csv\Reader;

test('fails if column definition (name) is missing ', function () {
    $columns = [
        [
            'column_name' => 'id',
            // 'name' => 'id', // this is required
            'type' => 'integer', 
            'required' => true
        ],
    ];

    $csv = <<<CSV
        name,email
        John,john@example.com
        Jane,john@example.com
        CSV;
    $file = tempnam(sys_get_temp_dir(), 'csv_');
    file_put_contents($file, $csv);

    $reader = new Reader(['columns' => $columns]);
    $result = $reader->read($file);

    expect($result['status'])->toBeFalse();
    expect($result['error'])->toContain('Column definition error');
    unlink($file);
});

test('fails if column definition (column_name) is missing', function () {
    $columns = [
        [
            // 'column_name' => 'id',
            'name' => 'id',
            'type' => 'integer',
            'validate' => 'required'
        ],
    ];

    $csv = <<<CSV
        id
        1
        2
        CSV;
    $file = tempnam(sys_get_temp_dir(), 'csv_');
    file_put_contents($file, $csv);

    $reader = new Reader(['columns' => $columns]);
    $result = $reader->read($file);
    expect($result['status'])->toBeFalse();
    expect($result['error'])->toContain('Column definition error');
    unlink($file);
});

test('fails if required column is missing in csv', function () {
    $columns = [
        [
            'column_name' => 'id',
            'name'        => 'id',
            'type'        => 'integer',
            'validate'    => 'required'
        ],
        [
            'column_name' => 'email',
            'name'        => 'email',
            'type'        => 'string',
            'validate'    => 'required'
        ],
    ];

    $csv = <<<CSV
        id
        1
        2
        CSV;
    $file = tempnam(sys_get_temp_dir(), 'csv_');
    file_put_contents($file, $csv);

    $reader = new Reader(['columns' => $columns]);
    $result = $reader->read($file);

    expect($result['status'])->toBeFalse();
    expect($result['error'])->toContain('have missing columns');
    unlink($file);
});

test('passes with valid column definitions and csv', function () {
    $columns = [
        [
            'column_name' => 'id',
            'name' => 'id',
            'type' => 'integer',
            'validate' => 'required'
        ],
        [
            'column_name' => 'email',
            'name' => 'email',
            'type' => 'string',
            'validate' => 'required'
        ],
    ];

    $csv = <<<CSV
        id,email
        1,john@example.com
        2,jane@example.com
        CSV;
    $file = tempnam(sys_get_temp_dir(), 'csv_');
    file_put_contents($file, $csv);

    $reader = new Reader(['columns' => $columns]);
    $result = $reader->read($file);

    expect($result['status'])->toBeTrue();
    expect($result['error'])->toBeEmpty();
    unlink($file);
});

test('returns JSON output for valid CSV', function () {
    $columns = [
        [
            'column_name' => 'id',
            'name' => 'id',
            'type' => 'integer',
            'validate' => 'required'
        ],
        [
            'column_name' => 'email',
            'name' => 'email',
            'type' => 'string',
            'validate' => 'required'
        ],
    ];

    $csv = <<<CSV
        id,email
        1,john@example.com
        2,jane@example.com
        CSV;
    $file = tempnam(sys_get_temp_dir(), 'csv_');
    file_put_contents($file, $csv);

    $reader = new Reader(['columns' => $columns]);
    $reader->read($file);
    $jsonOutput = $reader->toJSON();
    expect($jsonOutput)->toBeJson();

    unlink($file);
});


