<?php
if (function_exists('acf_add_local_field_group')) {
  acf_add_local_field_group(array(
    'key' => 'group_5c98faddc71d9',
    'title' => 'Mwb Social Share',
    'fields' => array(
      array(
        'key' => 'field_5c9a0ac55bd43',
        'label' => 'Include Button Shape',
        'name' => 'include_button_shape',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'hide_admin' => 0,
        'message' => '',
        'default_value' => 0,
        'ui' => 1,
        'ui_on_text' => '',
        'ui_off_text' => '',
      ),
      array(
        'key' => 'field_5c99233b7c340',
        'label' => 'Social Share Shape',
        'name' => 'social_share_shape',
        'type' => 'radio',
        'instructions' => 'Choose shape you want the social share icons to be or choose custom one',
        'required' => 0,
        'conditional_logic' => array(
          array(
            array(
              'field' => 'field_5c9a0ac55bd43',
              'operator' => '==',
              'value' => '1',
            ),
          ),
        ),
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'hide_admin' => 0,
        'choices' => array(
          'circle' => 'Circle',
          'square' => 'Square',
          'custom' => 'Custom',
        ),
        'allow_null' => 1,
        'other_choice' => 0,
        'default_value' => 'circle',
        'layout' => 'horizontal',
        'return_format' => 'value',
        'save_other_choice' => 0,
      ),
      array(
        'key' => 'field_5c98faf307a58',
        'label' => 'Social Share Selection',
        'name' => 'social_share_selection',
        'type' => 'select',
        'instructions' => 'Which Social Share to show in articles pages or any custom post type pages',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'hide_admin' => 0,
        'choices' => array(
          'blogger' => 'Blogger',
          'email' => 'Email',
          'evernote' => 'Evernote',
          'facebook' => 'Facebook',
          'google-plus' => 'Google Plus',
          'linkedin' => 'Linkedin',
          'pinterest' => 'Pinterest',
          'pocket' => 'Pocket',
          'reddit' => 'Reddit',
          'skype' => 'Skype',
          'tumblr' => 'Tumblr',
          'twitter' => 'Twitter',
          'whatsapp' => 'Whatsapp',
          'vk' => 'Vk',
          'buffer' => 'Buffer',
        ),
        'default_value' => array(),
        'allow_null' => 1,
        'multiple' => 1,
        'ui' => 1,
        'ajax' => 1,
        'return_format' => 'value',
        'placeholder' => '',
      ),
      array(
        'key' => 'field_5c99fbac8b640',
        'label' => 'Color Option',
        'name' => 'color_option',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'hide_admin' => 0,
        'choices' => array(
          'default' => 'Default Social Colors',
          'custom' => 'Custom Color',
        ),
        'allow_null' => 0,
        'other_choice' => 0,
        'default_value' => '',
        'layout' => 'horizontal',
        'return_format' => 'value',
        'save_other_choice' => 0,
      ),
      array(
        'key' => 'field_5c99fbf28b641',
        'label' => 'Social Button Color',
        'name' => 'social_button_color',
        'type' => 'color_picker',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
          array(
            array(
              'field' => 'field_5c99fbac8b640',
              'operator' => '==',
              'value' => 'custom',
            ),
          ),
        ),
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'hide_admin' => 0,
        'default_value' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'acf-options-social',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'modified' => 1553618691,
  ));
}
