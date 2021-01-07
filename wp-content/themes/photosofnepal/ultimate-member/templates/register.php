<?php if (!defined('ABSPATH')) exit; ?>

<div class="registrations__container <?php echo esc_attr($this->get_class($mode)); ?> um-<?php echo esc_attr($form_id); ?>">

    <div class="registrations__right-panel" data-mode="<?php echo esc_attr($mode) ?>">
        <div class="registrations__right-panel-header">
            <h2>JOIN PHOTOSOFNEPAL</h2>
            <p>Already have an accounnt? <a href="<?= get_site_url() ?>/login">Login</a></p>
        </div>
        <div class="registrations__right-panel-body">
            <div class="registrations__form-wrapper mb-5">
                <form method="post" action="">

                    <?php
                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_before_form
                     * @description Some actions before register form
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Register form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_before_form', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_before_form', 'my_before_form', 10, 1 );
                     * function my_before_form( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_before_form", $args);

                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_before_{$mode}_fields
                     * @description Some actions before register form fields
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Register form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_before_{$mode}_fields', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_before_{$mode}_fields', 'my_before_fields', 10, 1 );
                     * function my_before_form( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_before_{$mode}_fields", $args);

                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_before_{$mode}_fields
                     * @description Some actions before register form fields
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Register form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_before_{$mode}_fields', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_before_{$mode}_fields', 'my_before_fields', 10, 1 );
                     * function my_before_form( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_main_{$mode}_fields", $args);

                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_after_form_fields
                     * @description Some actions after register form fields
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Register form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_after_form_fields', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_after_form_fields', 'my_after_form_fields', 10, 1 );
                     * function my_after_form_fields( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action('um_after_form_fields', $args);

                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_after_{$mode}_fields
                     * @description Some actions after register form fields
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Register form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_after_{$mode}_fields', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_after_{$mode}_fields', 'my_after_form_fields', 10, 1 );
                     * function my_after_form_fields( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_after_{$mode}_fields", $args);

                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_after_form
                     * @description Some actions after register form fields
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Register form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_after_form', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_after_form', 'my_after_form', 10, 1 );
                     * function my_after_form( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_after_form", $args); ?>

                </form>
            </div>
        </div>
    </div>
    <div class="registrations__left-panel"
         style="background-image: url('<?= get_template_directory_uri() ?>/assets/images/11.jpg');">
    </div>

</div>