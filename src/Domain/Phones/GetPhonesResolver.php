<?php

/**
 * Create by maxime
 * Date 2/21/2020
 * Time 3:32 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetPhonesResolver.php as GetPhonesResolver
 */

namespace App\Domain\Phones;

use App\Entity\Phone;
use App\OwnTools\Back\CheckParams;
use App\OwnTools\Back\MakePagination;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class GetPhonesResolver
{

    /** @var PhoneRepository */
        private $phoneRepository;
    /** @var SerializerInterface */
        private $serializer;
    /** @var EntityManagerInterface */
        private $manager;
    /** @var MakePagination */
        private $paginator;
    /** @var CheckParams */
    private $checkParams;

    /**
     * GetPhonesResolver constructor.
     * @param PhoneRepository $phoneRepository
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param MakePagination $paginator
     * @param CheckParams $checkParams
     */
    public function __construct(
        PhoneRepository $phoneRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $manager,
        MakePagination $paginator,
        CheckParams $checkParams
    ) {
        $this->phoneRepository = $phoneRepository;
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->paginator = $paginator;
        $this->checkParams = $checkParams;
    }


    public function resolve(Request $request)
    {
        $page = $request->query->get('page');
        $nbPhone = $this->manager->getRepository(Phone::class)->count([]);
        $needPaginate = $nbPhone / MakePagination::LIMIT_PER_PAGE > 1 ? true : false;
        $this->checkParams->isValid($page, $nbPhone);
        $needPaginate == true ? $phones = $this->paginator->paginate($page, $nbPhone, $this->phoneRepository) : $phones = $this->phoneRepository->findBy([], [], MakePagination::LIMIT_PER_PAGE);
        $phonesNormalized =  $this->serializer->normalize($phones, 'json', ['groups' => 'phone_list']);

        return $phonesNormalized;
    }
}
