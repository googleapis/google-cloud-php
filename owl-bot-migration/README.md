# A thrown-away script for migrating to owlbot


## Build the docker image

At the top level of the repository, run the following:

```sh
$ docker build -t owl-bot-migration -f owl-bot-migration/Dockerfile owl-bot-migration
```

## Run

At the top level of the repository, run the following:

```sh
$ docker run --user $(id -u):$(id -g) --rm -v $(pwd):/repo -w /repo owl-bot-migration AnalyticsAdmin
```

The last part is the target directory.
