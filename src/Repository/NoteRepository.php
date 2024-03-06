<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Note>
 *
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * @return Note[] Returns an array of Note objects
     */
    public function getNotesOrderedByDate(): array
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function add(Note $note): void
    {
        $this->getEntityManager()->persist($note);
        $this->getEntityManager()->flush();
    }

    public function remove(Note $note): void
    {
        $this->getEntityManager()->remove($note);
        $this->getEntityManager()->flush();
    }

    public function findNotesByDescription($description)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.description = :description')
            ->setParameter('description', $description)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
