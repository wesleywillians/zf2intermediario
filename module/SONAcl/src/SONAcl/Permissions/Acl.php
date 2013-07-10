<?php

namespace SONAcl\Permissions;

use Zend\Permissions\Acl\Acl as ClassAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ClassAcl 
{

    protected $roles;
    protected $resources;
    protected $privileges;
    
    public function __construct(array $roles, array $resources, array $privileges) {
        
        
        $this->roles = $roles;
        $this->resources = $resources;
        $this->privileges = $privileges;
        
        $this->loadRoles();
        $this->loadResources();
        $this->loadPrivileges();
    }
    
    protected function loadRoles()
    {
        foreach($this->roles as $role)
        {
            if($role->getParent()) 
            {   
                $this->addRole(new Role($role->getNome()), new Role($role->getParent()->getNome()));
            }
            else
                $this->addRole (new Role($role->getNome()));
            
            if($role->getIsAdmin())
                $this->allow($role->getNome(),array(),array());
        }
    }
    
    protected function loadResources()
    {
        foreach($this->resources as $resource) 
        {
            $this->addResource(new Resource($resource->getNome()));
        }
    }
    
    protected function loadPrivileges()
    {
        foreach($this->privileges as $privilege)
        {
            $this->allow($privilege->getRole()->getNome(), $privilege->getResource()->getNome(),$privilege->getNome());
        }
    }
}
