<?php


namespace App\Service;


use Doctrine\Common\Persistence\ObjectManager;

class Pagination
{
    private $entityClass;

    private $limit = 10;

    private $currentPage = 1;

    private $manager;


    /**
     * Pagination constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
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
}