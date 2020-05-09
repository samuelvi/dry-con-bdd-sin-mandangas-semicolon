<?php

namespace App\Tests\Context\Frontend\Routing\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

final class RoutingContext extends RawMinkContext implements Context
{
    private $windowResized = false;

    /** @BeforeStep */
    public function initializeScreen(BeforeStepScope $scope)
    {

        if (!$this->getSession()->isStarted()) {
            return;
        }

        if (!$this->getSession()->getDriver() instanceof Selenium2Driver) {
            return;
        }

        if ($this->windowResized) {
            return;
        }

        if ($scope->getFeature()->hasTag('mobile')) {
            $this->getSession()->resizeWindow(480, 600);
        } else {
            $this->getSession()->resizeWindow(1024, 768);
        }

        $this->windowResized = true;
    }

    /**
     * @When /^I visit the homepage$/
     */
    public function iVisitTheHomepage()
    {
        $this->getSession()->visit('http://127.0.0.1:8000/en');
    }

    /**
     * @Then /^I should see the search input text$/
     */
    public function iShouldSeeTheSearchInputText()
    {
        $input = $this->getSession()->getPage()->find('css', '.search-field');

        $expected = 'Search for...';
        $actual = $input->getAttribute('placeholder');

        Assert::assertEquals($expected, $actual);
    }

    /**
     * @When /^I click on the drop\-down menu$/
     */
    public function iClickOnTheDropDownMenu()
    {
        $this->getSession()->getPage()->find('css', '.navbar-toggle')->click();
    }
}