<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account mb-5 pb-5" action=""
      method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

    <p class="woocommerce-form-row form-group form-row">
        <label for="account_first_name"><?php esc_html_e( 'Full name', 'woocommerce' ); ?>&nbsp;<span
                    class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name"
               id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>"/>
    </p>
    <p class="woocommerce-form-row form-group form-row d-none">
        <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span
                    class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name"
               id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>"/>
    </p>


    <p class="woocommerce-form-row form-group form-row d-none">
        <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span
                    class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name"
               id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>"/>
        <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
    </p>


    <p class="woocommerce-form-row form-group form-row ">
        <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span
                    class="required">*</span></label>
        <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email"
               id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>"/>
    </p>

    <p class="woocommerce-form-row form-group form-row">
        <label for="billing_phone">Phone</label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_phone"
               id="billing_phone" autocomplete="family-name"
               value="<?php echo esc_attr( get_user_meta( $user->ID, 'billing_phone', true ) ); ?>"/>
    </p>

    <p class="woocommerce-form-row form-group form-row">
        <label for="billing_address_1">Address</label>
        <input type="textarea" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1"
               id="billing_address_1" autocomplete="family-name"
               value="<?php echo esc_attr( get_user_meta( $user->ID, 'billing_address_1', true ) ); ?>"/>
    </p>

	<?php
	woocommerce_form_field( 'billing_country', [
		'type'        => 'country',
		'label'       => 'Country / Region',
		'required'    => true,
		'default'     => 'Select a country / region',
		'class'       => [ 'form-group' ],
		'input_class' => [ 'form-control' ]
	], get_user_meta( $user->ID, 'billing_country', true )
	);

	woocommerce_form_field( 'billing_company', [
		'type'        => 'text',
		'label'       => 'Company Name',
		'required'    => false,
		'class'       => [ 'form-group' ],
		'input_class' => [ 'form-control' ]
	], get_user_meta( $user->ID, 'billing_company', true )
	);

	woocommerce_form_field( 'billing_company_email', [
		'type'        => 'email',
		'label'       => 'Company Email',
		'required'    => false,
		'class'       => [ 'form-group' ],
		'input_class' => [ 'form-control' ]
	], get_user_meta( $user->ID, 'billing_company_email', true )
	);
	?>

    <div class="clear"></div>

    <fieldset class="edit-password my-4">
        <legend class="h5"><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>
        <div class="">
            <p class="woocommerce-form-row form-group form-row">
                <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                       name="password_current" id="password_current" autocomplete="off"/>
            </p>
            <p class="woocommerce-form-row  form-group form-row">
                <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                       name="password_1" id="password_1" autocomplete="off"/>
            </p>
            <p class="woocommerce-form-row form-group form-row">
                <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                       name="password_2" id="password_2" autocomplete="off"/>
            </p>
        </div>

    </fieldset>
    <div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

    <p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
        <button type="submit" class="woocommerce-Button button" name="save_account_details"
                value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
        <input type="hidden" name="action" value="save_account_details"/>
    </p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
