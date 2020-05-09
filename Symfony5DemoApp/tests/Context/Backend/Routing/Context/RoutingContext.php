<?php

namespace App\Tests\Context\Backend\Routing\Context;

use App\Entity\Post;
use App\Tests\Context\Common\Context\CommonContextTrait;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;

final class RoutingContext extends RawMinkContext implements Context
{
    use CommonContextTrait;

    private $windowResized = false;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /** @BeforeScenario */
    public function cleanData()
    {
        $postEntity = $this->em->getRepository(Post::class)->findOneBy(['title' => 'The internet of cats']);
        if ($postEntity instanceof Post) {
            $this->em->getConnection()->executeQuery('delete from symfony_demo_post_tag where post_id = :post_id', ['post_id' => $postEntity->getId()]);

            $this->em->remove($postEntity);
            $this->em->flush();
        }
    }

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
     * @When I click on the delete icon
     */
    public function iClickOnTheDeleteIcon()
    {
        // Buscamos primero en el contenedor, puesto que en la página hay 2 fa-trash
        // y el primero es el del modal y está hidden y peta al hacer click
        // Importante @javascript, sino no se intepretará javascript (excepto si se modifica en config default_session: symfony)
        $this->getSession()->getPage()
            ->findById('delete-form')
            ->find('css', '.fa-trash')
            ->click()
        ;
    }

    /**
     * @Then /^I should see a modal asking "([^"]*)"$/
     * @throws \Exception
     */
    public function iShouldSeeAModalAsking($expected)
    {
        $titleNodeElement = null;
        $closure = function (self $context) use ($expected, &$titleNodeElement) {
            $actual = $this->getSession()->getPage()->findById('confirmationModal');
            if (!$actual->isVisible()) {
                return false;
            }
            $titleNodeElement = $actual->find('css', '.modal-body h4');
            return $titleNodeElement->getText() == $expected;
        };
        $this->spins($closure);

        Assert::assertEquals($expected, $titleNodeElement->getText());
    }

    /**
     * @Given /^I should not see the modal$/
     * @throws \Exception
     */
    public function iShouldNotSeeAModalAsking()
    {
        $closure = function (self $context) {
            $isVisible = $context->getSession()->getPage()->findById('confirmationModal')->isVisible();
            echo $isVisible ? 'el modal todavía es visible' : 'el modal ya no es visible';
            return !$isVisible;
        };
        $this->spins($closure);
    }

    /**
     * @When /^I log in as admin user$/
     */
    public function iLogInAsAdminUser()
    {
        $this->getSession()->visit('http://127.0.0.1:8000/en/login');
        $this->getSession()->getPage()->findField('Username')->setValue('jane_admin');
        $this->getSession()->getPage()->findById('password')->setValue('kitten');
        $this->getSession()->getPage()->find('css', 'button[type="submit"]')->press();
    }

    /**
     * @Given /^I fill in Tags with "([^"]*)"$/
     */
    public function iFillInTagsWith($tags)
    {
        // NO FUNCIONA EN CHROME DRIVER - SELENIUM SI
        // $this->getSession()->getPage()->find('css', '.bootstrap-tagsinput .tt-input')->setValue($tags);

        // FUNCIONA EN CHROME DRIVER
        $js = sprintf('document.getElementById("post_tags").value="%s";', $tags);
        $this->getSession()->executeScript($js);
    }

    /**
     * @Given /^I scroll to the Save Buttons$/
     */
    public function iScrollToButtons()
    {
        $js = "
            var myElement = document.getElementById('post_saveAndCreateNew');
            var topPos = myElement.offsetTop;
            document.getElementById('post_saveAndCreateNew').scrollTop = topPos;
        ";

        $this->getSession()->getDriver()->executeScript($js);
    }
}