<?php

/**
 * Create by maxime
 * Date 2/28/2020
 * Time 1:30 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : MakePagination.php as MakePagination
 */

namespace App\OwnTools\Back;

use App\Repository\PhoneRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class MakePagination
{
    public const LIMIT_PER_PAGE = 10;
    /** @var RequestStack */
        private $request;
    /** @var PhoneRepository */
        private $phoneRepository;
    /** @var RouterInterface */
        private $router;
    /**
     * MakePagination constructor.
     * @param RequestStack $request
     * @param PhoneRepository $phoneRepository
     * @param RouterInterface $router
     */
    public function __construct(
        RequestStack $request,
        PhoneRepository $phoneRepository,
        RouterInterface $router
    )
    {
        $this->request = $request;
        $this->phoneRepository = $phoneRepository;
        $this->router = $router;
    }


    public function paginate($page, $nbItems, $repository, $paramsUri = null)
    {
        $dataClassName = $this->getClass($repository);
        $routeName = $this->request->getMasterRequest()->attributes->get('_route');
        $UriBase = $paramsUri != null ? $this->router->generate($routeName, ['client_id' => $paramsUri]) : $this->router->generate($routeName);
        $nbMaxPage = ceil($nbItems / self::LIMIT_PER_PAGE);
        /**
         * init vars for the first page else for others
         */
        if ($nbMaxPage > 1 && is_null($page)) {
            $page = 1;
            $nextPage = 2;
        } else {
            $nextPage = $page + 1;
        }

        /**
         * Generate the layout for all pages except first
         */
        if ($nbMaxPage > 1 && $page > 1) {
            $dataPaging['pagination'] = [
                'first' => $UriBase . '?page=' . 1,
                'current' => $this->request->getCurrentRequest()->getRequestUri(),
                'last' => $UriBase . '?page=' . $nbMaxPage
            ];
            if ($page < $nbMaxPage) {
                $dataPaging['pagination']['next_page'] = $UriBase . '?page=' . $nextPage;
            }
            $dataPaging[$dataClassName] = $repository->findBy(
                [],
                [],
                self::LIMIT_PER_PAGE,
                $page * self::LIMIT_PER_PAGE - self::LIMIT_PER_PAGE
            );
        } elseif ($nbMaxPage > 1 && $page == 1) {
        /** Generate the layout for the first page if pagination is necessary */
            $dataPaging['pagination'] = [
                'current' => $this->request->getCurrentRequest()->getRequestUri(),
                'next' => $UriBase . '?page=' . $nextPage,
                'last' => $UriBase . '?page=' . $nbMaxPage
            ];
            $dataPaging[$dataClassName] = $repository->findBy([], [], self::LIMIT_PER_PAGE);
        } else {
            $dataPaging = $repository->findBy([], [], self::LIMIT_PER_PAGE);
        }
        return $dataPaging;
    }

    private function getClass($repository)
    {
        $path = explode('\\', get_class($repository));
        $className = str_replace('Repository', '', $path[2]);
        return $className;
    }
}
