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

#include "php.h"
#include "php_stackdriver_debugger.h"
#include "stackdriver_debugger.h"
#include "zend_language_scanner.h"
#include "zend_language_parser.h"
// #include "debug.h"
#include "ext/standard/php_string.h"
#include "Zend/zend_virtual_cwd.h"
#include "zend_extensions.h"

// True global for storing the original zend_ast_process
static void (*original_zend_ast_process)(zend_ast*);

ZEND_DECLARE_MODULE_GLOBALS(stackdriver_debugger)

// List of functions provided by this extension
static zend_function_entry stackdriver_debugger_functions[] = {
    PHP_FE(stackdriver_debugger_version, NULL)
    PHP_FE(stackdriver_debugger, NULL)
    PHP_FE(stackdriver_debugger_add_snapshot, NULL)
    PHP_FE_END
};

// Registers the lifecycle hooks for this extension
zend_module_entry stackdriver_debugger_module_entry = {
    STANDARD_MODULE_HEADER,
    PHP_STACKDRIVER_DEBUGGER_EXTNAME,
    stackdriver_debugger_functions,
    PHP_MINIT(stackdriver_debugger),
    PHP_MSHUTDOWN(stackdriver_debugger),
    PHP_RINIT(stackdriver_debugger),
    PHP_RSHUTDOWN(stackdriver_debugger),
    NULL, // name of the MINFO function or NULL if not applicable
    PHP_STACKDRIVER_DEBUGGER_VERSION,
    STANDARD_MODULE_PROPERTIES
};

ZEND_GET_MODULE(stackdriver_debugger)

// returns the version of the stackdriver extension
PHP_FUNCTION(stackdriver_debugger_version)
{
    RETURN_STRING(PHP_STACKDRIVER_DEBUGGER_VERSION);
}

static void php_stackdriver_debugger_globals_ctor(void *pDest TSRMLS_DC)
{
    zend_stackdriver_debugger_globals *stackdriver_debugger_global = (zend_stackdriver_debugger_globals *) pDest;
}

/**
 * This method generates a new abstract syntax tree that injects a function call to
 * `stackdriver_debugger()`.
 *
 * TODO: store variables
 * TODO: store call stack
 * TODO: deregister
 * TODO: add conditional triggering of debugger function
 * TODO: catch exceptions
 *
 * Format:
 *
 *   ZEND_AST_STMT_LIST
 *   - ZEND_AST_CALL
 *     - ZEND_AST_ZVAL (string, "stackdriver_debugger")
 *     - ZEND_AST_ARG_LIST (empty list)
 *   - original zend_ast node
 *
 * Note: we are emalloc-ing memory here, but it is expected that the PHP internals recursively
 * walk the syntax tree and free allocated memory. This method cannot leave dangling pointers or
 * the allocated memory may never be freed.
 */
static zend_ast *stackdriver_debugger_create_debugger_ast(zend_ast *current, stackdriver_debugger_snapshot_t *snapshot)
{
    zend_ast *newCall;
    zend_ast_zval *var, *snapshotId;
    zend_ast_list *newList, *argList;

    var = emalloc(sizeof(zend_ast_zval));
    var->kind = ZEND_AST_ZVAL;
    ZVAL_STRING(&var->val, "stackdriver_debugger");
    var->val.u2.lineno = current->lineno;

    snapshotId = emalloc(sizeof(zend_ast_zval));
    snapshotId->kind = ZEND_AST_ZVAL;
    ZVAL_STRING(&snapshotId->val, estrdup(ZSTR_VAL(snapshot->id)));
    snapshotId->val.u2.lineno = current->lineno;

    argList = emalloc(sizeof(zend_ast_list) + sizeof(zend_ast*));
    argList->kind = ZEND_AST_ARG_LIST;
    argList->lineno = current->lineno;
    argList->children = 1;
    argList->child[0] = (zend_ast*)snapshotId;

    newCall = emalloc(sizeof(zend_ast) + sizeof(zend_ast*));
    newCall->kind = ZEND_AST_CALL;
    newCall->lineno = current->lineno;
    newCall->child[0] = (zend_ast*)var;
    newCall->child[1] = (zend_ast*)argList;

    // create a new statement list
    newList = emalloc(sizeof(zend_ast_list) + sizeof(zend_ast*));
    newList->kind = ZEND_AST_STMT_LIST;
    newList->lineno = current->lineno;
    newList->children = 2;
    newList->child[0] = newCall;
    newList->child[1] = current;

    return (zend_ast *)newList;
}

