<?php


namespace App\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Pagination
{
    private $entityClass;

    private $limit = 10;

    private $currentPage = 1;

    private $manager;

    private $twig;

    private $route;

    private $templatePath;


    /**
     * Pagination constructor.
     * @param ObjectManager $manager
     * @param Environment $environment
     * @param RequestStack $requestStack
     */
    public function __construct(ObjectManager $manager, Environment $environment, RequestStack $requestStack, $templatePath)
    {
        $this->route = $requestStack->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $environment;
        $this->templatePath = $templatePath;
    }

    /**
     * @param $entityClass
     * @return $this
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->currentPage = $page;
        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->currentPage;
    }

    /**
     * @param $route
     * @return $this
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $route;
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function display()
    {
        $this->twig->display('admin/partials/pagination.html.twig', [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }

    public function getPages()
    {
        // Get total element
        $repository = $this->manager->getRepository($this->entityClass);
        $total = count($repository->findAll());

        // Divide the total, round it up and send it back
        $pages = ceil($total / $this->limit);
        return $pages;
    }

    public function getData()
    {
        // Offset calculate
        $offset = $this->currentPage * $this->limit - $this->limit;

        // Get all elements in the repository
        $repository = $this->manager->getRepository($this->entityClass);
        $data = $repository->findBy([], [], $this->limit, $offset);

        // Return the elements
        return $data;
    }

    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
        return $this;
    }

    public function getTemplatePath()
    {
        return $this->templatePath;
    }

}