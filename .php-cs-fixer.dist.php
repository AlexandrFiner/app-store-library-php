<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    'array_syntax' => ['syntax' => 'short'],
    'normalize_index_brace' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_trailing_comma_in_singleline' => true,
    'trim_array_spaces' => true,
    'whitespace_after_comma_in_array' => true,
    'braces_position' => true,
    'encoding' => true,
    'no_multiple_statements_per_line' => true,
    'psr_autoloading' => true,
    'constant_case' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true,
    'magic_method_casing' => true,
    'magic_constant_casing' => true,
    'native_function_casing' => true,
    'lowercase_cast' => true,
    'no_short_bool_cast' => true,
    'short_scalar_cast' => true,
    'class_attributes_separation' => [
        'elements' => [
            'method' => 'one',
            'trait_import' => 'none',
        ],
    ],
    'class_definition' => true,
    'single_class_element_per_statement' => true,
    'self_accessor' => true,
    'visibility_required' => [
        'elements' => ['method', 'property'],
    ],
    'no_trailing_whitespace' => true,
    'control_structure_braces' => true,
    'control_structure_continuation_position' => true,
    'elseif' => true,
    'include' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'trailing_comma_in_multiline' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_spaces_after_function_name' => true,
    'no_unreachable_default_argument_value' => true,
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'no_leading_import_slash' => false,
    'no_unused_imports' => true,
    'declare_parentheses' => true,
    'blank_line_after_namespace' => true,
    'blank_lines_before_namespace' => [
        'max_line_breaks' => 2,
        'min_line_breaks' => 2,
    ],
    'no_leading_namespace_whitespace' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'increment_style' => ['style' => 'post'],
    'standardize_not_equals' => true,
    'ternary_operator_spaces' => true,
    'not_operator_with_successor_space' => false,
    'object_operator_without_whitespace' => true,
    'blank_line_after_opening_tag' => true,
    'full_opening_tag' => true,
    'linebreak_after_opening_tag' => true,
    'no_closing_tag' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_phpdoc' => true,
    'no_useless_return' => true,
    'no_empty_statement' => true,
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'no_singleline_whitespace_before_semicolons' => true,
    'space_after_semicolon' => true,
    'single_quote' => true,
    'indentation_type' => true,
    'line_ending' => true,
    'type_declaration_spaces' => true,
    'no_whitespace_in_blank_line' => true,
    'single_blank_line_at_eof' => true,
    'spaces_inside_parentheses' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'extra',
            'throw',
            'use',
        ],
    ],
];

return (new Config())->setRules($rules)
    ->setFinder(
        Finder::create()
            ->in(__DIR__),
    )
    ->setUsingCache(true)
    ->setRiskyAllowed(true);
