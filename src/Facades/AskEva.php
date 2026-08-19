<?php

namespace Askeva\WhatsApp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array sendTemplateMessage(array $payload)
 * @method static array sendTextTemplate(string $to, string $templateName, string $languageCode = 'en')
 * @method static array sendTextWithVariables(string $to, string $templateName, array $variables, string $languageCode = 'en')
 * @method static array sendImageTemplate(string $to, string $templateName, string $imageLink, string $languageCode = 'en')
 * @method static array sendImageWithVariables(string $to, string $templateName, string $imageLink, array $variables, string $languageCode = 'en')
 * @method static array sendVideoTemplate(string $to, string $templateName, string $videoLink, string $languageCode = 'en')
 * @method static array sendVideoWithVariables(string $to, string $templateName, string $videoLink, array $variables, string $languageCode = 'en')
 * @method static array sendDocumentTemplate(string $to, string $templateName, string $documentLink, string $documentFilename, string $languageCode = 'en')
 * @method static array sendDocumentWithVariables(string $to, string $templateName, string $documentLink, string $documentFilename, array $variables, string $languageCode = 'en')
 * @method static array sendCarouselTemplate(string $to, string $templateName, array $cards, string $languageCode = 'en')
 * @method static array sendCarouselWithVariables(string $to, string $templateName, array $cards, string $languageCode = 'en')
 * @method static array sendAuthenticationTemplate(string $to, string $templateName, string $otp, string $languageCode = 'en')
 *
 * @see \Askeva\WhatsApp\AskEvaClient
 */
class AskEva extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'askeva';
    }
}
