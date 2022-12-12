<?php

namespace App\Repository;

use App\Entity\Avatar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @extends ServiceEntityRepository<Avatar>
 *
 * @method Avatar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avatar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avatar[]    findAll()
 * @method Avatar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvatarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private ContactRepository $contactRepository)
    {
        parent::__construct($registry, Avatar::class);
    }

    public function save(Avatar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Avatar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $data, mixed $file): Avatar
    {
        if (!$data['contact'])
            throw new BadRequestException('Veuillez renseigner un contact');

        $contact = $data['contact'] ? $this->contactRepository->find($data['contact']) : null;
        if ($data['contact'] && $contact === null)
            throw new BadRequestException('Contact introuvable');

        $avatar = new Avatar();
        $avatar->setFile($file);
        $avatar->setContact($contact);
        $this->add($avatar);
        return $avatar;
    }

    /**
     * @throws Exception
     */
    public function update(Avatar $files, mixed $file): Avatar
    {
        $files->setFile($file);
        $this->add($files);

        return $files;

    }

}
