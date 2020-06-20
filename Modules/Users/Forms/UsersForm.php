<?php namespace Modules\Users\Forms;

use Kris\LaravelFormBuilder\Form;

class UsersForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('first_name', 'text',[
                'label'=>'First Name',
                'attr'=>[
                    'class'=>'form-control','required'
                ]
            ])
            ->add('last_name', 'text',[
                'label'=>'Last Name',
                'attr'=>[
                    'class'=>'form-control','required'
                ]
            ])
            ->add('username', 'text',[
                'label'=>'Username',
                'attr'=>[
                    'class'=>'form-control','required'
                ]
            ])
            ->add('phone', 'text',[
                'label'=>'Phone Number',
                'attr'=>[
                    'class'=>'form-control','required'
                ]
            ])
            ->add('birthday', 'date',[
                'label'=>'Date of Birth',
                'attr'=>[
                    'class'=>'form-control','required'
                ]
            ])
            ->add('address', 'textarea',[
                'label'=>'Address',
                'attr'=>[
                    'class'=>'form-control','required',
                    'rows'=>2
                ]
            ])
            ->add('email', 'text',[
                'attr'=>[
                    'class'=>'form-control','required'
                ]
            ])
            ->add('gender', 'select', [
                'label'=>'Gender',
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female'
                ],
                'selected'=>0,
                'expanded' => true,
                'multiple' => false
            ])
            ->add('country_id', 'select', [
                'label'=>'Country',
                'choices' => !empty($this->getData('countries')) ? $this->getData('countries') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'selected'=>0,
                'expanded' => true,
                'multiple' => false
            ])
            ->add('password', 'password',[
                'attr'=>[
                    'class'=>'form-control required',
                    'value'=>''
                ]
            ])
            ->add('confirm_password', 'password',[
                'label'=>'Confirm Password',
                'attr'=>[
                    'class'=>'form-control required'
                ]
            ])
           /* ->add('roles', 'select',[
                'label'=>'Parent',
                'empty_value'=>'-- select roles --',
                'choices'=>$this->getData('roles'),
                'multiple'=>true
            ])*/
            ->add('activated', 'choice', [
                'label'=>'Activated?',
                'choices' => [
                    0 => 'No',
                    1 => 'Yes'
                ],
                'selected'=>0,
                'expanded' => true,
                'multiple' => false
            ])

            ->add('avatar', 'file', [
                'label' => 'Avatar'
            ])
            ->add('type', 'select', [
                'label'=>'Type',
                'choices' => [
                    'groupchat' => 'Group Chats',
                    'homechurch' => 'Home Cells',
                    'church' => 'Local Church',
                    'area' => 'Area Church',
                    'zone' => 'Zonal Church',
                    'district' => 'District Church',
                    'state' => 'State Church',
                    'region' => 'Regional Church',
                    'country' => 'National Church'
                ],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select Type -'
            ])
            ->add('homechurch_group', 'select', [
                'label'=>'Role',
                'choices' => [
                    'homechurch' => 'Homechurch Leader',
                    'church' => 'Homechurch Local Leader',
                    'area' => 'Homechurch Area Leader',
                    'zone' => 'Homechurch Zonal Leader',
                    'district' => 'Homechurch District Leader',
                    // 'state' => 'Homechurch State Leader',
                    // 'region' => 'Homechurch Region Leader'
                ],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select Type -'
            ])
            ->add('homechurch_id', 'select', [
                'label'=>'Home Cell',
                'choices' => !empty($this->getData('homechurches')) ? $this->getData('homechurches') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select Homecell -'
            ])
            ->add('homechurches_id', 'select', [
                'label'=>'Home Cell',
                'choices' => !empty($this->getData('homechurches')) ? $this->getData('homechurches') : [],
                'empty_value' => '- Select Homecell -',
                'attr'=>[
                    'class'=> 'form-control required row select2',
                    'multiple' => true,
                    'required'=> 'required'
                ],
            ])
            ->add('groupchat_id', 'select', [
                'label'=>'Online Chat',
                'choices' =>  !empty($this->getData('groupchats')) ? $this->getData('groupchats') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select Onlinechat -'
            ])
            ->add('church_id', 'select', [
                'label'=>'Dunamis Local Church',
                'choices' => !empty($this->getData('churches')) ? $this->getData('churches') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select church -'
            ])
            ->add('area_id', 'select', [
                'label'=>'Area',
                'choices' => !empty($this->getData('areas')) ? $this->getData('areas') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select Area -'
            ])
            ->add('zone_id', 'select', [
                'label'=>'Zone',
                'choices' => !empty($this->getData('zones')) ? $this->getData('zones') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select church -'
            ])
            ->add('district_id', 'select', [
                'label'=>'Districts',
                'choices' => !empty($this->getData('districts')) ? $this->getData('districts') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select District -'
            ])
            ->add('state_id', 'select', [
                'label'=>'State',
                'choices' => !empty($this->getData('states')) ? $this->getData('states') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select State -'
            ])
            ->add('region_id', 'select', [
                'label'=>'Region',
                'choices' => !empty($this->getData('regions')) ? $this->getData('regions') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select Region -'
            ])
            ->add('status', 'select', [
                'label'=>'Is Active?',
                'choices' => [
                    0 => 'No',
                    1 => 'Yes'
                ],
                'empty_value' => '- Select Status -'
            ])
            ->add('church', 'select', [
                'label'=>'Local Church',
                'choices' => !empty($this->getData('churches')) ? $this->getData('churches') : [],
                'attr'=>[
                    'class'=>'form-control required row select2',
                    // 'required'=>'required'
                ],
                'empty_value' => '- Select church -'
            ])
            ->add('groups', 'select', [
                'label'=>'Hierarchy',
                'choices' => [],
                'empty_value' => '- Select Hierarchy -',
                'attr'=>[
                    'id' => 'groups',
                    'class'=> 'form-control select2',
                    // 'multiple' => true,
                ],
            ]);

    }
}