<?php

namespace ride\web\cms\controller\widget;

use ride\library\validation\exception\ValidationException;

/**
 * Widget which shares the current page to the chosen social media
 */
class SocialMediaShareWidget extends AbstractWidget implements StyleWidget{

    /**
     * Machine name of this widget
     * @var string
     */
    const NAME = 'social.media.share';

    /**
     * Path to the icon of this widget
     * @var string
     */
    const ICON = 'img/cms/widget/share.png';

    /**
     * Namespace for the templates of this widget
     * @var string
     */
    const TEMPLATE_NAMESPACE = 'cms/widget/social-media';

    /**
     * Name of the share media property
     * @var string
     */
    const PROPERTY_SHARE_MEDIA = 'share.media';

    /**
     * Render the social media links.
     */
    public function indexAction() {
        $media = $this->properties->getWidgetProperty(self::PROPERTY_SHARE_MEDIA);
        $data = array(
            'socialMedia' => $media ? explode(',', $media) : array()
        );

        $this->setTemplateView($this->getTemplate(static::TEMPLATE_NAMESPACE . '/social.media.share'), $data);
    }

    /**
     * Gets a preview of the properties of this widget instance
     * @return string
     */
    public function getPropertiesPreview() {
        $preview = "";

        $data = $this->properties->getWidgetProperty(self::PROPERTY_SHARE_MEDIA);
        if ($data) {
            $data = explode(',', $data);
            $preview .= "<ul>";
            foreach ($data as $media) {
                $preview .= "<li>$media</li>";
            }
            $preview .= "</ul>";
        }

        return $preview;
    }

    /**
     * Action to handle and show the properties of this widget
     * @return null
     */
    public function propertiesAction() {
        $translator = $this->getTranslator();
        $data = array(
            'shareMedia' => array_flip(explode(',', $this->properties->getWidgetProperty(self::PROPERTY_SHARE_MEDIA))),
        );
        $form = $this->createFormBuilder($data);
        $form->addRow('title', 'string', array(
            'label' => $translator->translate('label.title'),
        ));
        $form->addRow('shareMedia', 'option', array(
            'label' => $translator->translate('label.social.media'),
            'options' => array(
                'email' => 'Email',
                'digg' => 'Digg',
                'facebook' => 'Facebook',
                'google' => 'GooglePlus',
                'linkedin' => 'LinkedIn',
                'pinterest' => 'Pintrest',
                'reddit' => 'Reddit',
                'stumbleUpon' => 'StumbleUpon',
                'tumblr' => 'Tumblr',
                'twitter' => 'Twitter',
            ),
            'multiple' => true,
        ));

        $form = $form->build();
        if ($form->isSubmitted()) {
            if ($this->request->getBodyParameter('cancel')) {
                return false;
            }

            try {
                $form->validate();
                $data = $form->getData();
                if ($data['shareMedia']) {
                    $data = implode(',', array_keys($data['shareMedia']));
                    $this->properties->setWidgetProperty(self::PROPERTY_SHARE_MEDIA, $data);
                }

                return true;
            } catch (ValidationException $exception) {
                $this->setValidationException($exception, $form);
            }
        }

        $this->setTemplateView(self::TEMPLATE_NAMESPACE . '/properties', array(
            'form' => $form->getView(),
        ));

        return false;
    }
    /**
     * Gets the options for the styles
     * @return array Array with the name of the option as key and the
     * translation key as value
     */
    public function getWidgetStyleOptions() {
        return array(
            'container' => 'label.style.container',
            'title'     => 'label.style.title',
        );
    }

}
