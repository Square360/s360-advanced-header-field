# Webpack Build Tool

This package will guide you through setting up your project's working enviroment.
It uses [Webpack](https://webpack.js.org/) to compile your JavaScript and SCSS
files. As part of the setup, it will download the
[S360 Fundamental Toolkit](https://bitbucket.org/sq360_sysadmin/s360-fundamental-toolkit),
which include several common libraries and SCSS variables. Please take a moment
to check out that repo's `README.md` file to see what's included.

- [Prerequisites](#prerequisites)
- [Installation](#installation)
  - [Upgrading from version 4](#upgrading-from-version-4)
- [Setup Commands](#setup-commands)
  - [Project](#project)
  - [Entrypoint](#entrypoint)
- [Install Commands](#install-commands)
- [Webpack Commands](#webpack-commands)
  - [watch](#watch)
  - [build:prod](#buildprod)
  - [build:dev](#builddev)

---

## Prerequisites

The following packages are needed before you can scaffold your package.

+ [NodeJS](https://nodejs.org/en/download/) v14 or greater
+ [yarn](https://yarnpkg.com/en/)

---

## Installation

Navigate to your projects root folder. If you're using a CMS like Drupal or
Wordpress, navigate to the theme's root folder.

Run the _**EXACT**_ commands below.

```bash
git clone git@bitbucket.org:sq360_sysadmin/base-project-setup.git assets
cd assets
yarn install
```

### Upgrading from version 4

When you need to upgrade an existing project's build tool with the latest
version, follow the steps below. **NOTE:** This is a manual process.

To begin, run the _**EXACT**_ commands below:
```bash
git clone git@bitbucket.org:sq360_sysadmin/base-project-setup.git assetsV5
cd assetsV5
yarn install
yarn setup:project
```
1. When asked for the "Project Name" make sure it matches the "projectName" from the `assets/config/build.config.ts` file. **NOTE:** This is very important in the coming steps.
2. If the existing project installed any packages from the [Install Commands](#install-commands), run those same commands now.
3. . If the existing project as any additional dependencies inside the `assets/package.json` file, install them now.
4. Replace the `assetsV5/src` folder with the `assets/src` folder.
5. Make sure all the "entryFiles" from `assets/config/build.config.ts` are in the `assetsV5/config/project.config.ts` file. **NOTE** The "entryFiles" must be a single line with no spaces between file names.
6. Replace webpack aliases. Theses are typically found in `assets/src/scss/[projectName]*.scss` and `assets/src/js/[projectName]*.js`
   1. "src:styles" with **SRC_STYLES**
   2. "src:images" with **SRC_IMAGES**
   3. "src:vendors" with **SRC_VENDORS**
7. Run the follow command: `yarn webpack:build:dev`
8. Only when the above compiles without error, should you delete the entire `assets` folder and rename `assetsV5` folder to `assets`.

---
## Setup Commands

There are several setup scripts which customize how this package defines your
project. They are seperated by task, so if there's something you don't need or
have no use for, you can ignore that script.

### Project

_**REQUIRED**_

Before you can start working on your project, there is a brief setup process you
have to do first. The following command will guide you though setting up your
project, installing optional 3rd party libraries and downloading the required
dependenices you will need to compile your JavaScript and SCSS files.

```bash
yarn run setup:project
```

After this step is complete that script will be removed from the `package.json`
file and replaced with [Webpack](#webpack) scripts.

### Entrypoint

```bash
yarn run setup:entrypoint -name [name_of_new_entrypoint]
```
---
## Install Commands

---

## Webpack Commands

After the project setup is complete, 3 webpack scripts become available for compiling.

### watch

The following command continually watches for changes to source files and
automatically compilies them. It does not minify, uglify or strip code comments.
This creates larger files, which aren't good for production. Primarily this
should used during the development phase.

**NOTE:** This process will always run until terminated.

```bash
yarn run webpack:watch
```

### build:prod

The following command will minify, uglify and strip all code comments from the
compiled JavaScript and CSS files. This creates smaller files, making them ready
for production. It also creates performant source map files. Primarily this
should used once your development is complete and you're ready for production.

**NOTE:** This process runs once then terminates.

```bash
yarn run webpack:build:prod
```

### build:dev

The following command will compile your source files once. It does not minify,
uglify or strip code comments. Primarily this should be used when you merge GIT
branches as the compiled files might be out of sync from the source files.

**NOTE:** This process runs once then terminates.

```bash
yarn run webpack:build:dev
```
