<?php

namespace App\Controller\Api;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/posts")
 */
final class BlogController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route(name="count_blog_posts", path="/count", methods={"GET"}))
     */
    public function count()
    {
        return $this->json([
            'count' => $this->postRepository->count([]),
        ]);
    }
}