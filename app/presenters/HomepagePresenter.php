<?php

namespace App\Presenters;
use App\Model\UserManager;

use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var Nette\Database\Context */
    private $database;
    
    /** @var UsersManager */
    private $userManager;
    
    public function __construct(Nette\Database\Context $database, UserManager $userManager) /*UserManager $userManager*/
    {
        $this->database = $database;
        $this->userManager = $userManager;
    }
    
    public function renderDefault()
    {
        $this->template->users = $this->userManager->getUsers();
    }
}
