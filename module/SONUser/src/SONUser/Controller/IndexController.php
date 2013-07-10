<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use SONUser\Form\User as FormUser;

class IndexController extends AbstractActionController
{
    public function registerAction() 
    {
        $form = new FormUser;
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get("SONUser\Service\User");
                if($service->insert($request->getPost()->toArray())) 
                {
                    $fm = $this->flashMessenger()
                            ->setNamespace('SONUser')
                            ->addMessage("Usuário cadastrado com sucesso");
                }
                
                return $this->redirect()->toRoute('sonuser-register');
            }
        }
        
        $messages = $this->flashMessenger()
                ->setNamespace('SONUser')
                ->getMessages();
        
        return new ViewModel(array('form'=>$form,'messages'=>$messages));
    }
    
    public function activateAction()
    {
        $activationKey = $this->params()->fromRoute('key');
        
        $userService = $this->getServiceLocator()->get('SONUser\Service\User');
        $result = $userService->activate($activationKey);
        
        if($result)
            return new ViewModel(array('user'=>$result));
        else
            return new ViewModel();
    }
}
