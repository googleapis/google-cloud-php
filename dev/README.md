# Google Cloud PHP Development Scripts

The `dev` component features helpful development tools. Run `dev/google-cloud`
for a list of all available commands:

```sh
$ ./google-cloud
Available commands:
  completion                      Dump the shell completion script
  docfx                           Generate DocFX yaml from a phpdoc strucutre.xml
  help                            Display help for a command
  list                            List commands
 component
  component:add-version           Add a new version to an existing Component
  component:info                  [info] list info of a component or the whole library
  component:new                   Add a new Component
  component:update:deps           update a dependency across all components
  component:update:gencode        Update one or all components using Owlbot
  component:update:readme-sample  Add a sample to a component
 release
  release:info                    list information for a google-cloud-php release
  release:verify                  Verifies the package version from packagist.
 repo
  repo:compliance                 ensure all github repositories meet compliance
  repo:split                      [split] Split subtree and push to various remotes.
```

Additionally, there are scripts in the `sh` directory which are used in our CI:

| Command             | Description                 |
| ------------------- | --------------------------- |
| `sh/static-analysis`| Run phpstan static ananlysis|
| `sh/style-fix`      | Run phpcs style check       |
