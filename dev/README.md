# Google Cloud PHP Development Scripts

The `dev` component features helpful development tools. Run `dev/google-cloud`
for a list of all available commands:

| Command          | Description                                                      |
| ---------------- | ---------------------------------------------------------------- |
| `add-component`  | Generate a new library                                           |
| `component-info` | List component information                                       |
| `docfx`          | Generate DocFX YAML                                              |
| `release-info`   | List components and versions for a monorepo release              |
| `split`          | Split `google-cloud-php` into sub repositories and tag a release |


Additionally, there are scripts in the `sh` directory which are used in our CI:

| Command             | Description                 |
| ------------------- | --------------------------- |
| `sh/static-analysis`| Run phpstan static ananlysis|
