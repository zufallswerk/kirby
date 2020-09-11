<?php

namespace Kirby\Form\Fields;

use Kirby\Cms\App;

class BuilderFieldTest extends TestCase
{
    public function testTranslate()
    {
        $app = new App([
            'roots' => [
                'index' => '/dev/null'
            ],
            'options' => [
                'languages' => true
            ],
            'languages' => [
                [
                    'code' => 'en',
                    'default' => true
                ],
                [
                    'code' => 'de',
                ]
            ]
        ]);

        // default language
        $app->setCurrentLanguage('en');
        $field = $this->field('builder', [
            'fieldsets' => [
                'heading' => [
                    'translate' => false,
                    'fields' => [
                        'text' => [
                            'type' => 'text'
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertFalse($field->fieldsets['heading']['disabled']);

        // secondary language
        $app = $app->clone();
        $app->setCurrentLanguage('de');

        $field = $this->field('builder', [
            'fieldsets' => [
                'heading' => [
                    'translate' => false,
                    'fields' => [
                        'text' => [
                            'type' => 'text'
                        ]
                    ]
                ]
            ]
        ]);
        $this->assertTrue($field->fieldsets['heading']['disabled']);
    }
}