/**
 * This method walks through the AST looking for the last non-list statement to replace
 * with a new AST node that first calls the `stackdriver_debugger()` function, then
 * calls the original statement.
 *
 * This function returns SUCCESS if we have already injected into the syntax tree.
 * Otherwise, the function returns FAILURE.
 */
static int stackdriver_debugger_inject(zend_ast *ast, stackdriver_debugger_snapshot_t *snapshot)
{
    int i, num_children;
    zend_ast *current;
    zend_ast_list *list;
    zend_ast_decl *decl;
    zend_ast_zval *azval;

    if (ast->kind >> ZEND_AST_IS_LIST_SHIFT == 1) {
        list = (zend_ast_list*)ast;

        for (i = list->children - 1; i >= 0; i--) {
            current = list->child[i];
            if (current->lineno <= snapshot->lineno) {
                // if not yet injected, inject the debugger code
                if (stackdriver_debugger_inject(current, snapshot) != SUCCESS) {
                    list->child[i] = stackdriver_debugger_create_debugger_ast(current, snapshot);
                }
                return SUCCESS;
            }
        }
        return FAILURE;
    } else if (ast->kind >> ZEND_AST_SPECIAL_SHIFT == 1) {
        switch(ast->kind) {
            case ZEND_AST_FUNC_DECL:
            case ZEND_AST_CLOSURE:
            case ZEND_AST_METHOD:
            case ZEND_AST_CLASS:
                decl = (zend_ast_decl *)ast;
                return stackdriver_debugger_inject(decl->child[2], snapshot);
            case ZEND_AST_ZVAL:
            case ZEND_AST_ZNODE:
                azval = (zend_ast_zval *)ast;
                break;
            default:
                php_printf("Unknown special type\n");
        }
    } else {
        // number of nodes
        num_children = ast->kind >> ZEND_AST_NUM_CHILDREN_SHIFT;
        if (num_children == 4) {
            // found for or foreach, the 4th child is the body
            return stackdriver_debugger_inject(ast->child[3], snapshot);
        }
    }
    return FAILURE;
}

/**
 * This function replaces the original `zend_ast_process` function. If one was previously provided, call
 * that one after this one.
 */
static void stackdriver_debugger_ast_process(zend_ast *ast)
{
    HashTable *ht;
    stackdriver_debugger_snapshot_t *snapshot;

    zval *debugger_snapshots = zend_hash_find(STACKDRIVER_DEBUGGER_G(debugger_snapshots), CG(compiled_filename));
    if (debugger_snapshots != NULL) {
        ht = Z_ARR_P(debugger_snapshots);

        ZEND_HASH_FOREACH_PTR(ht, snapshot) {
            stackdriver_debugger_inject(ast, snapshot);
        } ZEND_HASH_FOREACH_END();
    }

    // call the original zend_ast_process function if one was set
    if (original_zend_ast_process) {
        original_zend_ast_process(ast);
    }
}

PHP_FUNCTION(stackdriver_debugger)
{
    zend_string *var_name, *snapshotId = NULL;
    zval *entry, *orig_var;
    zend_array *symbols = zend_rebuild_symbol_table();
    stackdriver_debugger_snapshot_t *snapshot;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|S", &snapshotId) == FAILURE) {
        RETURN_FALSE;
    }

    if (snapshotId != NULL) {
        php_printf("stackdriver_debugger id: %s\n", ZSTR_VAL(snapshotId));
        snapshot = zend_hash_find_ptr(STACKDRIVER_DEBUGGER_G(debugger_snapshots_by_id), snapshotId);
    }

    if (snapshot) {
        php_printf("found snapshot: %s, file: %s, line: %d\n", ZSTR_VAL(snapshot->id), ZSTR_VAL(snapshot->filename), snapshot->lineno);

        if (snapshot->fulfilled) {
            php_printf("snapshot already fulfilled... skipping\n");
            return;
        }
    }

    ZEND_HASH_FOREACH_STR_KEY_VAL(symbols, var_name, entry) {
        orig_var = zend_hash_find(symbols, var_name);
        if (orig_var) {
            php_printf("var name: %s\n", ZSTR_VAL(var_name));

            // dump_zval(orig_var);
        }
    } ZEND_HASH_FOREACH_END();

    if (snapshot) {
        snapshot->fulfilled = 1;
    }
}

