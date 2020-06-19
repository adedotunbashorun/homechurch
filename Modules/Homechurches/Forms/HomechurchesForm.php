<?php

namespace Modules\Homechurches\Forms;

use Kris\LaravelFormBuilder\Form;

class HomechurchesForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('church_id', 'select', [
                'label'=>'Church',
                'choices' => $this->getData('churches'),
                'empty_value' => '- Select Church -'
            ])
            ->add('users', 'select', [
                'label'=>'Users',
                'choices' => $this->getData('users'),
                'empty_value' => '- Select Members -',
                'multiple'=>true,
                'attr'=>[
                    'class'=>'form-control',
                    'multiple'=> true
                ]
            ])
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('Address', 'textarea')
            ->add('status', 'select', [
                'choices' => ['1' => 'live', '0' => 'draft'],
                'empty_value' => '- Select status -',
                'selected'=>1
            ]);
    }
}
