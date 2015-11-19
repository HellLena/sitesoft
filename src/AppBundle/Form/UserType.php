<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => false,
                                            'attr' => array('placeholder' => 'Логин',
                                            'pattern' => "[a-zA-Z0-9]{5,}", 'maxlength' => "50",
                                            'title' => "Минимум 5 букв и/или цифр.", 'autofocus' => 'true',
                                            'oninvalid' => "setCustomValidity('Пожалуйста, заполните это поле.')",
                                            'onkeyup' => "try{setCustomValidity('')}catch(e){}")
                                            )
            )
            ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Пароли должны совпадать.',
                    'first_options'  => array('label' => false,
                                              'attr' => array('placeholder' => 'Пароль',
                                              'pattern' => "(?=^.{8,}$)((?=.*\\d)|(?=.*\\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$",
                                              'title' => "Пароль должен содержать минимум 8 символов, из них обязательно как минимум 1 цифра, 1 буква прописная, 1 буква строчная.",
                                              'oninvalid' => "setCustomValidity('Пожалуйста, заполните это поле.')",
                                              'onkeyup' => "try{setCustomValidity('')}catch(e){}")
                                              ),
                    'second_options' => array('label' => false,
                                              'attr' => array('placeholder' => 'Повторите пароль',
                                              'oninvalid' => "setCustomValidity('Пожалуйста, заполните это поле.')",
                                              'onkeyup' => "try{setCustomValidity('')}catch(e){}"))
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}