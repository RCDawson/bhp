<?php
$config = array(
    'form/index' => array(
        array(
            'field'   => 'username',
            'label'   => 'Username',
            'rules'   => 'required|callback_username_check|min_length[6]'
        ),
        array(
            'field'   => 'password',
            'label'   => 'Password',
            'rules'   => 'required|min_length[7]'
        ),
        array(
            'field'   => 'passconf',
            'label'   => 'Password Confirmation',
            'rules'   => 'required|matches[password]'
        ),
        array(
            'field'   => 'active',
            'label'   => 'Active',
            'rules'   => '' // Required array member
        ),
        array(
            'field'   => 'activeasd',
            'label'   => 'Active',
            'rules'   => '' // Required array member
        )
    )
);