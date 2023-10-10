# Changelog

## [1.24.0](https://github.com/googleapis/gax-php/compare/v1.23.0...v1.24.0) (2023-10-10)


### Features

* Ensure NewClientSurface works for consoldiated v2 clients ([#493](https://github.com/googleapis/gax-php/issues/493)) ([cb8706e](https://github.com/googleapis/gax-php/commit/cb8706ef9211a1e43f733d2c8f272a330c2fa792))

## [1.23.0](https://github.com/googleapis/gax-php/compare/v1.22.1...v1.23.0) (2023-09-14)


### Features

* Typesafety for new surface client options ([#450](https://github.com/googleapis/gax-php/issues/450)) ([21550c5](https://github.com/googleapis/gax-php/commit/21550c5bf07f178f2043b0630f3ac34fcc3a05e0))

## [1.22.1](https://github.com/googleapis/gax-php/compare/v1.22.0...v1.22.1) (2023-08-04)


### Bug Fixes

* Deprecation notice while GapicClientTrait-&gt;setClientOptions ([#483](https://github.com/googleapis/gax-php/issues/483)) ([1c66d34](https://github.com/googleapis/gax-php/commit/1c66d3445dca4d43831a2f4e26e59b9bd1cb76dd))

## [1.22.0](https://github.com/googleapis/gax-php/compare/v1.21.1...v1.22.0) (2023-07-31)


### Features

* Sets api headers for "gcloud-php-new" and "gcloud-php-legacy"  surface versions ([#470](https://github.com/googleapis/gax-php/issues/470)) ([2d8ccff](https://github.com/googleapis/gax-php/commit/2d8ccff419a076ee2fe9d3dc7ecd5509c74afb4c))

## [1.21.1](https://github.com/googleapis/gax-php/compare/v1.21.0...v1.21.1) (2023-06-28)


### Bug Fixes

* Revert "chore: remove unnecessary api endpoint check" ([#476](https://github.com/googleapis/gax-php/issues/476)) ([13e773f](https://github.com/googleapis/gax-php/commit/13e773f5b09f9a99b8425835815746d37e9c1da3))

## [1.21.0](https://github.com/googleapis/gax-php/compare/v1.20.2...v1.21.0) (2023-06-09)


### Features

* Support guzzle/promises:v2 ([753eae9](https://github.com/googleapis/gax-php/commit/753eae9acf638f3356f8149acf84444eb399a699))

## [1.20.2](https://github.com/googleapis/gax-php/compare/v1.20.1...v1.20.2) (2023-05-12)


### Bug Fixes

* Ensure timeout set by RetryMiddleware is int not float ([#462](https://github.com/googleapis/gax-php/issues/462)) ([9d4c7fa](https://github.com/googleapis/gax-php/commit/9d4c7fa89445c63ec0bf4745ed9d98fd185ef51f))

## [1.20.1](https://github.com/googleapis/gax-php/compare/v1.20.0...v1.20.1) (2023-05-12)


### Bug Fixes

* Default value for error message in createFromRequestException ([#463](https://github.com/googleapis/gax-php/issues/463)) ([7552d22](https://github.com/googleapis/gax-php/commit/7552d22241c2f488606e9546efdd6edea356ee9a))

## [1.20.0](https://github.com/googleapis/gax-php/compare/v1.19.1...v1.20.0) (2023-05-01)


### Features

* **deps:** Support google/common-protos 4.0 ([af1db80](https://github.com/googleapis/gax-php/commit/af1db80c22307597f0dfcb9fafa86caf466588ba))
* **deps:** Support google/grpc-gcp 0.3 ([18edc2c](https://github.com/googleapis/gax-php/commit/18edc2ce6a1a615e3ea7c00ede313c32cec4b799))

## [1.19.1](https://github.com/googleapis/gax-php/compare/v1.19.0...v1.19.1) (2023-03-16)


### Bug Fixes

* Simplify ResourceHelperTrait registration ([#447](https://github.com/googleapis/gax-php/issues/447)) ([4949dc0](https://github.com/googleapis/gax-php/commit/4949dc0c4cd5e58af7933a1d2ecab90832c0b036))

## [1.19.0](https://github.com/googleapis/gax-php/compare/v1.18.2...v1.19.0) (2023-01-27)


### Features

* Ensure cache is used in calls to ADC::onGCE ([#441](https://github.com/googleapis/gax-php/issues/441)) ([64a4184](https://github.com/googleapis/gax-php/commit/64a4184ab69d13104d269b15a55d4b8b2515b5a6))

## [1.18.2](https://github.com/googleapis/gax-php/compare/v1.18.1...v1.18.2) (2023-01-06)


### Bug Fixes

* Ensure metadata return type is loaded into descriptor pool ([#439](https://github.com/googleapis/gax-php/issues/439)) ([a40cf8d](https://github.com/googleapis/gax-php/commit/a40cf8d87ac9aa45d18239456e2e4c96653f1a6c))
* Implicit conversion from float to int warning ([#438](https://github.com/googleapis/gax-php/issues/438)) ([1cb62ad](https://github.com/googleapis/gax-php/commit/1cb62ad3d92ace0518017abc972e912b339f1b56))

## [1.18.1](https://github.com/googleapis/gax-php/compare/v1.18.0...v1.18.1) (2022-12-06)


### Bug Fixes

* Message parameters in required querystring ([#430](https://github.com/googleapis/gax-php/issues/430)) ([77bc5e1](https://github.com/googleapis/gax-php/commit/77bc5e1cb8f347601d9237bf5164cf8b8ad8aa0f))

## [1.18.0](https://github.com/googleapis/gax-php/compare/v1.17.0...v1.18.0) (2022-12-05)


### Features

* Add ResourceHelperTrait ([#428](https://github.com/googleapis/gax-php/issues/428)) ([0439efa](https://github.com/googleapis/gax-php/commit/0439efa926865be5fea25b699469b0c1f8c1c768))

## [1.17.0](https://github.com/googleapis/gax-php/compare/v1.16.4...v1.17.0) (2022-09-08)


### Features

* Add startAsyncCall support ([#418](https://github.com/googleapis/gax-php/issues/418)) ([fc90693](https://github.com/googleapis/gax-php/commit/fc9069373c329183e07f8d174084c305b2308209))

## [1.16.4](https://github.com/googleapis/gax-php/compare/v1.16.3...v1.16.4) (2022-08-25)


### Bug Fixes

* use interfaceOverride instead of param ([#419](https://github.com/googleapis/gax-php/issues/419)) ([9dd5bc9](https://github.com/googleapis/gax-php/commit/9dd5bc91c4becfd2a0832288ab2406c3d224618e))

## [1.16.3](https://github.com/googleapis/gax-php/compare/v1.16.2...v1.16.3) (2022-08-23)


### Bug Fixes

* add eager threshold ([#416](https://github.com/googleapis/gax-php/issues/416)) ([99eb172](https://github.com/googleapis/gax-php/commit/99eb172280f301b117fde9dcc92079ca03aa28bd))

## [1.16.2](https://github.com/googleapis/gax-php/compare/v1.16.1...v1.16.2) (2022-08-16)


### Bug Fixes

* use responseType for custom operations ([#413](https://github.com/googleapis/gax-php/issues/413)) ([b643adf](https://github.com/googleapis/gax-php/commit/b643adfc44dd9fe82b0919e5b34edd00c7cdbb1f))

## [1.16.1](https://github.com/googleapis/gax-php/compare/v1.16.0...v1.16.1) (2022-08-11)


### Bug Fixes

* remove typehint from extended method ([#411](https://github.com/googleapis/gax-php/issues/411)) ([fb37f73](https://github.com/googleapis/gax-php/commit/fb37f7365e888465d84fca304ca83360ddbae6c3))

## [1.16.0](https://github.com/googleapis/gax-php/compare/v1.15.0...v1.16.0) (2022-08-10)


### Features

* additional typehinting ([#403](https://github.com/googleapis/gax-php/issues/403)) ([6597a07](https://github.com/googleapis/gax-php/commit/6597a07019665d91e07ea0a016c7d99c8a099cd2))
* drop support for PHP 5.6 ([#397](https://github.com/googleapis/gax-php/issues/397)) ([b888b24](https://github.com/googleapis/gax-php/commit/b888b24e0e223784e22dbbbe27fe0284cdcdfc35))
* introduce startApiCall ([#406](https://github.com/googleapis/gax-php/issues/406)) ([1cfeb62](https://github.com/googleapis/gax-php/commit/1cfeb628070c9c6e57b2dde854b0a973a888a2bc))


### Bug Fixes

* **deps:** update dependency google/longrunning to ^0.2 ([#407](https://github.com/googleapis/gax-php/issues/407)) ([54d4f32](https://github.com/googleapis/gax-php/commit/54d4f32ba5464d1f5da33e1c99a020174cae367c))

## [1.15.0](https://github.com/googleapis/gax-php/compare/v1.14.0...v1.15.0) (2022-08-02)


### Features

* move LongRunning classes to a standalone package ([#401](https://github.com/googleapis/gax-php/issues/401)) ([1747125](https://github.com/googleapis/gax-php/commit/1747125c84dcc6d42390de7e78d2e326884e1073))

## [1.14.0](https://github.com/googleapis/gax-php/compare/v1.13.0...v1.14.0) (2022-07-26)


### Features

* support requesting numeric enum rest encoding ([#395](https://github.com/googleapis/gax-php/issues/395)) ([0d74a48](https://github.com/googleapis/gax-php/commit/0d74a4877c5198cfaf534c4e55d7e418b50bc6ab))
