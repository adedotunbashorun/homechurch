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
            ->add('group', 'select', [
                'label'=>'Role',
                'choices' => [
                    'homechurch' => 'Homechurch Leader',
                    'church' => 'Homechurch Local Leader',
                    'area' => 'Homechurch Area Leader',
                    'zone' => 'Homechurch Zonal Leader',
                    'district' => 'Homechurch District Leader',
                    'state' => 'Homechurch State Leader',
                    'region' => 'Homechurch Region Leader'
                ],
                'attr'=>[
                    'class'=>'form-control required',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select Type -'
            ])
            ->add('homechurches_id', 'select', [
                'label'=>'Home Cell',
                'choices' => !empty($this->getData('homechurches')) ? $this->getData('homechurches') : [],
                'empty_value' => '- Select Homecell -',
                'attr'=>[
                    'class'=> 'form-control required',
                    'multiple' => true,
                    'required'=> 'required'
                ],
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
