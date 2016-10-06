<?php

namespace APP\UsuarioBundle\Entity;

use Doctrine\ORM\EntityRepository;

use APP\UsuarioBundle\Entity\Perfil;

/**
 * PerfilRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PerfilRepository extends EntityRepository
{
    /*public function findAll() {
        return $this->getEntityManager()
                ->createQuery("SELECT p
                    FROM UsuarioBundle:Perfil p 
                    WHERE p.id != ".Perfil::ADMINISTRADOR)
                ->getResult();
        
    }*/
    
    public function findByActivo($activo) {
        return $this->getEntityManager()
                ->createQuery("SELECT p 
                    FROM UsuarioBundle:Perfil p 
                    WHERE p.id != ".Perfil::ADMINISTRADOR." 
                    AND p.activo = :activo")
                ->setParameter('activo', $activo)
                ->getResult();
    }
}