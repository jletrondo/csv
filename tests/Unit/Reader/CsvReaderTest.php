<?php

use Jletrondo\Csv\Reader;

beforeEach(function () {
    // Default columns for most tests
    $this->columns = [
        ['column_name' => 'company', 'name' => 'company', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'fullname', 'name' => 'fullname', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'birth date', 'name' => 'birth_date', 'type' => 'date', 'validate' => 'required'],
        ['column_name' => 'active', 'name' => 'active', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'department', 'name' => 'department', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'position', 'name' => 'position', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'salary', 'name' => 'salary', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'employee_id', 'name' => 'employee id', 'type' => 'string', 'validate' => 'required|unique'],
        ['column_name' => 'manager', 'name' => 'manager', 'type' => 'string'],
        ['column_name' => 'hire_date', 'name' => 'hire date', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'phone', 'name' => 'phone', 'type' => 'string', 'validate' => 'unique'],
        ['column_name' => 'email', 'name' => 'email', 'type' => 'string', 'validate' => 'required|unique'],
        ['column_name' => 'address', 'name' => 'address', 'type' => 'string'],
        ['column_name' => 'city', 'name' => 'city', 'type' => 'string'],
        ['column_name' => 'state', 'name' => 'state', 'type' => 'string'],
        ['column_name' => 'zip', 'name' => 'zip', 'type' => 'string'],
    ];
});

test('should fail if row have characters that are not allowed (ISO-8859-1)', function () {
    $filePath = 'tests/test_files/file_iso.csv';
    $reader = new Reader(['columns' => $this->columns]);
    $result = $reader->read($filePath);

    // Verify the results
    expect($result['status'])->toBeTrue();
    expect($result['errors'][0]['message'])->toContain('Unknown or invalid character or possible encoding error found');
    expect($result['error_count'])->toBe(2);
    expect($result['total_error_rows'])->toBe(2);
});

test('should fail if row have characters that are not allowed (UTF-8)', function () {
    $filePath = 'tests/test_files/file_utf_8.csv';
    $reader = new Reader(['columns' => $this->columns]);
    $result = $reader->read($filePath);

    // Verify the results
    expect($result['status'])->toBeTrue();
    expect($result['errors'][0]['message'])->toContain('Unknown or invalid character or possible encoding error found');
    expect($result['error_count'])->toBe(2);
    expect($result['total_error_rows'])->toBe(2);
});

test('custom header row start and start row data ', function () {
    $csv = <<<CSV

        name,birthdate

        should skip this row



        John,02/33/2000
        Jane,2001-01-31
        Dave,07/26/1995
        CSV;
    $file = tempnam(sys_get_temp_dir(), 'csv_');
    file_put_contents($file, $csv);

    $columns = [
        [ 'column_name' => 'name', 'name' => 'name', 'type' => 'string', 'validate' => 'required' ],
        [ 'column_name' => 'birthdate', 'name' => 'birthdate', 'type' => 'date', 'validate' => 'required' ]
    ];

    $reader = new Reader(['columns' => $columns]);
    $reader->setHeaderRowIndex(2);
    $reader->setStartRowIndex(8);
    $result = $reader->read($file);
    expect($result['status'])->toBeTrue();
    expect($result['total_error_rows'])->toBe(1);
    expect($result['error_count'])->toBe(1);
    unlink($file);
});

test('custom header row start and start row data (actual csv file)', function () {
    $filePath = 'tests/test_files/file_header_row.csv';
    $columns = [
        [ 'column_name' => 'name', 'name' => 'name', 'type' => 'string', 'validate' => 'required' ],
        [ 'column_name' => 'birthdate', 'name' => 'birthdate', 'type' => 'date', 'validate' => 'required' ]
    ];
    $reader = new Reader([
        'columns' => $columns,
        'header_row_index' => 4
    ]);
    $reader->setStartRowIndex(11);
    $result = $reader->read($filePath);
    print_r($result);
    // Verify the results
    expect($result['status'])->toBeTrue();
    expect($result['processed'])->toBe(3);
    expect(count($result['rows_processed']))->toBe(3);
    expect($result['error_count'])->toBe(0);
    expect($result['total_error_rows'])->toBe(0);
});




