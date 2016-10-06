<?php

namespace APP\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LugarRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriaRepository extends EntityRepository {
/*
    public function findProyectos($parameters) {
        $qb = $this->createQueryBuilder('l');
        if ($parameters->get('simple_search')) {
            $fullName = $parameters->get('simple_search');
            $qb->where($qb->expr()->andX(
                            $qb->expr()->like('l.nombre', $qb->expr()->literal('%' . $fullName . '%'))
            ));
        }
        return $qb->getQuery()->getResult();
    }
*/
    public function findCategorias() {
        $qb = $this->createQueryBuilder('c');       
       
        return $qb->getQuery();
    }

}