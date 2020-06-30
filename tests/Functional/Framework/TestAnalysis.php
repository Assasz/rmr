<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Framework;

use OpenApi\Analysis;

final class TestAnalysis extends Analysis
{
    /**
     * Just skip validation for testing purpose
     */
    public function validate()
    {
    }
}
