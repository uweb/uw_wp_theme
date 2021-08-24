# Development workflow for New Theme / Golden Snitch

## Things to keep in mind
- You should NEVER work off of the main or develop branches. These branches control only what is ready to be tested (develop) or on in the release (main).

- We're using GitFlow branching model (but not the plugin for now)

- This repository itself holds the development files and must compiled into a release/artifact that lives in the uw_wp_theme folder and acts as a git submodule for its own release repo.

tl;dr: This is just for development and is not released to the public.

https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow

## Branches
- main (the release/production branch)
	- Hotfix branches [hotfix/], these are branches to fix critical bugs in production. Merged into develop and main when completed.
		- Example: hotfix/1.0.1

- develop (the primary development branch/what will go on cmsdev)
	- the develop branch is created from master only
	- Feature branches [feature/] these are for features that are actively in development.
		- example: feature/blogroll-shortcode

- release branches [release/]
	- the release branch is created from develop only
	- merged into main and development when completed
	- example: release/1.0

>note: NEVER rebase main, develop, or release branches. Golden rule of git: don't rewrite history at the source.

>You can rewrite history on the youngest children/child branches, but don't rewrite the parents/source branches.


## Before you Begin
Setting up your [Local](https://localwp.com/) development site to work with the theme config settings is key to make this workflow work.

1) In your Local (or Local by Flywheel) setup, create a new custom site.

2) give the site the URL: uw-multisite.local

3) Set it to be a multisite with subfolders (NOT subdomains)

4) use Apache, PHP v7.2 or higher, MySQL 5

5) Finish setting up WordPress and turn on your new local dev site (be sure to set your .htaccess file: https://wordpress.org/support/article/htaccess/#multisite)

6) Add a new site to you Network with the URL golden-snitch: http://uw-multisite.local/wp-admin/network/site-new.php

7) Add the Golden Snitch repository to the themes folder (see steps for setting up Git below)

Once you've completed all of these steps you're ready to start development. See the README.md file for how to develop with WpRig


## Steps for setting up Git & daily workflow
1) In command line, navigate to your golden-snitch repo

2) Checkout the develop branch `git checkout develop`

3) do a `git pull`

4) If there are updates, checkout the feature/ branch you're working on `git checkout feature/feature-name` and merge in the changes `git merge develop` You may need handle merge conflicts. Do these now!

5) If there are no updates, checkout or create your feature branch `git checkout -b feature/new-feature-name develop` (create branch off `develop`) or `git checkout feature/feature-name`

6) Do all your changes and development.

7) At the end of the day, don't forget to add all your changes to a commit and push them to GitHub.
```
git add .
git commit -m "commit message"
git push -u origin feature/feature-name
```

> If it is not your first time pushing the branch, you can simply type: `git push` as the last command.

## Steps when you're done with your feature
1) After you have pushed the final changes in your feature branch to GitHub, create a pull request.

2) Make sure your pull request is from your branch to the `develop` branch.

3) Fill out the pull request template detailing your feature/changes.

4) If there are merge issues, fix them (GitHub will tell you if the branches can be merged automatically).

5) Assign at least one reviewer and submit PR.

6) Reviewer(s) review PR and approve & merge or send back for questions/additional work.

7) Once merged, pull merged develop branch back to local
```
git checkout develop
git pull
```
9) You can then delete your feature branch (local and on GitHub) if you are done with it or continue working on it, if needed.

10) Lauren is in the process of creating a way to auto-magically push the develop branch to cmsdev for testing!

## Steps for reviewing a Pull Request
1) Grab the branch name from GitHub.

2) On your local system, checkout develop, fetch the feature branch, and check it out
```
git checkout develop
git fetch origin feature/branch-name
git checkout feature/branch-name
```
3) Run `npm run build` or `gulp` (runs same command in this case) to make sure everything builds

4) Review changes from the pull request

5) Approve/comment on the pull request in GitHub

6) If approved and no one else needs to review, merge the pull request - verify it is merging into `develop` or otherwise correct branch

7) Pull the latest `develop` branch back to your local system
```
git checkout develop
git pull origin develop
```
8) Go back to your feature branch and continue working [(see Steps for setting up Git & daily workflow)](#steps-for-setting-up-git-daily-workflow)

# Random git links & Resources
[Git housekeeping: clean-up outdated branches in local and remote repositories](https://railsware.com/blog/git-housekeeping-tutorial-clean-up-outdated-branches-in-local-and-remote-repositories/)

[Gitflow Workflow basics](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow)

# Creating a release from develop / developing new features

Releases foir uw_wp_theme should be created only from the main branch.

1) Checkout the develop branch locally, run `git pull`, and open dev/style.css and edit the theme version number to match the release number. The release number should use [semantic versioning](https://semver.org/). Look at previous release version before selecting a version number and *understand semver major/minor/patch version numbering*.


2) Create a [pull request](https://github.com/uweb/golden-snitch/pulls) to merge **develop** into the **main** branch. Give the PR a title that conveys this merge is for a release, note the release number.

3) Check for any conflicts and solve for them, then merge the PR into main. **Do not delete the develop branch after merging!**

4) In terminal, checkout the main branch of the repository and run `git pull`. Update the artifact to its latest point with `git submodule update`.

5) `npm run bundle` Build the new release artifact

6) `cd uw_wp_theme` Move into the release submodule folder

7) `git checkout master` Checkout the **master** branch

8) `git commit -a -m "updating to VERSION_NUMBER_HERE"` Make your commit and note the version number.

9) `git push origin master` Push your updates to the master branch.

10) `git tag VERSION_NUMBER_HERE` Tag your release with the version number.

11) `git push --tags` Push the tags, this is a separate step.

12) Return to the main directory `cd ../`

13) Add the submodule update and commit/push it, then tag the update.
```
git add .
git commit -m "created VERSION_NUMBER_VERION release artifact"
git push origin main
git tag VERSION_NUMBER_HERE
git push --tags
```

14) Merge all updates on main back to develop. Handle any merge conflicts to get develop to match up to main as closely as possible.
```
git checkout develop
git pull
git merge main
git push origin develop
```