<?php

if ( function_exists( 'register_block_style' ) ) {
    register_block_style(
        'core/buttons',
        array(
            'name'         => 'high-button',
            'label'        => __( 'High Button', 'the-high' ),
            'is_default'   => true,
            'inline_style' => '.wp-block-button.is-style-high-button { padding: 5px 12px; color: #5bb75a;, border: 2px solid #5bb75a; }',
        )
    );
}

 