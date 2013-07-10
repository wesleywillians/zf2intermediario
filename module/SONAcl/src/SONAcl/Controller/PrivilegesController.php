<?php

namespace SONAcl\Controller;

use SONBase\Controller\CrudController;
use Zend\View\Model\ViewModel;

class PrivilegesController extends CrudController
{

    public function __construct() {
        $this->entity = "SONAcl\Entity\Privilege";
        $this->service = "SONAcl\Service\Privilege";
        $this->form = "SONAcl\Form\Privilege";
        $this->controller = "privileges";
        $this->route = "sonacl-admin/default";
    }
    
    public function newAction()
    {
        $form = $this->getServiceLocator()->get('SONAcl\Form\Privilege');
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());
                
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form));
    }
    
    public function editAction()
    {
        $form = $this->getServiceLocator()->get('SONAcl\Form\Privilege');
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0))
            $form->setData($entity->toArray());
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form));
    }
}
