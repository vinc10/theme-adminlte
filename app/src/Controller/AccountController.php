<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Sprinkle\Account\Account\Registration;
use UserFrosting\Sprinkle\Account\Facades\Password;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\ForbiddenException;

/**
 * Controller class for /account/* URLs.  Handles account-related activities, including login, registration, password recovery, and account settings.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 *
 * @see http://www.userfrosting.com/navigating/#structure
 */
class AccountController extends SimpleController
{
    /**
     * Returns a modal containing account terms of service.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     *
     * AuthGuard: false
     * Route: /modals/account/tos
     * Route Name: {none}
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    // TODO : Move to Theme repo
    /*public function getModalAccountTos(Request $request, Response $response, $args)
    {
        return $this->ci->view->render($response, 'modals/tos.html.twig');
    }*/

    /**
     * Render the "forgot password" page.
     *
     * This creates a simple form to allow users who forgot their password to have a time-limited password reset link emailed to them.
     * By default, this is a "public page" (does not require authentication).
     *
     * AuthGuard: false
     * Route: /account/forgot-password
     * Route Name: forgot-password
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    // TODO : Move to Theme repo ?
    /*public function pageForgotPassword(Request $request, Response $response, $args)
    {
        // Load validation rules
        $schema = new RequestSchema('schema://requests/forgot-password.yaml');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        return $this->ci->view->render($response, 'pages/forgot-password.html.twig', [
            'page' => [
                'validators' => [
                    'forgot_password'    => $validator->rules('json', false),
                ],
            ],
        ]);
    }*/

    /**
     * Render the "resend verification email" page.
     *
     * This is a form that allows users who lost their account verification link to have the link resent to their email address.
     * By default, this is a "public page" (does not require authentication).
     *
     * AuthGuard: false
     * Route: /account/resend-verification
     * Route Name: {none}
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    // TODO : Move to Theme repo ?
    /*public function pageResendVerification(Request $request, Response $response, $args)
    {
        // Load validation rules
        $schema = new RequestSchema('schema://requests/resend-verification.yaml');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        return $this->ci->view->render($response, 'pages/resend-verification.html.twig', [
            'page' => [
                'validators' => [
                    'resend_verification'    => $validator->rules('json', false),
                ],
            ],
        ]);
    }*/

    /**
     * Reset password page.
     *
     * Renders the new password page for password reset requests.
     *
     * AuthGuard: false
     * Route: /account/set-password/confirm
     * Route Name: {none}
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    // TODO : Move to Theme repo ?
    /*public function pageResetPassword(Request $request, Response $response, $args)
    {
        /** @var \UserFrosting\Support\Repository\Repository $config * /
        $config = $this->ci->config;

        // Insert the user's secret token from the link into the password reset form
        $params = $request->getQueryParams();

        // Load validation rules - note this uses the same schema as "set password"
        $schema = new RequestSchema('schema://requests/set-password.yaml');
        $schema->set('password.validators.length.min', $config['site.password.length.min']);
        $schema->set('password.validators.length.max', $config['site.password.length.max']);
        $schema->set('passwordc.validators.length.min', $config['site.password.length.min']);
        $schema->set('passwordc.validators.length.max', $config['site.password.length.max']);
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        return $this->ci->view->render($response, 'pages/reset-password.html.twig', [
            'page' => [
                'validators' => [
                    'set_password'    => $validator->rules('json', false),
                ],
            ],
            'token' => isset($params['token']) ? $params['token'] : '',
        ]);
    }*/

    /**
     * Render the "set password" page.
     *
     * Renders the page where new users who have had accounts created for them by another user, can set their password.
     * By default, this is a "public page" (does not require authentication).
     *
     * AuthGuard: false
     * Route:
     * Route Name: {none}
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    // TODO : Move to Theme repo ?
    /*public function pageSetPassword(Request $request, Response $response, $args)
    {
        /** @var \UserFrosting\Support\Repository\Repository $config * /
        $config = $this->ci->config;

        // Insert the user's secret token from the link into the password set form
        $params = $request->getQueryParams();

        // Load validation rules
        $schema = new RequestSchema('schema://requests/set-password.yaml');
        $schema->set('password.validators.length.min', $config['site.password.length.min']);
        $schema->set('password.validators.length.max', $config['site.password.length.max']);
        $schema->set('passwordc.validators.length.min', $config['site.password.length.min']);
        $schema->set('passwordc.validators.length.max', $config['site.password.length.max']);
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        return $this->ci->view->render($response, 'pages/set-password.html.twig', [
            'page' => [
                'validators' => [
                    'set_password'    => $validator->rules('json', false),
                ],
            ],
            'token' => isset($params['token']) ? $params['token'] : '',
        ]);
    }*/

    /**
     * Account settings page.
     *
     * Provides a form for users to modify various properties of their account, such as name, email, locale, etc.
     * Any fields that the user does not have permission to modify will be automatically disabled.
     * This page requires authentication.
     *
     * AuthGuard: true
     * Route: /account/settings
     * Route Name: {none}
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws ForbiddenException If user is not authorized to access page
     */
    // TODO : Move to Theme repo ?
    /*public function pageSettings(Request $request, Response $response, $args)
    {
        /** @var \UserFrosting\Support\Repository\Repository $config * /
        $config = $this->ci->config;

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager * /
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser * /
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'uri_account_settings')) {
            throw new ForbiddenException();
        }

        // Load validation rules
        $schema = new RequestSchema('schema://requests/account-settings.yaml');
        $schema->set('password.validators.length.min', $config['site.password.length.min']);
        $schema->set('password.validators.length.max', $config['site.password.length.max']);
        $schema->set('passwordc.validators.length.min', $config['site.password.length.min']);
        $schema->set('passwordc.validators.length.max', $config['site.password.length.max']);
        $validatorAccountSettings = new JqueryValidationAdapter($schema, $this->ci->translator);

        $schema = new RequestSchema('schema://requests/profile-settings.yaml');
        $validatorProfileSettings = new JqueryValidationAdapter($schema, $this->ci->translator);

        // Get a list of all locales
        $locales = $this->ci->locale->getAvailableOptions();

        // Hide the locale field if there is only 1 locale available
        $fields = [
            'hidden'   => [],
            'disabled' => [],
        ];
        if (count($locales) <= 1) {
            $fields['hidden'][] = 'locale';
        }

        return $this->ci->view->render($response, 'pages/account-settings.html.twig', [
            'locales' => $locales,
            'fields'  => $fields,
            'page'    => [
                'validators' => [
                    'account_settings'    => $validatorAccountSettings->rules('json', false),
                    'profile_settings'    => $validatorProfileSettings->rules('json', false),
                ],
                'visibility' => ($authorizer->checkAccess($currentUser, 'update_account_settings') ? '' : 'disabled'),
            ],
        ]);
    }*/
}
