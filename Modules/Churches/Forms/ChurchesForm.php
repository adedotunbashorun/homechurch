<?php

namespace Modules\Churches\Forms;

use Kris\LaravelFormBuilder\Form;

class ChurchesForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('country_id', 'select', [
                'label'=>'Country',
                'choices' => $this->getData('countries'),
                'empty_value' => '- Select Country -'
            ])
            ->add('region_id', 'select', [
                'label'=>'Region',
                'choices' => $this->getData('regions'),
                'empty_value' => '- Select Region -'
            ])
            ->add('state_id', 'select', [
                'label'=>'States',
                'choices' => $this->getData('states'),
                'empty_value' => '- Select State -'
            ])
            ->add('district_id', 'select', [
                'label'=>'District',
                'choices' => $this->getData('districts'),
                'empty_value' => '- Select District -'
            ])
            ->add('zone_id', 'select', [
                'label'=>'Zones',
                'choices' => $this->getData('zones'),
                'empty_value' => '- Select Zones -'
            ])
            ->add('area_id', 'select', [
                'label'=>'Area',
                'choices' => $this->getData('areas'),
                'empty_value' => '- Select Area -'
            ])
            ->add('name', 'text');
    }
}