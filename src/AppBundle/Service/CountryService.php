<?php

namespace AppBundle\Service;

use AppBundle\Exception\InvalidCountryCodeException;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class CountryService
{

    const ID = 'app.country';
    const DEFAULT_COUNTRY = 'us';

    private $locale;
    private $countryCode;
    private $currency;

    /**
     *
     * @var \Twig_Environment
     */
    private $twig;

    function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function onKernelRequest(KernelEvent $event) {
        $countryCode = $event->getRequest()->get('country', self::DEFAULT_COUNTRY);
        $country = $this->getCountryByCode($countryCode);
        $this->currency = $country['currency'];
        $this->locale = $country['locale'];
        $this->countryCode = $countryCode;
        $this->setTwigGlobals();
    }

    public function getCountryByCode($code) {
        $countries = $this->getCountries();
        if (empty($countries[$code])) {
            throw new InvalidCountryCodeException(sprintf('Invalid country code %s', $code));
        }
        return $countries[$code];
    }

    /**
     * 
     * @todo real implementation
     */
    public function getCountries() {
        return array(
            'fr' => array('locale' => 'fr', 'currency' => 'EUR'),
            'us' => array('locale' => 'en', 'currency' => 'USD'),
            'ro' => array('locale' => 'ro', 'currency' => 'RON')
        );
    }

    private function setTwigGlobals() {
        $this->twig->addGlobal('country', $this->countryCode);
        $this->twig->addGlobal('currency', $this->currency);
        $this->twig->addGlobal('locale', $this->locale);
    }

    function getLocale() {
        return $this->locale;
    }

    function getCountryCode() {
        return $this->countryCode;
    }

    function getCurrency() {
        return $this->currency;
    }

}
