
<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude(array(
        'vendor',
        'node_modules',
        'wp-admin',
        'wp-includes',
    ))
    ->notPath('wp-config.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setRules(array(
        '@PSR12' => true,

        // Arrays and strings
        'array_syntax' => array('syntax' => 'long'),
        'array_indentation' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => array(
            'elements' => array('arrays'),
        ),

        // Spaces and indentation
        'binary_operator_spaces' => array(
            'default' => 'single_space',
        ),
        'concat_space' => array(
            'spacing' => 'one',
        ),
        'method_argument_space' => array(
            'on_multiline' => 'ensure_fully_multiline',
        ),
        'no_extra_blank_lines' => array(
            'tokens' => array(
                'extra',
                'use',
                'curly_brace_block',
            ),
        ),
        'no_whitespace_in_blank_line' => true,
        'no_trailing_whitespace' => true,
        'statement_indentation' => true,

        // Imports
        'ordered_imports' => array(
            'sort_algorithm' => 'alpha',
        ),
        'no_unused_imports' => true,
    ))
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder);
