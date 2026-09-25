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
  component:breaking-changes      Detect backwards compatibility breaks in modified components
  component:info                  [info] list info of a component or the whole library
  component:new                   Add a new Component
  component:update                Update one or all components using Owlbot
  component:update:deps           update a dependency across all components
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

### Checking for Breaking Changes Between Releases

Use `component:breaking-changes` with `--base-ref` and `--target-ref` to inspect breaking changes between two releases or against the current branch:

```sh
# Check breaking changes between two release tags
./dev/google-cloud component:breaking-changes --base-ref=v0.56.0 --target-ref=v0.57.0

# Check all components modified since v0.346.0 on the current branch
./dev/google-cloud component:breaking-changes --base-ref=v0.346.0

# Check specific components against a release tag
./dev/google-cloud component:breaking-changes --base-ref=v0.346.0 -c Storage -c BigQuery
```

## Installation & Troubleshooting

When installing dependencies in the `dev` directory:

```sh
composer install -d dev/
```

If running `composer install` fails with:
> `No valid composer.json was found in any branch or tag of https://github.com/googleapis/gapic-generator-php.git`

This occurs on machines (such as gLinux or security-hardened Linux setups) where Git enforces `safe.bareRepository = explicit` by default, blocking Composer from accessing its VCS bare repository cache (`~/.cache/composer/vcs/`).

To resolve this safely without changing your global Git security configuration, pass the Git parameter inline when running `composer`:

```sh
GIT_CONFIG_PARAMETERS="'safe.bareRepository=all'" composer install -d dev/
```
