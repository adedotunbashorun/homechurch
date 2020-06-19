<?php

namespace Modules\Announcements\Forms;

use Kris\LaravelFormBuilder\Form;

class AnnouncementsForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text',[
                'label'=>'Title',
                'attr'=>[
                    'class'=>'form-control','required'
                ]
            ])
            ->add('body', 'textarea',[
                'label'=>'Description',
                'attr'=>[
                    'class'=>'form-control','required',
                    'rows'=>2
                ]
            ])
            ->add('start_date', 'date',[
                'label'=>'Start Date',
                'attr'=>[
                    'class'=>'form-control','required',
                ]
            ])
            ->add('end_date', 'date',[
                'label'=>'End Date',
                'attr'=>[
                    'class'=>'form-control','required',
                ]
            ])
           
            ->add('status', 'select', [
                'choices' => ['1' => 'live', '0' => 'draft'],
                'empty_value' => '- Select status -',
                'selected'=>1
            ]);

            // ->add('image', 'file', [
            //     'label' => 'Document'
            // ]);
    }
}
