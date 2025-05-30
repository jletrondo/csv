<?php

use Jletrondo\Csv\Reader;

beforeEach(function () {
    // Default columns for most tests
    $this->columns = [
        ['column_name' => 'name', 'name' => 'name', 'type' => 'string', 'validate' => 'required'],
        ['column_name' => 'email', 'name' => 'email', 'type' => 'string', 'validate' => 'required|unique'],
    ];
});

test('returns empty processed rows for empty file', function () {
    $csv = '';
    $file = tempnam(sys_get_temp_dir(), 'csv_');
    file_put_contents($file, $csv);

    $reader = new Reader(['columns' => $this->columns]);
    $result = $reader->read($file);

    expect($result['status'])->toBeFalse(); // should return false cause csv is empty.
    expect(is_array($result['rows_processed']))->toBeTrue();
    expect($result['rows_processed'])->toBeEmpty();
    unlink($file);
});