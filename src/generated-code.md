# What Are Generated Code Clients?

Google engineers have generated API clients for each language, which
are used to communicate directly with a specific version of a service via
[gRPC](https://grpc.io). Many services in Google Cloud PHP offer a generated
client in addition to the base client.

These generated clients are used by Google Cloud PHP under the hood to communicate with
Google Cloud services via gRPC. They are also available for use directly by you.

### Should I Use a Generated Client?

If you require a specific version of an API, the Generated Code may be best. Google
Cloud PHP libraries generally use the latest version of an API. The Generated Code clients
are also much closer to a 1:1 API client. If you are familiar with the specifics
of a service, vkit may be more familiar to you. Google Cloud PHP clients attempt
to provide simple, language-idiomatic access to Google Cloud services over a
direct mapping.

### What are the requirements for using Generated Code clients?

* Using Generated Code requires the [gRPC PHP extension](https://pecl.php.net/package/gRPC)
to be enabled on your server.
