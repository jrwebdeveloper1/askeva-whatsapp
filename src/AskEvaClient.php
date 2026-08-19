<?php

namespace Askeva\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AskEvaClient
{
    protected $baseUrl;
    protected $token;

    public function __construct($baseUrl, $token)
    {
        $this->baseUrl = $baseUrl;
        $this->token = $token;
    }

    /**
     * Send a base template message via Askeva API.
     *
     * @param array $payload The request body as per API docs
     * @return array The API response.
     */
    public function sendTemplateMessage(array $payload): array
    {
        if (empty($this->token) || empty($this->baseUrl)) {
            Log::error('Askeva API error: Token or Base URL is not configured.');
            return [
                'error' => true,
                'status' => 500,
                'message' => 'API Token or Base URL is not configured (ASKEVA_TOKEN / ASKEVA_BASE_URL).'
            ];
        }

        $url = "{$this->baseUrl}?token={$this->token}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if ($response->successful()) {
                Log::info('Askeva message sent successfully', ['response' => $response->json()]);
                return $response->json();
            }

            Log::error('Askeva API error', ['status' => $response->status(), 'body' => $response->body()]);
            return [
                'error' => true,
                'status' => $response->status(),
                'message' => 'Failed to send message: ' . $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('Askeva API Exception: ' . $e->getMessage());
            return [
                'error' => true,
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Format the phone number to E.164 (ensure country code exists).
     * If you prefer to format outside, pass the formatted number.
     * By default, it just returns the provided number.
     */
    protected function formatPhone($phone)
    {
        return $phone; // Adjust this if you want auto-prefixing e.g., '91'
    }

    /**
     * Send a text template message.
     */
    public function sendTextTemplate($to, $templateName, $languageCode = 'en')
    {
        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send a text template with variables.
     */
    public function sendTextWithVariables($to, $templateName, array $variables, $languageCode = 'en')
    {
        $parameters = array_map(fn($var) => ['type' => 'text', 'text' => (string) $var], $variables);

        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => $parameters,
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send an image template.
     */
    public function sendImageTemplate($to, $templateName, $imageLink, $languageCode = 'en')
    {
        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'image',
                                'image' => ['link' => $imageLink],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send an image template with variables.
     */
    public function sendImageWithVariables($to, $templateName, $imageLink, array $variables, $languageCode = 'en')
    {
        $parameters = array_map(fn($var) => ['type' => 'text', 'text' => (string) $var], $variables);

        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'image',
                                'image' => ['link' => $imageLink],
                            ],
                        ],
                    ],
                    [
                        'type' => 'body',
                        'parameters' => $parameters,
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send a video template.
     */
    public function sendVideoTemplate($to, $templateName, $videoLink, $languageCode = 'en')
    {
        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'video',
                                'video' => ['link' => $videoLink],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send a video template with variables.
     */
    public function sendVideoWithVariables($to, $templateName, $videoLink, array $variables, $languageCode = 'en')
    {
        $parameters = array_map(fn($var) => ['type' => 'text', 'text' => (string) $var], $variables);

        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'video',
                                'video' => ['link' => $videoLink],
                            ],
                        ],
                    ],
                    [
                        'type' => 'body',
                        'parameters' => $parameters,
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send a document template.
     */
    public function sendDocumentTemplate($to, $templateName, $documentLink, $documentFilename, $languageCode = 'en')
    {
        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'document',
                                'document' => [
                                    'link' => $documentLink,
                                    'filename' => $documentFilename,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send a document template with variables.
     */
    public function sendDocumentWithVariables($to, $templateName, $documentLink, $documentFilename, array $variables, $languageCode = 'en')
    {
        $parameters = array_map(fn($var) => ['type' => 'text', 'text' => (string) $var], $variables);

        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'document',
                                'document' => [
                                    'link' => $documentLink,
                                    'filename' => $documentFilename,
                                ],
                            ],
                        ],
                    ],
                    [
                        'type' => 'body',
                        'parameters' => $parameters,
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send a carousel template without variables.
     * 
     * @param array $cards Array of associative arrays, e.g., [['image_link' => 'http...']]
     */
    public function sendCarouselTemplate($to, $templateName, array $cards, $languageCode = 'en')
    {
        $formattedCards = array_map(function ($card, $index) {
            return [
                'card_index' => $index,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'image',
                                'image' => ['link' => $card['image_link']],
                            ],
                        ],
                    ],
                ],
            ];
        }, $cards, array_keys($cards));

        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'carousel',
                        'cards' => $formattedCards,
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send a carousel template with variables.
     *
     * @param array $cards Array of associative arrays, e.g., [['image_link' => '...', 'variables' => ['var1']]]
     */
    public function sendCarouselWithVariables($to, $templateName, array $cards, $languageCode = 'en')
    {
        $formattedCards = array_map(function ($card, $index) {
            $parameters = array_map(fn($var) => ['type' => 'text', 'text' => (string) $var], $card['variables']);
            return [
                'card_index' => $index,
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'image',
                                'image' => ['link' => $card['image_link']],
                            ],
                        ],
                    ],
                    [
                        'type' => 'body',
                        'parameters' => $parameters,
                    ],
                ],
            ];
        }, $cards, array_keys($cards));

        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'carousel',
                        'cards' => $formattedCards,
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }

    /**
     * Send an authentication template (e.g., OTP).
     */
    public function sendAuthenticationTemplate($to, $templateName, $otp, $languageCode = 'en')
    {
        $payload = [
            'to' => $this->formatPhone($to),
            'type' => 'template',
            'template' => [
                'language' => [
                    'policy' => 'deterministic',
                    'code' => $languageCode,
                ],
                'name' => $templateName,
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $otp,
                            ],
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $otp,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $this->sendTemplateMessage($payload);
    }
}
