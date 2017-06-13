/*
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

#ifndef PHP_STACKDRIVER_H
#define PHP_STACKDRIVER_H 1

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "stackdriver_debugger.h"


#define PHP_STACKDRIVER_DEBUGGER_VERSION "0.1"
#define PHP_STACKDRIVER_DEBUGGER_EXTNAME "stackdriver_debugger"

#define PHP_STACKDRIVER_DEBUGGER_MAKE_STD_ZVAL(pzv) \
  pzv = (zval *)emalloc(sizeof(zval));
#define PHPSTACKDRIVER_DEBUGGER_FREE_STD_ZVAL(pzv) efree(pzv);

PHP_FUNCTION(stackdriver_debugger_version);

extern zend_module_entry stackdriver_debugger_module_entry;
#define phpext_stackdriver_debugger_ptr &stackdriver_debugger_module_entry

PHP_MINIT_FUNCTION(stackdriver_debugger);
PHP_MSHUTDOWN_FUNCTION(stackdriver_debugger);
PHP_RINIT_FUNCTION(stackdriver_debugger);
PHP_RSHUTDOWN_FUNCTION(stackdriver_debugger);

ZEND_BEGIN_MODULE_GLOBALS(stackdriver_debugger)
    // map of filename -> stackdriver_debugger_snapshot[]
    HashTable *debugger_snapshots;

    // map of snapshot id -> stackdriver_debugger_snapshot
    HashTable *debugger_snapshots_by_id;

ZEND_END_MODULE_GLOBALS(stackdriver_debugger)

extern ZEND_DECLARE_MODULE_GLOBALS(stackdriver_debugger)

#ifdef ZTS
#define        STACKDRIVER_DEBUGGER_G(v)        TSRMG(stackdriver_debugger_globals_id, zend_stackdriver_debugger_globals *, v)
#else
#define        STACKDRIVER_DEBUGGER_G(v)        (stackdriver_debugger_globals.v)
#endif

#endif /* PHP_STACKDRIVER_H */
