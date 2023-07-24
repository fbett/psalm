<?php

declare(strict_types=1);

namespace Psalm\Tests\Internal\Analyzer\Statements\Expression\Fetch;

use Psalm\Tests\TestCase;
use Psalm\Tests\Traits\InvalidCodeAnalysisTestTrait;
use Psalm\Tests\Traits\ValidCodeAnalysisTestTrait;

final class ArrayFetchAnalyzerTest extends TestCase
{
    use InvalidCodeAnalysisTestTrait;
    use ValidCodeAnalysisTestTrait;

    public function providerValidCodeParse(): iterable
    {
        return [
            'issue-10038-accessing-an-existing-key-using-increment' => [
                'code' => '<?php

                    $test = [];
                    $test[] = "Test";
                    $test[] = "Test";
                    $test[] = "Test";

                    $i = 0;
                    echo $test[$i++];
                    echo $test[$i++];
                    echo $test[$i++];
                    ',
                'assertions' => [],
                'ignored_issues' => [],
                'php_version' => '8.1',
            ],
            'issue-10038-accessing-an-existing-key-using-increment-defined-keys' => [
                'code' => '<?php

                    $test = [];
                    $test[0] = "Test";
                    $test[1] = "Test";
                    $test[2] = "Test";

                    $i = 0;
                    echo $test[$i++];
                    echo $test[$i++];
                    echo $test[$i++];
                    ',
                'assertions' => [],
                'ignored_issues' => [],
                'php_version' => '8.1',
            ],
            'issue-10038-accessing-an-existing-key-using-increment-loop-1-call' => [
                'code' => '<?php

                    $array2 = [];
                    $array2[] = "test";

                    foreach(["1", "2"] as $value) {
                        $i = 0;
                        echo $array2[$i++];
                    }
                    ',
                'assertions' => [],
                'ignored_issues' => [],
                'php_version' => '8.1',
            ],
            'issue-10038-accessing-an-existing-key-using-increment-loop-2-calls' => [
                'code' => '<?php

                    $array2 = [];
                    $array2[] = "test";
                    $array2[] = "test";

                    foreach(["1", "2"] as $value) {
                        $i = 0;
                        echo $array2[$i++];
                        echo $array2[$i++];
                    }
                    ',
                'assertions' => [],
                'ignored_issues' => [],
                'php_version' => '8.1',
            ],
        ];
    }

    public function providerInvalidCodeParse(): iterable
    {
        return [
            'issue-10038-accessing-a-non-existing-key' => [
                'code' => '<?php

                    $array2 = [];
                    $array2[] = "test";
                    $array2[] = "test";

                    foreach(["1", "2"] as $value) {
                        $i = 0;
                        echo $array2[$i++];
                        echo $array2[$i++];
                        echo $array2[$i++];
                    }
                    ',
                'error_message' => 'InvalidArrayOffset',
            ],
        ];
    }
}
