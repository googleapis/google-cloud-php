# Firestore System Test Important Information

Firestore does not use the global deletion queue for cleanup. Like datastore, it
uses a local deletion queue, defined in `FirestoreTestCase` and available in all
classes extending that class as `self::$localDeletionQueue`.

Documents should not be added to the deletion queue. Instead, collections should
be added to the deletion queue. Any collection created by the system test suite
MUST be enqueued for deletion, and MUST use a unique name (i.e. `uniqid($testingPrefix)`).
This applies to nested collections as well!
