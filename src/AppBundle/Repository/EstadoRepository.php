<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Endereco;
use Doctrine\ORM\EntityRepository;

/**
 * EstadoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EstadoRepository extends EntityRepository
{
    public function loadByIdSiglaEstado($siglaEstado)
    {

        $qb = $this->createQueryBuilder('e')
            ->where('e.sigla = :siglaEstado')
            ->setParameter('siglaEstado', $siglaEstado)
            ->getQuery()
            ->getOneOrNullResult();

        return $qb;

    }


}