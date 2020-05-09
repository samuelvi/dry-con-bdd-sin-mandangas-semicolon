<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\ScenarioInterface;
use Behat\Mink\Driver\Goutte\Client as GoutteClient;
use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Driver\PantherDriver;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use PHPUnit\Framework\Assert;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var Session */
    private $session;

    private $screenWidth = 1024;
    private $screenHeight = 2000;

    private static $defaultOptions = [
        'webServerDir' => __DIR__,
        'headless' => true,
        'environment' => 'test',
        'connection_timeout_in_ms' => 5000,
        'request_timeout_in_ms' => 120000,
        // 'browser' => PantherTestCase::CHROME,
        //'browser' => PantherTestCase::FIREFOX,
    ];

    /**
     * @BeforeScenario
     */
    public function initializeScenario(BeforeScenarioScope $scope)
    {
        $options = self::$defaultOptions;
        $options['browser'] = self::resolveBrowserConfigurationOption($scope->getScenario());
        $this->initializeSessionWithPantherDriver($options);
        // $this->initializeSessionWithGoutteDriver();
    }

    private static function resolveBrowserConfigurationOption(ScenarioInterface $scenarioNode)
    {
        return ($scenarioNode->hasTag('FIREFOX'))
            ? PantherTestCase::FIREFOX
            : PantherTestCase::CHROME;
    }

    private function initializeSessionWithPantherDriver(array $options)
    {
        $mink = new Mink([
            'panther' => new Session(new PantherDriver($options)),
        ]);

        $this->session = $mink->getSession('panther');
    }

    private function initializeSessionWithGoutteDriver()
    {
        $mink = new Mink([
            'goutte' => new Session(new GoutteDriver(new GoutteClient())),
        ]);

        $this->session = $mink->getSession('goutte');
    }

    /**
     * @throws Exception
     * @AfterScenario
     */
    public function finalizeScenario(AfterScenarioScope $scope)
    {
        $this->session->reset();
        $this->session->stop();
    }

    /**
     * @throws Exception
     * @AfterStep
     */
    public function takeScreenShotAfterFailedStep(afterStepScope $scope)
    {
        if (99 !== $scope->getTestResult()->getResultCode()) {
            return;
        }

        $driver = $this->session->getDriver();
        if (!($driver instanceof PantherDriver)) {
            return;
        }
        $this->iTakeAScreenshot("error");
    }

    /**
     * @When /^I visit wikipedia homepage in english$/
     */
    public function iVisitWikipediaHomepageInEnglish()
    {
        $this->visitUrl("https://en.wikipedia.org");
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSee($text)
    {
        $hasContent = $this->session->getPage()->hasContent($text);
        Assert::assertTrue($hasContent);
    }

    /**
     * @Then /^I should not see "([^"]*)"$/
     */
    public function iShouldNotSee($text)
    {
        $hasContent = $this->session->getPage()->hasContent($text);
        Assert::assertFalse($hasContent);
    }

    /**
     * @throws Exception
     * @Given /^I should see a popover with the text "([^"]*)"$/
     */
    public function iShouldSeeAPopoverWithTheText($text)
    {
        $hasContent = $this->session->getPage()->hasContent($text);
        Assert::assertTrue($hasContent);
    }

    /**
     * @Given /^I put the cursor over the "([^"]*)" text$/
     */
    public function iPutTheCursorOverTheText($text)
    {
        // OPCION A:
//        $node = $this->session->getPage()->find('css', '#mp-topbanner a');
//        try {
//            $node->mouseOver();
//        } catch (\Exception $e) {
//        }

        // OPCION B:
        $js = "
        var element = document.querySelector('#mp-topbanner a');
        var event = new MouseEvent('mouseover', {'view': window,'bubbles': true,'cancelable': true});
        element.dispatchEvent(event);
        ";

        $this->session->executeScript($js);

        // EN EL PANTALLAZO SE APRECIA CÓMO EL POPOVER TODAVÍA NO ES VISIBLE:
        // $this->iTakeAScreenshot('mouseover');

        // MALA PRAXIS, USAR "spins" en su lugar
        // sleep(3);

        $this->spins(function () {
            return $this->session->getPage()->hasContent('is a Multilingual');
        });
    }

    /** @throws Exception */
    private function spins($closure, $seconds = 5, $fraction = 4)
    {
        $max = $seconds * $fraction;
        $i = 1;
        while ($i++ <= $max) {
            if ($closure($this)) {
                return true;
            }
            $this->session->wait(1000 / $fraction);
        }

        $backtrace = debug_backtrace();
        throw new \Exception(
            sprintf("Timeout thrown by %s::%s()\n%s, line %s",
                $backtrace[0]['class'], $backtrace[0]['function'],
                $backtrace[0]['file'], $backtrace[0]['line']
            )
        );
    }

    /**
     * @Given /^I click on Language Settings$/
     */
    public function iClickOnLanguageSettings()
    {
        $languageSelector = $this->session->getPage()->find('css', '.uls-settings-trigger');
        $languageSelector->press();
    }

    private function visitUrl($url)
    {
        $this->session->visit($url);
        $this->session->getDriver()->resizeWindow($this->screenWidth, $this->screenHeight);
    }

    /**
     * @Given /^I take a screenshot$/
     */
    public function iTakeAScreenshot($prefix = 'screenshot')
    {
        $baseName = sprintf('%s-%s', $prefix, (new \DateTime())->format('Y_m_d_H_i_s'));
        file_put_contents(sprintf('%s/../../screenshots/%s.jpg', __DIR__, $baseName), $this->session->getScreenshot());
    }

    /**
     * @Given /^I wait (\d+) second(s)$/
     */
    public function iWaitSeconds($seconds)
    {
        $this->session->wait($seconds * 1000);
    }

    /**
     * @When I visit what is my browser
     */
    public function iVisitWhatIsMyBrowser()
    {
        $this->session->visit("https://www.whatismybrowser.com/");
    }
}
