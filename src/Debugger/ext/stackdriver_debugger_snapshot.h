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

#ifndef PHP_STACKDRIVER_DEBUGGER_SNAPSHOT_H
#define PHP_STACKDRIVER_DEBUGGER_SNAPSHOT_H 1

#include "php.h"

// extern zend_class_entry* stackdriver_debugger_snapshot_ce;

// Snapshot struct
typedef struct stackdriver_debugger_snapshot_t {
    zend_string *id;
    zend_string *filename;
    zend_long lineno;

    zend_string *condition;

    double createTime;
    double finalTime;

    zend_bool fulfilled;

    // array of evaluated expressions
    zval *evaluatedExpressions;

    // array of variables available at this point
    zval *variableTable;

} stackdriver_debugger_snapshot_t;

#endif /* PHP_STACKDRIVER_DEBUGGER_SNAPSHOT_H */
