<?php

namespace Jletrondo\Config;

class Constants
{
    const DELIMITER = ',';
    const ENCLOSURE = '"';
    const ESCAPE = '\\';
    const HAS_HEADER = true;
    const IS_DOWNLOADABLE = false;
    const ERROR_COUNT_THRESHOLD = 10;
    const PROGRESS_CALLBACK_INTERVAL = 100;
    const DIRECTORY_PATH = "tests/errors/";
    const FILE_NAME = "rows_with_errors.csv";

    // ERROR MESSAGES
    const ERROR_THRESHOLD = "The uploaded file has too many errors. Please take time to review and try again.";
    const HEADER_ROW_INDEX = "Header row index must be less than the start row index.";

    // COLUMN ERRORS
    const COLUMN_DEFINITION_ERROR = "Column definition error: Each column must have both a 'column_name' (the CSV header) and a 'name' (the key for the resulting array). Please review your column definitions and ensure these fields are present for every column.";
    const MISSING_COLUMNS = "The uploaded CSV file have missing columns.";
    const EXTRA_HEADERS = "The uploaded CSV file have extra headers.";
    const EXTRA_COLUMNS = "The uploaded CSV file have extra columns.";
    const DUPLICATE_HEADERS = "The uploaded CSV file have duplicate headers.";
    const ROW_COLUMN_COUNT_MISMATCH = "Row has incorrect column count (expected %d, got %d).";
    const COLUMN_DATE_FORMAT_ERROR = "Invalid date format in column '%s'. Please use one of the following formats: m/d/Y, m-d-Y, Y/m/d, or Y-m-d.";
    const COLUMN_INVALID_VALUES = "Invalid value in column '%s': expected one of ['%s'], found '%s'.";
    const COLUMN_ENCODING_ERROR = "Unknown or invalid character or possible encoding error found in column '%s'.";

    // FILE ERRORS
    const FILE_DOES_NOT_EXIST = "The file does not exist: ";
    const FILE_OPEN_ERROR = "Failed to open file: ";
    const FILE_READ_ERROR = "Failed to read file: ";
    const FILE_WRITE_ERROR = "Failed to write file: ";
    const FILE_CLOSE_ERROR = "Failed to close file: ";
    const FILE_IS_NOT_A_CSV = "The file is not a CSV file:";
    const FILE_IS_NOT_A_VALID_CSV = "The file is not a valid CSV file: ";

    
    // Validation
    const VALIDATION_REQUIRED = "required";
    const VALIDATION_TYPE = "type";
    const VALIDATION_MIN_LENGTH = "min_length";
    const VALIDATION_MAX_LENGTH = "max_length";
    const VALIDATION_UNIQUE = "unique";

    // Types
    const TYPE_STRING = "string";
    const TYPE_INTEGER = "integer";
    const TYPE_FLOAT = "float";
    const TYPE_BOOLEAN = "boolean";
    // const TYPE_ARRAY = "array";
    // const TYPE_OBJECT = "object";

}