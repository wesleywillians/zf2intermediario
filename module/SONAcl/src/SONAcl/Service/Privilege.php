<?php

namespace SONAcl\Service;

use SONBase\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Privilege extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = "SONAcl\Entity\Privilege";
    }
    
    public function insert(array $data)
    {
        $entity = new $this->entity($data);
        
        $role = $this->em->getReference("SONAcl\Entity\Role",$data['role']);
        $entity->setRole($role); // Injetando entidade carregada
        
        $resource = $this->em->getReference("SONAcl\Entity\Resource",$data['resource']);
        $entity->setResource($resource); // Injetando entidade carregada
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function update(array $data)
    {
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $role = $this->em->getReference("SONAcl\Entity\Role",$data['role']);
        $entity->setRole($role); // Injetando entidade carregada
        
        $resource = $this->em->getReference("SONAcl\Entity\Resource",$data['resource']);
        $entity->setResource($resource); // Injetando entidade carregada
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
}
