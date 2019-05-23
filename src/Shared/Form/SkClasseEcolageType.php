<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 5/23/19
 * Time: 9:21 AM
 */

namespace App\Shared\Form;


use App\Shared\Entity\SkClasseEcolage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkClasseEcolageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => SkClasseEcolage::class]);
    }
}