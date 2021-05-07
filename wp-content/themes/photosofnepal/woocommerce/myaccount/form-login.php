<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>
<div class="registrations__container">
    <div class="registrations__right-panel" id="customer_login">
        <div class="registrations__right-panel-header text-center">
            <h2>JOIN PHOTOSOFNEPAL</h2>
        </div>

        <div class="registrations__right-panel-body">

            <ul class="nav nav-tabs justify-content-center mb-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab"
                       aria-controls="login" aria-selected="true">Login</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                       aria-controls="register" aria-selected="false">Register</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
				<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">

					<?php endif; ?>
                    <div class="login-wrapper">
                        <div class="login-form">
                            <div class="registrations__right-panel-body">
                                <div class="registrations__form-wrapper mb-5">
                                    <form method="post">
                                        <div class="row">
											<?php do_action( 'woocommerce_login_form_start' ); ?>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="username">Email
                                                        &nbsp;<span
                                                                class="required">*</span></label>
                                                    <input type="text"
                                                           class="form-control"
                                                           name="username"
                                                           id="username" autocomplete="username"
                                                           value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
                                                           required/><?php // @codingStandardsIgnoreLine ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>
                                                        &nbsp;<span
                                                                class="required">*</span></label>
                                                    <input class="form-control"
                                                           type="password"
                                                           name="password"
                                                           id="password" autocomplete="current-password" required/>
                                                </div>
                                            </div>
											<?php do_action( 'woocommerce_login_form' ); ?>

                                            <p class="form-row">
                                                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                                                    <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                                                           name="rememberme"
                                                           type="checkbox" id="rememberme" value="forever"/>
                                                    <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                                                </label>
                                            </p>
                                            <div class="col-lg-12">
												<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                                                <button type="submit"
                                                        class="btn btn-primary w-100"
                                                        name="login"
                                                        value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
                                            </div>
                                            <div class="text-center col-lg-12 mt-4">
                                                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                                            </div>

											<?php do_action( 'woocommerce_login_form_end' ); ?>

                                            <div class="seperate my-4 text-uppercase text-center font-weight-bold">or
                                            </div>
                                            <div class="login-option">
                                                <ul>
                                                    <li>
                                                        <a href="https://imagepasal.com/wp-login.php?loginSocial=facebook"
                                                           data-plugin="nsl" data-action="connect"
                                                           data-redirect="current" data-provider="facebook"
                                                           data-popupwidth="475" data-popupheight="175"
                                                           class="fab fa-facebook-f mr-3"> <i
                                                                    class="fab fa-facebook-f mr-3"></i> Login with
                                                            Facebook</a>
                                                    </li>
                                                    <li>
                                                        <a href="https://imagepasal.com/wp-login.php?loginSocial=google"
                                                           data-plugin="nsl" data-action="connect"
                                                           data-redirect="current" data-provider="google"
                                                           data-popupwidth="600" data-popupheight="600"
                                                           class="btn google d-block text-white"> <i
                                                                    class="fab fa-google mr-3"></i> Login with
                                                            Google</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

                </div>

                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">

                    <div class="registrations__form-wrapper mb-5">


                        <form method="post" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
                            <div class="row">
								<?php do_action( 'woocommerce_register_form_start' ); ?>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>
                                                &nbsp;<span
                                                        class="required">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="username"
                                                   id="reg_username" autocomplete="username"
                                                   value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
                                                   required/><?php // @codingStandardsIgnoreLine ?>
                                        </div>
                                    </div>
								<?php endif; ?>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="reg_email">Email
                                            &nbsp;<span
                                                    class="required">*</span></label>
                                        <input type="email" class="form-control"
                                               name="email"
                                               id="reg_email" autocomplete="email"
                                               value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"
                                               required/><?php // @codingStandardsIgnoreLine ?>
                                    </div>
                                </div>
								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>
                                                &nbsp;<span
                                                        class="required">*</span></label>
                                            <input type="password"
                                                   class="form-control"
                                                   name="password"
                                                   id="reg_password" autocomplete="new-password" required/>
                                        </div>
                                    </div>
								<?php else : ?>

                                    <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

								<?php endif; ?>

                                <div class="col-lg-12 mb-4">
									<?php do_action( 'woocommerce_register_form' ); ?>
                                </div>

                                <div class="col-lg-12">
									<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                    <button type="submit"
                                            class="btn btn-primary w-100"
                                            name="register"
                                            value="Join Us">Join Us
                                    </button>
                                </div>

								<?php do_action( 'woocommerce_register_form_end' ); ?>

                                <div class="registrations__options mt-5 text-center">
                                    <p class="my-4">OR REGISTER WITH</p>
                                    <ul>
                                        <li>
                                            <a href="https://imagepasal.com/wp-login.php?loginSocial=facebook"
                                               data-plugin="nsl" data-action="connect"
                                               data-redirect="current" data-provider="facebook"
                                               data-popupwidth="475" data-popupheight="175"
                                               class="btn facebook mb-3  d-block text-white"><span
                                                        class="icon-facebook mr-2"></span> Facebook</a>
                                        </li>
                                        <li>
                                            <a href="https://imagepasal.com/wp-login.php?loginSocial=google"
                                               data-plugin="nsl" data-action="connect"
                                               data-redirect="current" data-provider="google"
                                               data-popupwidth="600" data-popupheight="600"
                                               class="btn google  d-block text-white"><span
                                                        class="fab fa-google mr-2"></span> Google</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
    </div>
    <div class="registrations__left-panel"
         style="background-image: url('<?= get_template_directory_uri() ?>/assets/images/11.jpg');">
    </div>
</div>