<?php

namespace Transgressions;

class TestNestedException
{
    /**
     * @throws \Exception
     */
    public function test(): void
    {
        $this->test2();
    }

    /**
     * @throws \Exception
     */
    private function test2(): void
    {
        $this->test3();
    }

    /**
     * @throws \Exception
     */
    private function test3(): void
    {
        $this->test4();
    }

    /**
     * @throws \Exception
     */
    private function test4(): void
    {
        $this->test5();
    }

    /**
     * @throws \Exception
     */
    private function test5(): void
    {
        $this->test6();
    }

    /**
     * @throws \Exception
     */
    private function test6(): void
    {
        throw new \Exception('Testing');
    }
}
