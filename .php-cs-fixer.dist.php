<?php

declare(strict_types=1);

return Camelot\CsFixer\Config::create()
    ->addRules(
        Camelot\CsFixer\Rules::create()
            ->risky()
            ->php73()
            ->phpUnit75()
    )
    ->addRules([
        '@PhpCsFixer:risky' => true,
        'header_comment' => [
            'header' => <<<'EOD'
This file is part of a Camelot Project package.

(c) The Camelot Project

For the full copyright and license information, please view the LICENSE file
that was distributed with this source code.
EOD
        ],
        'native_function_invocation' => [
            'include' => ['@compiler_optimized']
        ],
    ])
    ->in('src')
    ->in('tests')
;
