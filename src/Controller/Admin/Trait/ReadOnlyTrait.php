<?php

namespace App\Controller\Admin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

/**
 * @author Florent <bflorent53170@gmail.com>
 */

trait ReadOnlyTrait
{

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW, Action::EDIT, Action::DELETE)
                ->add(Crud::PAGE_INDEX, Action::DETAIL);
                
        return $actions;
    }
}