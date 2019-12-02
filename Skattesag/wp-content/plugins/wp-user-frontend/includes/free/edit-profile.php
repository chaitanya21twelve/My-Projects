<?php

class WPUF_Edit_Profile {

    function __construct() {
        add_shortcode( 'wpuf_editprofile', array($this, 'shortcode') );

        add_action( 'personal_options_update', array($this, 'post_lock_update') );
        add_action( 'edit_user_profile_update', array($this, 'post_lock_update') );

        add_action( 'show_user_profile', array($this, 'post_lock_form') );
        add_action( 'edit_user_profile', array($this, 'post_lock_form') );
    }

    /**
     * Hanldes the editprofile shortcode
     *
     * @author Tareq Hasan
     */
    function shortcode() {
        // wpuf()->plugin_scripts();
        ?>
        <style>
            <?php //echo $custom_css = wpuf_get_option( 'custom_css', 'wpuf_general' ); ?>
        </style>
        <?php
        ob_start();

        if ( is_user_logged_in() ) {
            $this->show_form();
        } else {
            printf( __( "This page is restricted. Please %s to view this page.", 'wp-user-frontend' ), wp_loginout( '', false ) );
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Shows the user profile form
     *
     * @global type $userdata
     * @param type $user_id
     */
    function show_form( $user_id = null ) {
        global $userdata, $wp_http_referer;
        wp_get_current_user();

        if ( !(function_exists( 'get_user_to_edit' )) ) {
            require_once(ABSPATH . '/wp-admin/includes/user.php');
        }

        if ( !(function_exists( '_wp_get_user_contactmethods' )) ) {
            require_once(ABSPATH . '/wp-includes/registration.php');
        }

        if ( !$user_id ) {
            $current_user = wp_get_current_user();
            $user_id = $user_ID = $current_user->ID;
        }

        if ( isset( $_POST['submit'] ) ) {
            check_admin_referer( 'update-profile_' . $user_id );
            $errors = edit_user( $user_id );
            if ( is_wp_error( $errors ) ) {
                $message = $errors->get_error_message();
                $style = 'error';
            } else {
                $message = __( '<strong>Success</strong>: Profile updated', 'wp-user-frontend' );
                $style = 'success';
                do_action( 'personal_options_update', $user_id );
            }
        }

        $profileuser = get_user_to_edit( $user_id );

        if ( isset( $message ) ) {
            echo '<div class="' . $style . '">' . $message . '</div>';
        }
        ?>
        <div class="wpuf-profile">
            <form name="profile" id="your-profile" action="" method="post">
                <?php wp_nonce_field( 'update-profile_' . $user_id ) ?>
                <?php if ( $wp_http_referer ) : ?>
                    <input type="hidden" name="wp_http_referer" value="<?php echo esc_url( $wp_http_referer ); ?>" />
                <?php endif; ?>
                <input type="hidden" name="from" value="profile" />
                <input type="hidden" name="checkuser_id" value="<?php echo $user_id; ?>" />
                <table class="wpuf-table">
                    <?php do_action( 'personal_options', $profileuser ); ?>
                </table>
                <?php do_action( 'profile_personal_options', $profileuser ); ?>
				<div class="row">
		<div class="col-xl-6">
			<div class="row">
                <fieldset>
                    <legend><?php _e( 'Dine oplysninger', 'wp-user-frontend' ) ?></legend>

                    <table class="wpuf-table">
                        <tr class="d-none">
                            <th><label for="user_login1"><?php _e( 'Username', 'wp-user-frontend' ); ?></label></th>
                            <td><input type="text" name="user_login" id="user_login1" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /><br /><em><span class="description"><?php _e( 'Usernames cannot be changed.', 'wp-user-frontend' ); ?></span></em></td>
                        </tr>
                        <tr>
                            <th><label for="first_name"><?php _e( 'Fornavn:', 'wp-user-frontend' ) ?></label></th>
                            <td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ) ?>" class="regular-text" /></td>
                        </tr>

                        <tr>
                            <th><label for="last_name"><?php _e( 'Efternavn:', 'wp-user-frontend' ) ?></label></th>
                            <td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ) ?>" class="regular-text" /></td>
                        </tr>
						
						 <tr style="display: none;">
                            <th><label for="url"><?php _e( 'Telefonnummer:', 'wp-user-frontend' ) ?></label></th>
                            <td><input type="text" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ) ?>" class="regular-text code" /></td>
                        </tr>
						
