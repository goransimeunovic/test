<?php

namespace App\Presenters;

use Nette;
use App\Model\UserManager;
use \Nette\Application\UI\Form;


class UserPresenter extends BasePresenter
{
    /** @var Nette\Database\Context */
    private $database;
    
    /** @var UserManager */
    private $userManager;
    
    /** User info @var type */
    private $userInfo;
    
    
    public function __construct(Nette\Database\Context $database, UserManager $userManager)
    {
        $this->database = $database;
        $this->userManager = $userManager;
    }
    
    
    /**
     * Add user
     */
    public function renderAdduser()
    {
        
    }
    
    
    public function renderEdituser($user_email)
    {
        $user_infos = $this->userManager->getUserbyEmail($user_email);
        
        foreach ($user_infos as $value){
            $this->userInfo['username'] = $value['user_name'];
            $this->userInfo['email'] = $value['email'];
            $this->userInfo['type'] = $value['type'];
        }
    }   
    
    
    /**
     * Vytvori formular pro pridani uzivatele
     * 
     * @return Form
     */
    protected function createComponentAddNewUser()
    {
        $form = new Form;
        
        
        $form->addEmail('email', '')->setDisabled(false)
        ->setRequired('Zadejte prosím email zakazníka!');
        
        $form->addText('username', '')->setDisabled(false);
        
        $type = array(
            "user" => "User",
            "moderator" => "Moderator",
            "admin" => "Admin"
        );
        
        $form->addSelect('type', '',$type)
        ->setDefaultValue($this->userInfo['type']);
        
       
        $form->addSubmit('send','Uložit');
        
        $form->onSuccess[] = [$this, 'addNewUser'];
        
        
        return $form;
    }
    
    
    public function addNewUser($form)
    {
        
        $this->userManager->insertNewUser($form->getValues());
     
        $this->redirect('Homepage:default');
        
    }
    
    
    /**
     * Vytvori formular pro pridani uzivatele
     * 
     * @return Form
     */
    protected function createComponentEditUser()
    {   
        $form = new Form;
        
        $form->addEmail('email', '')->setDisabled(false)
        ->setRequired('Zadejte prosím email zakazníka!')
        ->setValue($this->userInfo['email']);
        
        $form->addText('username', '')->setDisabled(false)
        ->setValue($this->userInfo['username']);
        
        $type = array(
            "user" => "User",
            "moderator" => "Moderator",
            "admin" => "Admin"
        );
        
        $form->addSelect('type', '',$type)
        ->setDefaultValue($this->userInfo['type'])
        ->setValue($this->userInfo['type']);
        
       
        $form->addSubmit('send','Uložit');
        
        $form->onSuccess[] = [$this, 'editUser'];
        
        
        return $form;
    }
    
    
    public function editUser($form)
    {
        
        $this->userManager->editUser($form->getValues());
     
        $this->redirect('Homepage:default');
        
    }
    
    
    public function actionDelete($user_email)
    {
        $this->userManager->deleteUser($user_email);
        $this->redirect('Homepage:default');
    }
  
}
