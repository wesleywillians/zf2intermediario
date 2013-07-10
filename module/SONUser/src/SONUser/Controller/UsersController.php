<?php

namespace SONUser\Controller;

use Zend\View\Model\ViewModel;

class UsersController extends CrudController 
{

    public function __construct() 
    {
        $this->entity = "SONUser\Entity\User";
        $this->form = "SONUser\Form\User";
        $this->service = "SONUser\Service\User";
        $this->controller = "users";
        $this->route = "sonuser-admin";
    }
 
     public function editAction()
    {
        $form = new $this->form();
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0))
        {
            $array = $entity->toArray();
            unset($array['password']);
            $form->setData($array);
        }
            
        
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
