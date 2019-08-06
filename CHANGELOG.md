# Changelog

## 0.106.2

<details><summary>google/cloud-core 1.30.1</summary>



### Bug Fixes

* Address Firestore memory leak (affects long running processes) ([#2153](https://www.github.com/googleapis/google-cloud-php/issues/2153)) ([6d9c47f](https://www.github.com/googleapis/google-cloud-php/commit/6d9c47f))

</details>

<details><summary>google/cloud-error-reporting 0.14.6</summary>



### Bug Fixes

* Removes STDERR const, which is defined by CLI SAPI ([#2147](https://www.github.com/googleapis/google-cloud-php/issues/2147)) ([3dc62b4](https://www.github.com/googleapis/google-cloud-php/commit/3dc62b4))

</details>

<details><summary>google/cloud-firestore 1.6.3</summary>



### Bug Fixes

* Address Firestore memory leak (affects long running processes) ([#2153](https://www.github.com/googleapis/google-cloud-php/issues/2153)) ([6d9c47f](https://www.github.com/googleapis/google-cloud-php/commit/6d9c47f))

</details>

<details><summary>google/cloud-monitoring 0.17.0</summary>



### Features

* Add support for notification channel verification codes. ([#2155](https://www.github.com/googleapis/google-cloud-php/issues/2155)) ([da3d412](https://www.github.com/googleapis/google-cloud-php/commit/da3d412))

</details>

<details><summary>google/cloud-storage 1.14.0</summary>



### Features

* **storage:** Add support for service account HMAC keys ([#1938](https://www.github.com/googleapis/google-cloud-php/issues/1938)) ([104c8ba](https://www.github.com/googleapis/google-cloud-php/commit/104c8ba))

</details>

<details><summary>google/cloud-talent 0.5.0</summary>



### Features

* Update Talent v4beta1 Client. ([#2157](https://www.github.com/googleapis/google-cloud-php/issues/2157)) ([a2fcf0f](https://www.github.com/googleapis/google-cloud-php/commit/a2fcf0f))

</details>

<details><summary>google/cloud-videointelligence 1.7.0</summary>



### Features

* Add feature/segment to VideoAnnotationProgress. ([#2154](https://www.github.com/googleapis/google-cloud-php/issues/2154)) ([fb06ec6](https://www.github.com/googleapis/google-cloud-php/commit/fb06ec6))

</details>

## 0.106.1

<details><summary>google/cloud-spanner 1.16.1</summary>



### Bug Fixes

* close code snippet ([#2140](https://www.github.com/googleapis/google-cloud-php/issues/2140)) ([e71b29c](https://www.github.com/googleapis/google-cloud-php/commit/e71b29c))

</details>

## 0.106.0

<details><summary>google/cloud-bigquery 1.8.0</summary>



### Features

* Add explicit support for dataset filters ([#2124](https://www.github.com/googleapis/google-cloud-php/issues/2124)) ([f67af6d](https://www.github.com/googleapis/google-cloud-php/commit/f67af6d))
* Add support for BigQuery Models. ([#2039](https://www.github.com/googleapis/google-cloud-php/issues/2039)) ([e2e006f](https://www.github.com/googleapis/google-cloud-php/commit/e2e006f))

</details>

<details><summary>google/cloud-bigquerydatatransfer 0.12.1</summary>



### Bug Fixes

* Add locationName formatting method and update system test ([#2136](https://www.github.com/googleapis/google-cloud-php/issues/2136)) ([51bcf57](https://www.github.com/googleapis/google-cloud-php/commit/51bcf57))

</details>

<details><summary>google/cloud-bigtable 0.14.0</summary>



### Features

* Add IAM `GetPolicyOptions` support and update retry and t… ([#2129](https://www.github.com/googleapis/google-cloud-php/issues/2129)) ([b957bb6](https://www.github.com/googleapis/google-cloud-php/commit/b957bb6))

</details>

<details><summary>google/cloud-core 1.30.0</summary>



### Bug Fixes

* Add documentation for new pubsub features and fix Duration handling. ([#2117](https://www.github.com/googleapis/google-cloud-php/issues/2117)) ([59fe42e](https://www.github.com/googleapis/google-cloud-php/commit/59fe42e))


### Features

* **storage:** Add CRC32c Checksums to Cloud Storage uploads. ([#1846](https://www.github.com/googleapis/google-cloud-php/issues/1846)) ([d4faff3](https://www.github.com/googleapis/google-cloud-php/commit/d4faff3))

</details>

<details><summary>google/cloud-dialogflow 0.9.0</summary>



### Features

* Add `single_utterance` to audio config, deprecate `single… ([#2137](https://www.github.com/googleapis/google-cloud-php/issues/2137)) ([4863be2](https://www.github.com/googleapis/google-cloud-php/commit/4863be2))
* Add SetAgent/DeleteAgent methods ([74d62c4](https://www.github.com/googleapis/google-cloud-php/commit/74d62c4))

</details>

<details><summary>google/cloud-dlp 0.21.0</summary>



### Features

* Add ability to publish findings to Cloud Data Catalog. ([#2103](https://www.github.com/googleapis/google-cloud-php/issues/2103)) ([e5bb551](https://www.github.com/googleapis/google-cloud-php/commit/e5bb551))

</details>

<details><summary>google/cloud-iot 0.8.0</summary>



### Features

* Add IAM `GetPolicyOptions` support. ([#2130](https://www.github.com/googleapis/google-cloud-php/issues/2130)) ([aa93e47](https://www.github.com/googleapis/google-cloud-php/commit/aa93e47))

</details>

<details><summary>google/cloud-kms 1.5.0</summary>



### Features

* Add IAM `GetPolicyOptions` support. ([#2131](https://www.github.com/googleapis/google-cloud-php/issues/2131)) ([65e7635](https://www.github.com/googleapis/google-cloud-php/commit/65e7635))

</details>

<details><summary>google/cloud-pubsub 1.14.0</summary>



### Bug Fixes

* Add documentation for new pubsub features and fix Duration handling. ([#2117](https://www.github.com/googleapis/google-cloud-php/issues/2117)) ([59fe42e](https://www.github.com/googleapis/google-cloud-php/commit/59fe42e))
* Fix update subscription method ([#2122](https://www.github.com/googleapis/google-cloud-php/issues/2122)) ([a0ae202](https://www.github.com/googleapis/google-cloud-php/commit/a0ae202))


### Features

* Add IAM `GetPolicyOptions` support. ([#2132](https://www.github.com/googleapis/google-cloud-php/issues/2132)) ([9245fe3](https://www.github.com/googleapis/google-cloud-php/commit/9245fe3))

</details>

<details><summary>google/cloud-spanner 1.16.0</summary>



### Features

* Add IAM `GetPolicyOptions` support. ([#2133](https://www.github.com/googleapis/google-cloud-php/issues/2133)) ([793420a](https://www.github.com/googleapis/google-cloud-php/commit/793420a))

</details>

<details><summary>google/cloud-speech 0.25.0</summary>



### Features

* Add SpeakerDiarizationConfig to v1p1beta1. ([#2126](https://www.github.com/googleapis/google-cloud-php/issues/2126)) ([d98c005](https://www.github.com/googleapis/google-cloud-php/commit/d98c005))
* Deprecate v1p1beta1 diarization fields in favor of `Speak… ([#2134](https://www.github.com/googleapis/google-cloud-php/issues/2134)) ([38198c6](https://www.github.com/googleapis/google-cloud-php/commit/38198c6))

</details>

<details><summary>google/cloud-storage 1.13.0</summary>



### Features

* **storage:** Add CRC32c Checksums to Cloud Storage uploads. ([#1846](https://www.github.com/googleapis/google-cloud-php/issues/1846)) ([d4faff3](https://www.github.com/googleapis/google-cloud-php/commit/d4faff3))

</details>

<details><summary>google/cloud-tasks 1.2.0</summary>



### Features

* Add IAM `GetPolicyOptions` support. ([#2135](https://www.github.com/googleapis/google-cloud-php/issues/2135)) ([94ac35f](https://www.github.com/googleapis/google-cloud-php/commit/94ac35f))

</details>
