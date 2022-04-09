<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Model;
use App\Form\Type\ImageType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModelAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class)
            ->add('SKU')
            ->add('sizes', ChoiceType::class, [
                'choices' => Model::SIZES,
                'multiple' => true,
            ])
            ->add('description')
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('name')
            ->add('SKU');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('name')
            ->add('images', CollectionType::class, [
                'template' => 'admin/model_list_field_image_file.html.twig',
            ])
            ->add('SKU')
            ->add('description');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('name')
            ->add('SKU')
            ->add('description')
            ->add('images', CollectionType::class, [
                'template' => 'admin/model_show_field_image_file.html.twig',
            ]);
    }
}
