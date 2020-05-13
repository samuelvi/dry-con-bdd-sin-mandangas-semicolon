<?php

use Behat\Behat\Context\Context;
use Behat\Mink\Driver\Goutte\Client as GoutteClient;
use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var Session */
    private $session;

    /**
     * @BeforeScenario
     */
   public function initializeScenario()
    {
        $this->initializeSession();
    }

    /**
     * @When /^I visit the wikipedia homepage in spanish$/
     */
    public function visitWikiInSpanish()
    {
//        $this->initializeSession();
        $this->session->visit("https://es.wikipedia.org");
    }

    /**
     * @When /^I visit the wikipedia homepage in english$/
     */
    public function visitWikiInEnglish()
    {
//        $this->initializeSession();
        $this->session->visit("https://en.wikipedia.org");
    }

    # Este paso se puede saltar si gestionamos la configuración en behat.yml
    private function initializeSession()
    {
        $mink = new Mink([
            'goutte' => new Session(new GoutteDriver(new GoutteClient())),
        ]);

        $this->session = $mink->getSession('goutte');
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSee($text)
    {
        $hasContent = $this->session->getPage()->hasContent($text);
        Assert::assertTrue($hasContent);
    }
}