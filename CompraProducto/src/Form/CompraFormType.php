<?php

/**
 * La colección de productos me está complicando la vida. Los dejaré para el final: 
 * ->add('productoscomprados', CollectionType::class, array(
 *               'entry_type' => EntityType::class, 
 *               'entry_options' => [
 *                   'class' => Producto::class,
 *                   'choice_label' => 'nombre',
 *               ]))
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Producto;

class CompraFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('fecha', DateType::class)
            ->add('productoscomprados', EntityType::class, array(
                    'class' => Producto::class,
                    'choice_label' => 'nombre',
                    'multiple' => true,
                    'expanded' => true,))
            ->add('save', SubmitType::class, array('label' => 'Enviar'));
    }
}

