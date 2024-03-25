<?php

namespace App\Controller\Admin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */
trait CreateEditTrait
{
    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::DETAIL, Action::DELETE);
        return $actions;
    }
}