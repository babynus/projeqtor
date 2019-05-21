<?php

namespace SimpleSAML\IdP;

use SimpleSAML\Logger;
use SimpleSAML\Utils\HTTP;

/**
 * Class that handles traditional logout.
 *
 * @package SimpleSAMLphp
 */

class TraditionalLogoutHandler implements LogoutHandlerInterface
{
    /**
     * The IdP we are logging out from.
     *
     * @var \SimpleSAML\IdP
     */
    private $idp;


    /**
     * TraditionalLogout constructor.
     *
     * @param \SimpleSAML\IdP $idp The IdP to log out from.
     */
    public function __construct(\SimpleSAML\IdP $idp)
    {
        $this->idp = $idp;
    }


    /**
     * Picks the next SP and issues a logout request.
     *
     * This function never returns.
     *
     * @param array &$state The logout state.
     */
    private function logoutNextSP(array &$state)
    {
        $association = array_pop($state['core:LogoutTraditional:Remaining']);
        if ($association === null) {
            $this->idp->finishLogout($state);
        }

        $relayState = \SimpleSAML\Auth\State::saveState($state, 'core:LogoutTraditional', true);

        $id = $association['id'];
        Logger::info('Logging out of '.var_export($id, true).'.');

        try {
            $idp = \SimpleSAML\IdP::getByState($association);
            $url = call_user_func([$association['Handler'], 'getLogoutURL'], $idp, $association, $relayState);
            HTTP::redirectTrustedURL($url);
        } catch (\Exception $e) {
            Logger::warning('Unable to initialize logout to '.var_export($id, true).'.');
            $this->idp->terminateAssociation($id);
            $state['core:Failed'] = true;

            // Try the next SP
            $this->logoutNextSP($state);
            assert(false);
        }
    }


    /**
     * Start the logout operation.
     *
     * This function never returns.
     *
     * @param array  &$state The logout state.
     * @param string $assocId The association that started the logout.
     */
    public function startLogout(array &$state, $assocId)
    {
        $state['core:LogoutTraditional:Remaining'] = $this->idp->getAssociations();

        $this->logoutNextSP($state);
    }


    /**
     * Continue the logout operation.
     *
     * This function will never return.
     *
     * @param string $assocId The association that is terminated.
     * @param string|null $relayState The RelayState from the start of the logout.
     * @param \SimpleSAML\Error\Exception|null $error The error that occurred during session termination (if any).
     *
     * @throws \SimpleSAML\Error\Exception If the RelayState was lost during logout.
     */
    public function onResponse($assocId, $relayState, \SimpleSAML\Error\Exception $error = null)
    {
        assert(is_string($assocId));
        assert(is_string($relayState) || $relayState === null);

        if ($relayState === null) {
            throw new \SimpleSAML\Error\Exception('RelayState lost during logout.');
        }

        $state = \SimpleSAML\Auth\State::loadState($relayState, 'core:LogoutTraditional');

        if ($error === null) {
            Logger::info('Logged out of '.var_export($assocId, true).'.');
            $this->idp->terminateAssociation($assocId);
        } else {
            Logger::warning('Error received from '.var_export($assocId, true).' during logout:');
            $error->logWarning();
            $state['core:Failed'] = true;
        }

        $this->logoutNextSP($state);
    }
}