zend_string *stackdriver_debugger_full_filename(zend_string *relative_or_full_path, zend_string *current_file)
{
    zend_string *basename = php_basename(ZSTR_VAL(current_file), ZSTR_LEN(current_file), NULL, 0);
    size_t dirlen = php_dirname(ZSTR_VAL(current_file), ZSTR_LEN(current_file));
    zend_string *dirname = zend_string_init(ZSTR_VAL(current_file), dirlen, 0);

    zend_string *fullname = strpprintf(ZSTR_LEN(dirname) + 2 + ZSTR_LEN(current_file), "%s%c%s", ZSTR_VAL(dirname), DEFAULT_SLASH, ZSTR_VAL(relative_or_full_path));
    zend_string_release(basename);
    zend_string_release(dirname);

    // php_printf("Calculate full filename: %s, current: %s\n", ZSTR_VAL(relative_or_full_path), ZSTR_VAL(current_file));
    // php_printf("fullname: %s\n", ZSTR_VAL(fullname));

    return fullname;
}

PHP_FUNCTION(stackdriver_debugger_add_snapshot)
{
    zend_string *filename, *full_filename, *snapshot_id = NULL, *condition = NULL;
    zend_long lineno;
    zval *snapshots, *snapshot_ptr;
    stackdriver_debugger_snapshot_t *snapshot;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "Sl|SS", &filename, &lineno, &snapshot_id, &condition) == FAILURE) {
        RETURN_FALSE;
    }

    full_filename = stackdriver_debugger_full_filename(filename, EX(prev_execute_data)->func->op_array.filename);

    // TODO: clean this up in rshutdown
    PHP_STACKDRIVER_DEBUGGER_MAKE_STD_ZVAL(snapshot_ptr);
    snapshot = emalloc(sizeof(stackdriver_debugger_snapshot_t));

    if (snapshot_id == NULL) {
        snapshot->id = strpprintf(20, "%d", php_mt_rand());
    } else {
        snapshot->id = snapshot_id;
    }
    snapshot->filename = full_filename;
    snapshot->lineno = lineno;
    if (condition != NULL) {
        snapshot->condition = condition;
    }
    snapshot->fulfilled = 0;

    ZVAL_PTR(snapshot_ptr, snapshot);

    snapshots = zend_hash_find(STACKDRIVER_DEBUGGER_G(debugger_snapshots), full_filename);
    if (snapshots == NULL) {
        // initialize snapshots as array
        // TODO: clean this up in rshutdown
        PHP_STACKDRIVER_DEBUGGER_MAKE_STD_ZVAL(snapshots);
        array_init(snapshots);
    }

    add_next_index_zval(snapshots, snapshot_ptr);

    zend_hash_update(STACKDRIVER_DEBUGGER_G(debugger_snapshots), full_filename, snapshots);
    zend_hash_update(STACKDRIVER_DEBUGGER_G(debugger_snapshots_by_id), snapshot->id, snapshot_ptr);
}


/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(stackdriver_debugger)
{
    // allocate global request variables
#ifdef ZTS
    ts_allocate_id(&stackdriver_debugger_globals_id, sizeof(zend_stackdriver_debugger_globals), php_stackdriver_debugger_globals_ctor, NULL);
#else
    php_stackdriver_globals_ctor(&php_stackdriver_debugger_globals_ctor);
#endif

    // Save original zend_ast_process function and use our own to modify the ast
    original_zend_ast_process = zend_ast_process;
    zend_ast_process = stackdriver_debugger_ast_process;

    return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(stackdriver_debugger)
{
    zend_ast_process = original_zend_ast_process;

    return SUCCESS;
}
/* }}} */

PHP_RINIT_FUNCTION(stackdriver_debugger)
{
    ALLOC_HASHTABLE(STACKDRIVER_DEBUGGER_G(debugger_snapshots));
    zend_hash_init(STACKDRIVER_DEBUGGER_G(debugger_snapshots), 16, NULL, ZVAL_PTR_DTOR, 0);

    ALLOC_HASHTABLE(STACKDRIVER_DEBUGGER_G(debugger_snapshots_by_id));
    zend_hash_init(STACKDRIVER_DEBUGGER_G(debugger_snapshots_by_id), 16, NULL, ZVAL_PTR_DTOR, 0);

    return SUCCESS;
}

/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(stackdriver_debugger)
{
    return SUCCESS;
}
/* }}} */
