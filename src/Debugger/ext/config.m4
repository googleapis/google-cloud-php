PHP_ARG_ENABLE(stackdriver_debugger, whether to enable my extension,
[ --enable-stackdriver-debugger  Enable Stackdriver Debugger])

if test "$PHP_STACKDRIVER_DEBUGGER" = "yes"; then
  AC_DEFINE(HAVE_STACKDRIVER_DEBUGGER, 1, [Whether you have Stackdriver Debugger])
  PHP_NEW_EXTENSION(stackdriver_debugger, stackdriver_debugger.c, $ext_shared)
fi
