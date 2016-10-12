/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_OneStepCheckout
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

define([
    'jquery',
    'mage/storage',
    'jquery/ui',
    'mage/mage'
], function ($, storage) {
    $.widget("magestore.customerLogin", {
        options: {},

        /**
         * customerLogin creation
         * @protected
         */
        _create: function () {
            var self = this, options = this.options;

            $.extend(this, {
                $loginLinkControl: $('#onestepcheckout-login-link'),
                $forgotPasswordLink: $('#onestepcheckout-forgot-password-link'),
                $returnLoginLink: $('#onestepcheckout-return-login-link'),
                $registerLink: $('#onestepcheckout-register-link'),
                $returnLoginLinkFromRegister: $('#onestepcheckout-return-login-link-2'),

                $overlayControl: $('#control_overlay'),

                $loginButton: $('#onestepcheckout-login-button'),
                $registerButton: $('#onestepcheckout-register-button'),
                $sendPasswordButton: $('#onestepcheckout-forgot-button'),

                $loadingContol: $('#onestepcheckout-login-loading'),
                $forgotPasswordLoading: $('#onestepcheckout-forgot-loading'),
                $registerLoading: $('#onestepcheckout-register-loading'),

                $loginError: $('#onestepcheckout-login-error'),
                $forgotPasswordError: $('#onestepcheckout-forgot-error'),
                $registerError: $('#onestepcheckout-register-error'),

                $forgotPasswordSuccess: $('#onestepcheckout-forgot-success'),

                $usernameInput: $('#id_onestepcheckout_username'),
                $passwordInput: $('#id_onestepcheckout_password'),


                $forgotPasswordContent: $('#onestepcheckout-login-popup-contents-forgot'),
                $loginContent: $('#onestepcheckout-login-popup-contents-login'),
                $registerContent: $('#onestepcheckout-login-popup-contents-register'),
                $forgotPasswordTitle: $('.title-forgot'),

                $closeButton: $('.close'),

                $loginPopup: $('#onestepcheckout-login-popup'),
                $emailForgot: $('#id_onestepcheckout_email'),


                $firstNameReg: $('#id_onestepcheckout_firstname'),
                $lastNameReg: $('#id_onestepcheckout_lastname'),
                $userNameReg: $('#id_onestepcheckout_register_username'),
                $passwordReg: $('#id_onestepcheckout_register_password'),
                $confirmReg: $('#id_onestepcheckout_register_confirm_password'),

                $loginTable: $('#onestepcheckout-login-table'),
                $forgotPasswordTable: $('#onestepcheckout-forgot-table'),
                $registerTable: $('#onestepcheckout-register-table')


            });

            this.$loginLinkControl.click(function () {
                self.resetFormLogin();
                $(self.element).show();
                self.$overlayControl.show();
            });

            this.$overlayControl.click(function () {
                $(self.element).hide();
                $(this).hide();
                $('#onestepcheckout-toc-popup').hide();
            });

            self.validateLoginForm();
            self.validateRegisterForm();
            self.validateForgotForm();

            $(document).keypress(function (e) {
                if (e.which == 13) {
                    if (self.$loginContent.is(':visible')) {
                        $('#onestepcheckout-login-form').submit(function () {
                            return false;
                        });
                        self.validateLoginForm();
                    } else if (self.$forgotPasswordContent.is(':visible')) {
                        $('#onestepcheckout-register-form').submit(function () {
                            return false;
                        });
                        self.validateRegisterForm();
                    } else if (self.$registerContent.is(':visible')) {
                        $('#onestepcheckout-forgot-form').submit(function () {
                            return false;
                        });
                        self.validateForgotForm();
                    }
                }
            });
            this.$forgotPasswordLink.click(function () {
                self.$loginContent.hide();
                self.$forgotPasswordContent.show();
            });

            this.$returnLoginLink.click(function () {
                self.$forgotPasswordContent.hide();
                self.$loginContent.show();
            });

            this.$registerLink.click(function () {
                self.$loginContent.hide();
                self.$loginPopup.addClass('absolute-box');
                self.$registerContent.show();
            });

            this.$returnLoginLinkFromRegister.click(function () {
                self.$registerContent.hide();
                self.$loginPopup.removeClass('absolute-box');
                self.$loginPopup.addClass('fixed-box');
                self.$loginContent.show();
            });

            this.$closeButton.click(function () {
                self.$loginPopup.hide();
                self.$overlayControl.hide();
                $('#onestepcheckout-toc-popup').hide();
            });

            $('#onestepcheckout-toc-link').click(function (e) {
                self.$overlayControl.show();
                e.preventDefault();
                $('#onestepcheckout-toc-popup').show();
            })

        },
        validateLoginForm: function () {
            var self = this;
            $('#onestepcheckout-login-form').mage('validation', {
                submitHandler: function (form) {
                    self.ajaxLogin();
                }
            });
        },
        validateRegisterForm: function () {
            var self = this;
            $('#onestepcheckout-register-form').mage('validation', {
                submitHandler: function (form) {
                    self.ajaxRegister();
                }
            });
        },
        validateForgotForm: function () {
            var self = this;
            $('#onestepcheckout-forgot-form').mage('validation', {
                submitHandler: function (form) {
                    self.ajaxForgotPassword();
                }
            });
        },
        ajaxLogin: function () {
            var self = this, options = this.options;
            self.$loadingContol.show();
            self.$loginTable.hide();
            self.$loginError.hide();
            var params = {
                username: self.$usernameInput.val(),
                password: self.$passwordInput.val()
            };
            storage.post(
                'onestepcheckout/account/login',
                JSON.stringify(params),
                false
            ).done(
                function (result) {
                    var errors = result.errors;
                    if (errors == false) {
                        self.$loadingContol.show();
                        window.location.reload();
                    } else {
                        self.$loadingContol.hide();
                        self.$loginTable.show();
                        self.$loginError.html(result.message);
                        self.$loginError.show();
                    }
                }
            ).fail(
                function (result) {

                }
            );
        },
        ajaxRegister: function () {
            var self = this, options = this.options;
            if (self.$passwordReg.val() == self.$confirmReg.val()) {
                self.$registerLoading.show();
                self.$registerTable.hide();
                self.$registerError.hide();
                var params = {
                    firstName: self.$firstNameReg.val(),
                    lastName: self.$lastNameReg.val(),
                    userName: self.$userNameReg.val(),
                    password: self.$passwordReg.val(),
                    confirm: self.$confirmReg.val()
                };
                storage.post(
                    'onestepcheckout/account/register',
                    JSON.stringify(params),
                    false
                ).done(
                    function (result) {
                        self.$registerLoading.hide();
                        var success = result.success;
                        if (!result.error) {
                            window.location.reload();
                        } else {
                            self.$registerTable.show();
                            self.$registerError.html(result.error);
                            self.$registerError.show();
                        }
                    }
                ).fail(
                    function (result) {

                    }
                );
            } else {
                alert("Please Re-Enter Confirmation Password !");
            }
        },
        ajaxForgotPassword: function () {
            var self = this, options = this.options;
            self.$forgotPasswordError.hide();
            self.$forgotPasswordLoading.show();
            self.$forgotPasswordTable.hide();
            var params = {
                email: self.$emailForgot.val()
            };
            storage.post(
                'onestepcheckout/account/forgotPassword',
                JSON.stringify(params),
                false
            ).done(
                function (result) {
                    self.$forgotPasswordLoading.hide();
                    var success = result.success;
                    if (success == 'true') {
                        self.$forgotPasswordSuccess.show();
                        self.$forgotPasswordTable.hide();
                        self.$forgotPasswordTitle.hide();
                    } else {
                        self.$forgotPasswordTable.show();
                        self.$forgotPasswordError.html(result.errorMessage);
                        self.$forgotPasswordError.show();
                    }
                }
            ).fail(
                function (result) {

                }
            );
        },
        resetFormLogin: function () {
            var self = this;
            self.$loginTable.show();
            self.$forgotPasswordTable.show();
            self.$registerTable.show();

            self.$loadingContol.hide();
            self.$forgotPasswordLoading.hide();
            self.$registerLoading.hide();

            self.$loginError.hide();
            self.$forgotPasswordError.hide();
            self.$registerError.hide();

            self.$loginContent.show();
            self.$forgotPasswordContent.hide();
            self.$registerContent.hide();
        }
    });

    return $.magestore.customerLogin;
});