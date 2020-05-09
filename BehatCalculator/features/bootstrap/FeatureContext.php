<?php

use App\ScientificCalculator;
use App\StandardCalculator;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{
    private StandardCalculator $standardCalculator;
    private ScientificCalculator $scientificCalculator;
    private float $result;

    /**
     * @Given /^A standard calculator$/
     */
    public function aStandardCalculator() : void
    {
        $this->standardCalculator = new StandardCalculator();
    }

    /**
     * @Given /^A Scientific calculator$/
     */
    public function aScientificCalculator() : void
    {
        $this->scientificCalculator = new ScientificCalculator();
    }

    /**
     * @Then /^The result of the addition should be (\d+)$/
     * @Then /^The result of the square root should be (\d+)$/
     */
    public function theResultShouldBe($expected) : void
    {
        Assert::assertEquals($expected, $this->result);
    }

    /**
     * @When /^I add (\d+) plus (\d+)$/
     */
    public function iAddPlus($first, $second) : void
    {
        $this->result = $this->standardCalculator->add($first, $second);
    }

    /**
     * @When /^I calculate the square root of (\d+)$/
     */
    public function iCalculateTheSquareRootOf($number) : void
    {
        $this->result = $this->scientificCalculator->squareRoot($number);
    }
}