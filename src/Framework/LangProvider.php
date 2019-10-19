<?php

namespace Framework;

use Framework\Session\SessionInterface;

/**
 * Class LangProvider
 * @package Framework
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class LangProvider extends JsonReader
{

    /**
     * application current lang
     *
     * @var string
     */
    public $currentLang = 'fr';

    /**
     * LangProvider constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $languages = [
            'fr' => ROOT . "/data/lang/fr.json",
            'en' => ROOT . "/data/lang/en.json",
        ];

        $this->currentLang = $session->get('lang', 'fr');
        parent::__construct($languages[$this->currentLang]);
    }

    /**
     * Get application current lang
     *
     * @return  string
     */
    public function getCurrentLang()
    {
        return $this->currentLang;
    }
}
