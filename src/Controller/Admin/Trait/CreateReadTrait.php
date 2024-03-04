<?php

namespace App\Controller\Admin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

trait CreateReadTrait
{
    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::EDIT, Action::DELETE)
                ->add(Crud::PAGE_INDEX, Action::DETAIL);

        return $actions;
    }
}