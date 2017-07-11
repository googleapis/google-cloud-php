# How to contribute to gcloud

Thank you for your interest in contributing to [gcloud](https://github.com/GoogleCloudPlatform). The APIs of the [Google Cloud Platform](https://cloud.google.com/) constitute a huge offering that continues to expand at a rapid pace. Because there is so much work to do to make the gcloud libraries the best-ever way to access these APIs, we desperately need your help. Your contributions are more than just welcome, they are essential.

Therefore, out of respect for your time and effort, we are trying hard to make contributing to gcloud a safe, efficient, and well-defined process. If you encounter any difficulty during the process, do not hesitate to [get in touch](/troubleshooting/readme.md).

## Signing the Contributor License Agreement (CLA)

Open-source software licensing is a wonderful arrangement that benefits everyone, but in an imperfect world, we all need to exercise some legal prudence. In order to protect you, Google, and most of all, everyone who comes to depend on these libraries, we require that all contributors sign our short and human-readable Contributor License Agreement (CLA). We don't want to open the door to patent trolls, predatory lawyers, or anyone else who isn't on board with creating value and making the world a better place. We hope you will agree that the CLA offers very important protection and is easy to understand. Take a moment to read it carefully, and if you agree with what you read, please sign it now. If you believe you've already signed the appropriate CLA already for this or any other Google open-source project, you shouldn't have to do so again. You can review your signed CLAs at [cla.developers.google.com/clas](https://cla.developers.google.com/clas).

First, check that you are signed in to a [Google Account](https://accounts.google.com) that matches your [local Git email address](https://help.github.com/articles/setting-your-email-in-git/). Then choose one of the following:

* If you are **an individual writing original source code** and **you own the intellectual property**, sign the [Individual CLA](https://developers.google.com/open-source/cla/individual).
* If you work for **a company that wants to allow you to contribute**, sign the [Corporate CLA](https://developers.google.com/open-source/cla/corporate).

You (and your authorized signer, if corporate) can sign the CLA electronically. After that, we'll be able to accept your contributions.

## Opening an issue

If you've tried everything in our [Troubleshooting](https://github.com/GoogleCloudPlatform/gcloud-common/blob/master/troubleshooting/readme.md) guide and are still running into problems, it is probably time to open a GitHub issue. GitHub provides a guide, [Mastering Issues](https://guides.github.com/features/issues/), that is useful if you are unfamiliar with the process. Here are the specific steps for opening a gcloud issue:

1. Go to the project issues page on GitHub.
1. Click the green `New Issue` button located in the upper right corner.
1. In the title field, write a single phrase that identifies your issue, including service, class, and method names if appropriate.
1. In the main editor, describe your issue. The details of your description will vary depending on your issue type, as follows:
    * `bug` - Document the steps to reproduce. List relevant details about your environment, especially your Ruby version. Include the full stack trace (backtrace) if there is an exception.
    * `enhancement` - Put on your salesman hat and sell your proposed feature. If you can, link to some compelling external examples.
    * `docs` - Helping us improve the project documentation should not be a hassle. Just quickly let us know where the problem is, and jot down a suggestion or two for making things better.
1. Click the submit button.

Thank you. We will do our best to comment on your issue within one business day.

## Finding something to work on

The GitHub project issues page is the place to look for shovel-ready work. Here are some suggestions for your first contribution, listed in ascending order of effort and difficulty.

* Confirm a `bug` issue by reproducing it in your own environment and adding a comment detailing what you found.
* Review a pull request by checking out the creator's branch, and examining the change in your own environment.
* Offer to work on a `docs` issue.
* Offer to work on a `bug` issue.

If you can't find anything actionable, be sure to check back again in a week or so.

## Making changes to gcloud

The following is a high-level overview of how to contribute to a gcloud client library:

1. [Open an issue](#opening-an-issue) to ensure that your work is coordinated with the efforts of others.

1. Sign the [Contributor License Agreement (CLA)](#signing-the-contributor-license-agreement-cla).

1. Clone the project repository from GitHub.

  ```sh
  $ git clone git@github.com:GoogleCloudPlatform/<project-name>.git
  ```

1. Set up your local development environment.

1. Run the project tests. You need to be certain that all tests are passing in your local environment before you make any changes.

1. Create a new local branch.

  ```sh
  $ git checkout -b <new-issue-name>
  ```

1. Make changes. Be sure to edit or add API documentation for your changes.

1. Edit or add tests. All contributions must include tests that ensure the contributed code behaves as expected. (You did this in the previous step? Congrats, you just scored the TDD badge.)

1. Check your coding style. Please follow the style guide for the library.

1. Run the tests again.

1. Commit your code. Take a moment to write a [good commit message](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html). If you end up with several commits for one logical change, [squash](https://git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Squashing-Commits) these commits for clarity.

1. On GitHub, [create a fork](https://guides.github.com/activities/forking/) of the project.

1. Add your fork as a remote to your local repository:

  ```sh
  $ git remote add <your-username> git@github.com:<your-username>/<project-name>.git
  ```

1. Push your branch to your fork.

  ```sh
  $ git push <your-username> <new-issue-name>
  ```

1. On the GitHub page for your fork and branch, create a [pull request](https://help.github.com/articles/using-pull-requests/) by clicking `Compare & pull request`. Edit the message copied from your commit, adding more detail if needed, then click `Create pull request`.

Your pull request is where we (and anyone else who is interested) will discuss your change.

## Verifying your contribution

Be sure to check your pull request for a `cla:yes` label. If you see a `cla:no` label, verify that you have [signed the CLA](#signing-the-contributor-license-agreement-cla) using a Google Account that matches your Git email. Once your pull request has the `cla:yes` label, look out for an email notification that either your pull request has been merged, or someone has requested a little more work on it. If more work is needed, repeat **steps 5**, **7-11**, and **14**. Then, let us know when you're done and we'll take another look.

Happy contributing! And, once again, thank you.
