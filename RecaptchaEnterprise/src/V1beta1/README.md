# reCAPTCHA Enterprise V1beta1 generated client for PHP

### Sample

```php
use Google\Cloud\RecaptchaEnterprise\V1beta1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1beta1\Event;
use Google\Cloud\RecaptchaEnterprise\V1beta1\RecaptchaEnterpriseServiceV1Beta1Client;

$recaptcha = new RecaptchaEnterpriseServiceV1Beta1Client;
$recaptcha->createAssessment([
    'parent' => RecaptchaEnterpriseServiceV1Beta1Client::projectName('[PROJECT_ID]'),
    'assessment' => new Assessment([
        'event' => new Event([
            'token' => '[EVENT_TOKEN]',
            'site_key' => '[SITE_KEY]'
        ])
    ])
]);
```
