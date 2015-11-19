<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('post', 'textarea', array('label' => false,
                                            'attr' => array('placeholder' => 'Ваше сообщение...',
                                            'style' => "width: 100%; height: 50px;",
                                            'oninvalid' => "$('.alert-error').attr('style','display:true;'); $('.alert-error').text('Сообщение не может быть пустым.'); setCustomValidity('Пожалуйста заполните это поле.')",
                                            'onkeyup' => "try{setCustomValidity('')}catch(e){}")
                                            )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    public function getName()
    {
        return 'post';
    }
}