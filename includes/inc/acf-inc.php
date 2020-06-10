<?php
acf_add_local_field_group([
  'title' => 'Mwb Social Share',
  'key' => 'mwb_social_share',
  'fields' => [
    [
      'key' => 'mwb_social_group',
      'label' => 'Settings',
      'name' => 'mwb_social_group',
      'type' => 'group',
      'layout' => 'block',
      'sub_fields' => [
        [
          'key' => 'mwb_social_share_labels',
          'label' => 'Include Labels',
          'name' => 'include_labels',
          'instructions' => 'Show labels next to the social media logos',
          'type' => 'true_false',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
        ],
        [
          'key' => 'mwb_social_share_include_btn_shape',
          'label' => 'Include Button Shape',
          'name' => 'include_button_shape',
          'type' => 'true_false',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
        ],
        [
          'key' => 'mwb_social_share_shape',
          'label' => 'Social Share Shape',
          'name' => 'social_share_shape',
          'type' => 'radio',
          'instructions' => 'Choose shape you want the social share icons to be',
          'conditional_logic' => [
            [
              [
                'field' => 'mwb_social_share_include_btn_shape',
                'operator' => '==',
                'value' => '1',
              ],
            ],
          ],
          'choices' => [
            'circle' => 'Circle',
            'square' => 'Square',
          ],
          'allow_null' => 1,
          'layout' => 'horizontal',
          'return_format' => 'value',
        ],
        [
          'key' => 'mwb_social_share_social_media',
          'label' => 'Social Share Selection',
          'name' => 'social_share_selection',
          'type' => 'select',
          'instructions' => 'Which Social Share to show in articles pages or any custom post type pages',
          'required' => 0,
          'choices' => [
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
            'wordpress' => 'Wordpress',
            'delicious' => 'Delicious'
          ],
          'allow_null' => 1,
          'multiple' => 1,
          'ui' => 1,
          'ajax' => 1,
          'return_format' => 'value',
        ],
        [
          'key' => 'mwb_social_share_color_option',
          'label' => 'Color Option',
          'name' => 'color_option',
          'type' => 'radio',
          'choices' => [
            'default' => 'Default Social Colors',
            'custom' => 'Custom Color',
          ],
          'allow_null' => 0,
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ],
        [
          'key' => 'mwb_social_share_btn_color_option',
          'label' => 'Social Button Color',
          'name' => 'social_button_color',
          'type' => 'color_picker',
          'conditional_logic' => [
            [
              [
                'field' => 'mwb_social_share_color_option',
                'operator' => '==',
                'value' => 'custom',
              ],
            ],
          ],
        ],
      ]
    ],
  ],
  'location' => [
    [
      [
        'param' => 'options_page',
        'operator' => '==',
        'value' => 'mwb-social-share-settings',
      ],
    ],
  ],
  'position' => 'normal',
  'style' => 'default',
  'active' => true,
  'modified' => 1553618691,
]);
