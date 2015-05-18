<?php

namespace ride\web\cms\controller\widget\component;

use ride\library\config\Config;
use ride\library\form\component\AbstractComponent;
use ride\library\form\FormBuilder;


/**
 * Form component to add a social media account to link to
 */
class SocialMediaComponent extends AbstractComponent {

    /**
     * @var Config $config ;
     */
    protected $config;

    /**
     * Code of the locale
     * @var string
     */
    protected $locale;

    /**
     * @param \ride\library\config\Config $config
     */
    public function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * Gets the data type for the data of this form component
     * @return string|null A string for a data class, null for an array
     */
    public function getDataType() {
        return null;
    }

    /**
     * Prepares the form
     * @param \ride\library\form\FormBuilder $builder
     * @param array $options
     * @return null
     */
    public function prepareForm(FormBuilder $builder, array $options) {
        $translator = $options['translator'];
        $socialMedia = $this->config->get('social');

        $builder->addRow('socialMediaName', 'select', array(
            'label'    => $translator->translate('label.social.media.name'),
            'options'  => array_combine(array_keys($socialMedia), array_keys($socialMedia)),
            'widget'   => 'select',
            'required' => array(),
        ));
        $builder->addRow('accountName', 'string', array(
            'label'    => $translator->translate('label.social.media.account.name'),
            'required' => array(),
        ));
    }

}
