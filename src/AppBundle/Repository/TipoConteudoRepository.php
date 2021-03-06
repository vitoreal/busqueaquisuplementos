<?php

namespace AppBundle\Repository;
use AppBundle\Entity\TipoConteudo;
use Doctrine\ORM\EntityRepository;

/**
 * TipoConteudoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TipoConteudoRepository extends EntityRepository
{
    public function listarDados($aColumns, $sWhere, $request) {

        $query  =  $this->createQueryBuilder('s')
            ->select('s.id', 's.nome');
        //echo $query->getQuery()->getSQL(); exit;

        $iDisplayStart = $request->get('start');
        $iDisplayLength = $request->get('length');

        //echo $query->where($sWhere); exit;
        if (empty($sWhere)) {
            return $query->getMaxResults($iDisplayLength)->setFirstResult($iDisplayLength)->getQuery()->getArrayResult();
        }

        $result = $query->where($sWhere)
            ->setMaxResults($iDisplayLength)
            ->setFirstResult($iDisplayStart)
            ->getQuery()
            ->getArrayResult();

        return $result;

    }

    public function totalRegistroFiltro() {

        return $this->createQueryBuilder('s')
            ->select('count(s)')
            ->getQuery()->getSingleScalarResult();

    }

}