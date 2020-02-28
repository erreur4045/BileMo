<?php

/**
 * Create by maxime
 * Date 2/21/2020
 * Time 3:32 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetPhonesResolver.php as GetPhonesResolver
 */

namespace App\Actions\Domain\Phones;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class GetPhonesResolver
{
    public const LIMIT_PER_PAGE = 10;
    /** @var PhoneRepository */
        private $phoneRepository;
    /** @var SerializerInterface */
        private $serializer;
    /** @var EntityManagerInterface */
        private $manager;
    /**
     * GetPhonesResolver constructor.
     * @param PhoneRepository $phoneRepository
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        PhoneRepository $phoneRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $manager
    ) {
        $this->phoneRepository = $phoneRepository;
        $this->serializer = $serializer;
        $this->manager = $manager;
    }


    public function resolve(Request $request)
    {
        $page = $request->query->getInt('page');
        $nbPhone = $this->manager->getRepository(Phone::class)->count([]);
        $nbMaxPage = ceil($nbPhone / GetPhonesResolver::LIMIT_PER_PAGE);
        if ($nbMaxPage > 1 && is_null($page)) {
            $page = 1;
        }
        if ($page > $nbMaxPage) {
            throw new BadRequestHttpException(
                sprintf(
                    'The requested page does not exist, last page is api/phones?page=%s',
                    $nbMaxPage
                ),
                null,
                Response::HTTP_BAD_REQUEST,
                ['Content-type' => 'application/json']
            );
        }
        $page == null ? $nextPage = 2 : $nextPage = $page + 1;
        /**
         * Generate the layout for all pages except first
         */
        if ($nbMaxPage > 1 and $page > 1) {
            $phones['pagination'] = [
                'first' => 'api/phones?page=1',
                'current' => "api/phones?page=" . $page,
                'last' => "api/phones?page=" . $nbMaxPage
            ];
            if ($page < $nbMaxPage) {
                $phones['pagination']['next_page'] = "api/phones?page=" . $nextPage;
            }
            $phones['phones'] = $this->phoneRepository->findBy(
                [],
                [],
                GetPhonesResolver::LIMIT_PER_PAGE,
                $page * GetPhonesResolver::LIMIT_PER_PAGE - GetPhonesResolver::LIMIT_PER_PAGE
            );
        } elseif ($nbMaxPage > 1 and $page === 1) {
            /** Generate the layout for the first page if pagination is necessary */
            $phones['pagination'] = [
                'current' => "api/phones?page=" . $page,
                'next' => "api/phones?page=" . $nextPage,
                'last' => "api/phones?page=" . $nbMaxPage
            ];
            $phones['phones'] = $this->phoneRepository->findBy(
                [],
                [],
                GetPhonesResolver::LIMIT_PER_PAGE
            );
        } else {
            $phones = $this->phoneRepository->findBy([], [], GetPhonesResolver::LIMIT_PER_PAGE);
        }
        $phonesNormalized =  $this->serializer->normalize($phones, 'json', ['groups' => 'phone_list']);
        return $phonesNormalized;
    }
}
