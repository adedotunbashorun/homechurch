<?php

namespace Modules\Homechurches\Forms;

use Kris\LaravelFormBuilder\Form;

class HomechurchesGroupForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text')
            ->add('type', 'select', [
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
                    'required'=>'required'
                ],
                'empty_value' => '- Select Type -'
            ])
            ->add('church_id', 'select', [
                'label'=>'Church',
                'choices' => $this->getData('churches'),
                'empty_value' => '- Select Church -'
            ])
            ->add('homechurches_id', 'select', [
                'label'=>'Home Cell',
                'choices' => !empty($this->getData('homechurches')) ? $this->getData('homechurches') : [],
                'empty_value' => '- Select Homecell -',
                'attr'=>[
                    'id' => 'homechurches_id',
                    'class'=> 'form-control required',
                    'multiple' => true,
                    'required'=> 'required'
                ],
            ]);
    }
}
