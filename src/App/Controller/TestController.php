<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Foo;

class TestController
{
    public function test(Application $app)
    {
        if (true !== $app['debug']) {
            return $app->abort(404);
        }

        return $app->render('test.html.twig');
    }

    public function testFormHorizontal(Application $app)
    {
        $foo = new Foo();
        $form = $app['form.factory']->createBuilder('form', $foo)
            ->add('name')
            ->add('about')
            ->add('createdAt')
            ->add('parent')
            ->add('active')
            ->add('radio', 'choice', [
                'mapped'   => false,
                'expanded' => true,
                'choices'  => ['one', 'two'],
            ])
            ->add('checkbox', 'choice', [
                'mapped'   => false,
                'multiple' => true,
                'expanded' => true,
                'choices'  => ['one', 'two'],
            ])
            ->add('Save', 'button')
            ->getForm();

        return $app->render('test_form_horizontal.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
