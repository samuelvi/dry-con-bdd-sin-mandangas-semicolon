<?php

namespace App\Tests\Context\Common\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;

class CommonContext extends RawMinkContext implements Context
{
    use CommonContextTrait;

    private string $kernelProjectDir;

    public function __construct($kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    /**
     * @throws \Exception
     * @AfterStep
     */
    public function takeScreenShotAfterFailedStep(AfterStepScope $scope)
    {
        if (99 !== $scope->getTestResult()->getResultCode()) {
            return;
        }

        if ($this->getSession()->getDriver() instanceof Selenium2Driver) {
            $this->iTakeAScreenshot("error");
        }
    }

    /**
     * @Given /^I take a screenshot$/
     */
    public function iTakeAScreenshot($prefix = 'screenshot')
    {
        $this->takeAScreenshot($this->kernelProjectDir, $prefix);
    }

    /**
     * @Given /^I wait (\d+) seconds$/
     */
    public function iWaitSeconds($seconds)
    {
        $this->getSession()->wait($seconds * 1000);
    }
}