						 <tr>
                            <th><label for="email"><?php _e( 'Email:', 'wp-user-frontend' ); ?> <span class="description d-none"><?php _e( '(required)', 'wp-user-frontend' ); ?></span></label></th>
                            <td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ) ?>" class="regular-text" /> </td>
                        </tr>

                        <tr class="d-none">
                            <th><label for="nickname"><?php _e( 'Nickname', 'wp-user-frontend' ); ?> <span class="description"><?php _e( '(required)', 'wp-user-frontend' ); ?></span></label></th>
                            <td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ) ?>" class="regular-text" /></td>
                        </tr>

                        <tr class="d-none">
                            <th><label for="display_name"><?php _e( 'Display to Public as', 'wp-user-frontend' ) ?></label></th>
                            <td>
                                <select name="display_name" id="display_name">
                                    <?php
                                    $public_display = array();
                                    $public_display['display_username'] = $profileuser->user_login;
                                    $public_display['display_nickname'] = $profileuser->nickname;
                                    if ( !empty( $profileuser->first_name ) )
                                        $public_display['display_firstname'] = $profileuser->first_name;
                                    if ( !empty( $profileuser->last_name ) )
                                        $public_display['display_lastname'] = $profileuser->last_name;
                                    if ( !empty( $profileuser->first_name ) && !empty( $profileuser->last_name ) ) {
                                        $public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
                                        $public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
                                    }
                                    if ( !in_array( $profileuser->display_name, $public_display ) ) // Only add this if it isn't duplicated elsewhere
                                        $public_display = array('display_displayname' => $profileuser->display_name) + $public_display;
                                    $public_display = array_map( 'trim', $public_display );
                                    $public_display = array_unique( $public_display );
                                    foreach ($public_display as $id => $item) {
                                        ?>
                                        <option id="<?php echo $id; ?>" value="<?php echo esc_attr( $item ); ?>"<?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <?php do_action( 'show_user_profile', $profileuser ); ?>
                </fieldset>

                <fieldset class="d-none">
                    <legend class="d-none"><?php _e( 'Contact Info', 'wp-user-frontend' ) ?></legend>

                    <table class="wpuf-table">
                        <tr>
                            <th style="padding-right: 57px;"><label for="email"><?php _e( 'E-mail', 'wp-user-frontend' ); ?> <span class="description d-none"><?php _e( '(required)', 'wp-user-frontend' ); ?></span></label></th>
                            <td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ) ?>" class="regular-text" /> </td>
                        </tr>

                        <?php
                        foreach (_wp_get_user_contactmethods() as $name => $desc) {
                            ?>
                            <tr>
                                <th><label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?></label></th>
                                <td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profileuser->$name ) ?>" class="regular-text" /></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </fieldset>
			</div>
		</div>
		<div class="col-xl-6">
			<div class="row">
                <fieldset>
                    <legend><?php _e( 'Ændre kodeord', 'wp-user-frontend' ); ?></legend>

                    <table class="wpuf-table">
                        <tr class="d-none">
                            <th><label for="description"><?php _e( 'Biographical Info', 'wp-user-frontend' ); ?></label></th>
                            <td><textarea name="description" id="description" rows="5" cols="30"><?php echo esc_html( $profileuser->description ); ?></textarea><br />
                                <span class="description"><?php _e( 'Share a little biographical information to fill out your profile. This may be shown publicly.', 'wp-user-frontend' ); ?></span></td>
                        </tr>
                        <tr id="password">
                            <th><label for="pass1"><?php _e( 'Nyt kodeord:', 'wp-user-frontend' ); ?></label></th>
                            <td>
                                <input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /><br /><br />
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Bekræft kodeord:', 'wp-user-frontend' ); ?></label></th>
                            <td>
                                <input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" />&nbsp;<em class="d-none"><span class="description"><?php _e( "Type your new password again.", 'wp-user-frontend' ); ?></span></em>
                            </td>
                        </tr>
                        <tr class="d-none">

                            <th><label><?php _e( 'Password Strength', 'wp-user-frontend' ); ?></label></th>
                            <td>
                                <div id="pass-strength-result"><?php _e( 'Strength indicator', 'wp-user-frontend' ); ?></div>
                                <script src="<?php echo site_url(); ?>/wp-includes/js/zxcvbn.min.js"></script>
                                <script src="<?php echo admin_url(); ?>/js/password-strength-meter.js"></script>
                                <script type="text/javascript">
                                    var pwsL10n = {
                                        empty: "Strength indicator",
                                        short: "Very weak",
                                        bad: "Weak",
                                        good: "Medium",
                                        strong: "Strong",
                                        mismatch: "Mismatch"
                                    };
                                    try{convertEntities(pwsL10n);}catch(e){};
                                </script>
                            </td>
                        </tr>
                    </table>
                </fieldset>
			</div>
		</div>
	</div>
                <?php //do_action( 'show_user_profile', $profileuser ); ?>

                <p class="submit mt-5">
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $user_id ); ?>" />
                    <input type="submit" class="wpuf-submit" value="<?php _e( 'Opdater dine oplysninger', 'wp-user-frontend' ); ?>" name="submit" />
                </p>
            </form>
        </div>
        <?php
    }

    /**
     * Adds the postlock form in users profile
     *
     * @param object $profileuser
     */
    function post_lock_form( $profileuser ) {
        $current_user      = new WPUF_User( $profileuser );
        $wpuf_subscription = $current_user->subscription();
        $post_locked       = $current_user->post_locked();
        $lock_reason       = $current_user->lock_reason();
        $edit_post_locked  = $current_user->edit_post_locked();
        $edit_lock_reason  = $current_user->edit_post_lock_reason();

        if ( is_admin() && current_user_can( 'edit_users' ) ) {
            $select           = ( $post_locked == true ) ? 'yes' : 'no';
            $edit_post_select = ( $edit_post_locked == true ) ? 'yes' : 'no';
            ?>
            <div class="wpuf-user-post-lock">
                <h3><?php _e( 'WPUF Post Lock', 'wp-user-frontend' ); ?></h3>
                <table class="form-table">
                    <tr>
                        <th><label for="post-lock"><?php _e( 'Lock Post:', 'wp-user-frontend' ); ?> </label></th>
                        <td>
                            <select name="wpuf_postlock" id="post-lock">
                                <option value="no"<?php selected( $select, 'no' ); ?>>No</option>
                                <option value="yes"<?php selected( $select, 'yes' ); ?>>Yes</option>
                            </select>
                            <span class="description"><?php _e( 'Lock user from creating new post.', 'wp-user-frontend' ); ?></span></em>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="post-lock"><?php _e( 'Lock Reason:', 'wp-user-frontend' ); ?> </label></th>
                        <td>
                            <input type="text" name="wpuf_lock_cause" id="wpuf_lock_cause" class="regular-text" value="<?php echo esc_attr( $lock_reason ); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th><label for="post-lock"><?php _e( 'Lock Edit Post:', 'wp-user-frontend' ); ?> </label></th>
                        <td>
                            <select name="wpuf_edit_postlock" id="edit-post-lock">
                                <option value="no"<?php selected( $edit_post_select, 'no' ); ?>>No</option>
                                <option value="yes"<?php selected( $edit_post_select, 'yes' ); ?>>Yes</option>
                            </select>
                            <span class="description"><?php _e( 'Lock user from editing post.', 'wp-user-frontend' ); ?></span></em>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="post-lock"><?php _e( 'Edit Post Lock Reason:', 'wp-user-frontend' ); ?> </label></th>
                        <td>
                            <input type="text" name="wpuf_edit_post_lock_cause" id="wpuf_edit_post_lock_cause" class="regular-text" value="<?php echo esc_attr( $edit_lock_reason ); ?>" />
                        </td>
                    </tr>
                </table>
            </div>
            <?php
        }
    }

    /**
     * Update user profile lock
     *
     * @param int $user_id
     */
    function post_lock_update( $user_id ) {
        if ( is_admin() && current_user_can( 'edit_users' ) ) {
            update_user_meta( $user_id, 'wpuf_postlock', $_POST['wpuf_postlock'] );
            update_user_meta( $user_id, 'wpuf_lock_cause', $_POST['wpuf_lock_cause'] );
            update_user_meta( $user_id, 'wpuf_edit_postlock', $_POST['wpuf_edit_postlock'] );
            update_user_meta( $user_id, 'wpuf_edit_post_lock_cause', $_POST['wpuf_edit_post_lock_cause'] );
        }
    }

}
