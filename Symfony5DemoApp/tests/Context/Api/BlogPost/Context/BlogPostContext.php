<?php

namespace App\Tests\Context\Api\BlogPost\Context;

use App\Repository\PostRepository;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

final class BlogPostContext extends RawMinkContext implements Context
{
    private int $numberOfBlogPosts;
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Given /^We have some blog posts$/
     */
    public function weHaveSomeBlogPosts()
    {
        $this->numberOfBlogPosts = (int)$this->postRepository->count([]);
    }

    /**
     * @Then /^I should get the total amount of blog posts$/
     */
    public function iShouldGetTheTotalAmountOfBlogPosts()
    {
        $jsonResponse = $this->getSession()->getPage()->getContent();

        $arrayResponse = json_decode($jsonResponse, true);
        Assert::assertArrayHasKey('count', $arrayResponse);

        Assert::assertEquals($this->numberOfBlogPosts, $arrayResponse['count']);
    }
}