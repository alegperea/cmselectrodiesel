<?php

namespace APP\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use \Symfony\Component\OptionsResolver\OptionsResolver;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use \Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', EntityType::class, array(
                    'attr' => array(
                        'class' => 'select2_single form-control col-md-7 col-xs-12',
                    ),
                    'class' => 'AppBundle:Category',
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')->orderBy('c.title', 'ASC');
            },
                ))
                ->add('code', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('introText', TextareaType::class, array('attr' => array('class' => 'form-control')))
                ->add('fullText', TextareaType::class, array('attr' => array('class' => 'form-control')))
                ->add('price', IntegerType::class, array('attr' => array('class' => 'form-control')))
                ->add('equivalences', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('mark', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('equivalences', TextareaType::class, array('attr' => array('class' => 'form-control')));
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'APP\AppBundle\Entity\Product'
        ));
    }

    public function getName() {
        return 'app_appbundle_vehiculo';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'APP\AppBundle\Entity\Product',
        ));
    }

}
