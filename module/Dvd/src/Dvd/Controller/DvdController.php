<?php

namespace Dvd\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Dvd\Entity\Album;
use Dvd\Form\DvdForm;
use Doctrine\ORM\EntityManager;

class DvdController extends AbstractActionController
{
    /**            
     * @var Doctrine\ORM\EntityManager
     */                
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'dvds' => $this->getEntityManager()->getRepository('Dvd\Entity\Dvd')->findAll()
        ));
    }

    public function addAction()
    {
        $form = new DvdForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dvd = new Dvd();
            
            $form->setInputFilter($dvd->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $dvd->populate($form->getData());
                $this->getEntityManager()->persist($dvd);
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('dvd');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('dvd', array('action'=>'add'));
        }
        $dvd = $this->getEntityManager()->find('Dvd\Entity\Dvd', $id);

        $form = new DvdForm();
        $form->setBindOnValidate(false);
        $form->bind($dvd);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('dvd');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('dvd');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $dvd = $this->getEntityManager()->find('Dvd\Entity\Dvd', $id);
                if ($dvd) {
                    $this->getEntityManager()->remove($dvd);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of dvd's
            return $this->redirect()->toRoute('dvd');
        }

        return array(
            'id' => $id,
            'dvd' => $this->getEntityManager()->find('Dvd\Entity\Dvd', $id)
        );
    }
}
