# UW WordPress Theme
![UW WordPress Theme version 0.1.0](https://img.shields.io/badge/version-0.1.0-blue.svg)

## UW WordPress Theme was built using WP Rig

This theme was build using [WP Rig](https://wprig.io/) ([GitHub](https://github.com/wprig/wprig/)) 1.0.4.

## Requirements
The UW WordPress Theme theme requires the following dependencies. Full installation instructions are provided at their respective websites.

- [PHP](http://php.net/) 7.0
- [npm](https://www.npmjs.com/)
- [Composer](https://getcomposer.org/) (**installed globally**)

## Theme features

The UW WordPress Theme theme includes the following features.

- [Bootstrap 4](https://getbootstrap.com/) integration
- Mobile-first
- Progressive enhancement
- Dynamic loading of JS/CSS files
- AMP-ready
- Component-based development

The UW WordPress Theme theme uses the following development tools. These will all be installed for you as part of the package installation. *Note: if you already have Gulp installed, please make sure you are using version 4.*

- [BrowserSync](https://browsersync.io/)
- [Gulp 4](https://gulpjs.com/)
- [WordPress coding standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/)
- [Babel](https://babeljs.io/)
- [PostCSS](https://postcss.org/)
- [ESLint](https://eslint.org/)
- VS Code integration

## Installation
1. Clone or download this repository to the themes folder of a WordPress site on your development environment.
2. Configure theme settings including the theme slug and name in `./dev/config/themeConfig.js`.
3. In command line, run `npm install` to install necessary node and Composer dependencies.
4. In command line, run `npm run build` to generate the theme.
5. In WordPress admin, activate the theme.
6. When you are ready to start development, run `gulp`.

## Recommended code editor extensions
To take full advantage of the features in this theme, your code editor needs support for the following features:

- [EditorConfig](http://editorconfig.org/#download)
- [ESLint](https://eslint.org/docs/user-guide/integrations)
- [PHP CodeSniffer (phpCS)](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki)

## Working with the UW WordPress Theme theme
*Please note some of this section has been copied from the WP Rig README.*

You can install this theme in any development environment.

UW WordPress Theme uses [BrowserSync](https://browsersync.io/) to enable synchronized browser testing. To take advantage of this feature, configure the `proxy` wrapper settings in `./dev/config/themeConfig.js` to match your local development environment. The `URL` value is the URL to the live version of your local site.

UW WordPress Theme uses a [Gulp 4](https://gulpjs.com/) build process to generate and optimize the code for the theme. All development is done in the `/dev` folder and Gulp preprocesses, transpiles, and compiles the files into the root folder. The root folder files become the active theme. WordPress ignores anything in the `/dev` folder.

**Note:** If you have previously used Gulp, you may encounter seemingly random errors that prevent the build process from running. To fix this issue, [upgrade to Gulp 4 following the steps outlined in the WP Rig Wiki](https://github.com/wprig/wprig/wiki/Updating-to-Gulp-4).

JavaScript files are automatically linted using [ESLint](https://eslint.org/) in accordance with [WordPress Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/).

PHP and CSS files are automatically linted using [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) in accordance with [WordPress Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/). To take full advantage of this setup, configure your code editor / IDE to automatically test for the WordPress Coding Standards.

Details on how to enable PHPCS in VS Code can be found in the [WP Rig Wiki](https://github.com/wprig/wprig/wiki/Enabling-PHPCodeSniffer-(PHPCS)-in-VS-Code). More details on how to work with PHPCS and WordPress Coding Standards can be found at the [WordPress Coding Standards Wiki](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki). `composer run-phpcs` runs PHPCS locally. *Note: It can be tricky to get this set up correctly in your environment but it's worth it!*

### `build` process
`npm run build` is the regular development process. While this process is running, files in the `./dev/` folder will be automatically compiled to the live theme and BrowserSync will update if it is enabled. *Note: this is the same as running `gulp`.*

### `translate` process
`npm run translate` generates a `.pot` file for the theme to enable translation. The translation file will be stored in `./languages/`.

### `bundle` process
`npm run bundle` generates a `[themename].zip` archive containing the finished theme. This runs all relevant tasks in series ending with the translation task and the bundle task and stores a new zip archive in the root theme folder.
To bundle the theme without creating a zip archive, change the `export:compress` setting in `./dev/config/themeConfig.js`:

```javascript
export: {
	compress: false
}
```

## Component-based approach
*Please note this section was copied from the WP Rig README.*

UW WordPress Theme takes a component-based approach to WordPress themes. Out of the box, the compiled theme uses `index.php` as the core template file for all views (index, archives, single posts, pages, etc). The `/optional` folder holds optional template files that can be accessed via the [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/). To activate these files, move or copy them into the root `/dev` folder. The `/optional` folder is ignored by the Gulp build process.

The separation of Pluggable and External features into their own folders allows the theme developer to swap out any feature for an external feature (AMP components) or non-php feature (JavaScript framework etc) without interfering with the core theme functions.

Pluggable functions and features (e.g. custom header, sliders, other interactive components) are separated into the `/pluggable` folder for easy access. When custom stylesheets and/or JavaScript files are needed, the pluggable component and its dependent files should be placed in a sub-folder to retain separation of concerns.

External features and add-ons are separated into the `/external` folder and are managed the same way as Pluggable functions.

Images and graphics are placed in the `/images` folder and are optimized automatically.

Global JavaScript files are placed in the `/js` folder and linted and optimized automatically. External JavaScript libraries are placed in the `/js/libs` folder. _These files are not linted or optimized by the Gulp process_.

Global stylesheets and stylesheets related to root-level php files are placed in the `/css` folder and are optimized automatically.

Content loop files are placed in the `/template-parts` folder.

`style.css` is loaded in `<head>` through a `wp_enqueue_style()` call in `functions.php`. It is the main stylesheet and serves up global styles and layouts only.

## Progressive Features
*Please note this section was copied from the WP Rig README.*

### Progressive loading of CSS
To further componentize the theme, UW WordPress Theme employs progressive loading of CSS through [in-body `<link>` tags](https://jakearchibald.com/2016/link-in-body/). Component-specific styles are held in component-specific stylesheets and loaded at component level. The `wprig_add_body_style()` in `./dev/inc/template-functions.php` can be used to conditionally preload in-body stylesheets for improved performance.
This approach has several advantages:
- The main stylesheet file size is reduced
- Styles are only loaded if and when a component is present in the view.
- Stylesheets are associated with their components making them easier to work with.
- Leverages HTTP/2 multiplexing and can be extended to include server push etc.
- Component-level stylesheets are cached and can be individually updated without forcing reload of all styles on the site.

To improve the performance of the theme, progressively loaded stylesheets can be conditionally preloaded. This is done using the `wprig_add_body_style()` function in `./dev/inc/template-functions.php`. When preloading a stylesheet, use the console in Chrome developer tools to ensure no unnecessary stylesheets are loaded. A warning will appear letting you know if a stylesheet is preloaded but not used.

### Modern CSS, custom properties (variables), autoprefixing, etc
All CSS is processed through [PostCSS](http://postcss.org/) and leveraging [postcss-preset-env](https://preset-env.cssdb.org/) to allow the use of modern and future CSS markup like [custom properties (variables)](https://developer.mozilla.org/en-US/docs/Web/CSS/Using_CSS_variables). Variables are defined in `./dev/config/cssVariables` and applied to all CSS files as they are processed.
postcss-preset-env (previously cssnext) passes all CSS through Autoprefixer to ensure backward compatibility. [Target browsers](https://github.com/browserslist/browserslist) are configured under `browserlist` in `./dev/config/cssVariables`.

### Modern layouts through CSS grid, flex, and float
The theme generated by WP Rig is mobile-first and accessible. It uses the modern layout modules CSS grid and flex to support a minimalist HTML structure.

For backward compatibility with browsers who do not support modern layout modules, WP Rig provides the mobile-first layout across all screen widths and serves two-dimensional layouts as a progressive enhancement.

## Shortcodes

### Accordion

This accordion shortcode uses the [Bootstrap collapse](https://getbootstrap.com/docs/4.6/components/collapse/), with additional keyboard accessibility added per [WAI-ARIA Authoring Practices 1.1](https://www.w3.org/TR/wai-aria-practices/examples/accordion/accordion.html).

Example:

```
[accordion name="Accessible Accordion"]
    [section title="Example"] Section[/section]
    [section title="Example"] Section[/section]
    [section title="Example"] Section[/section]
[/accordion]
```

Options include defaulting an accordion open. For example:

```
[accordion name="Accessible Accordion"]
    [section title="Example" active="true"] Section[/section]
    [section title="Example"] Section[/section]
    [section title="Example"] Section[/section]
[/accordion]
```


### Blogroll ###

>  This is a shortcode that wraps the WordPress [get\_posts](https://codex.wordpress.org/Template_Tags/get_posts) function and templates out a blogroll. Any parameter you can pass to `get_posts` will be understood along with the following.

> Attributes:

> - **excerpt** : Choose whether to show the excerpt in the blogroll. Options: **show**, **hide**. (_Default: hide_)
> - **trim** : Whether or not to trim the words via WordPress [wp\_trim\_words](https://codex.wordpress.org/Function_Reference/wp_trim_words) function. Options: **true**, **false**. (_Default: _false)
> - **image**:  Choose whether to show the featured image thumbnail. Options: **show**, **hide**. (_Default: hide_)
> - **author**: Choose whether to show the author. Options: **show**, **hide**. (_Default: show_)
> - **date**:  Choose whether to show the publish date. Options: **show**, **hide**. (_Default: show_)
> - **titletag**:  The html element for the post titles. (_Default: h2_)
> - **post\_type**:  The post type to look for.(_Default: post_)
> - **number**:  The maximum number of results to return (_Default: 5_)
> - **mini**:  Use the miniture template instead of the default one. (_Default: false_)
> - **category**:  The WordPress category ID to limit the results from. (_Default: None_)
> - **category\_name**:  The WordPress category name to limit the results from. (_Default: None_)
> - **readmore**: Choose whether to show the "Read More" link or not. Options: **on**, **off**. (_Default: on_)

> Example:
```
  [blogroll number=3 trim=true readmore='off']
```


### Buttons

This is a UW-branded button. Add the button text between the `[uw_button][/uw_button]` shortcode.

Attributes:

* **style**:  Adjusts the image of the button. Options: arrow, primary, secondary, square-outline. (_Default: square-outline_)
* **size**:  Adjusts the size of the button. Options: large, small. (_Default: large_)
* **color**:  The color of the button. Options: white, purple, light-gold, gold. (_Default: none_)
* **target**:  The URL for the link or download that you want to direct the user to on click. (_Default: none_)

Example:
```
[uw_button style="arrow" size="large" color="gold" target="#"](button copy)[/uw_button]
```

### Custom Link

This shortcode simply takes in the url and parameter text (link text) you desire and generates a hyperlink for you with the url and the link text in it.

Attributes:

* **url**: The url you would like to be linked.

Example:

```
[customlink url="the url you want"] Link text [/customlink]
```

### Custom Menu

This shortcode pulls in a custom menu that can be created under Dashboard > Appearance > Menus. Icons can be added in the class field in the menu builder. View the full set of icons for more information.

Attributes:

* **menu**: Enter the name of the menu found in Dashboard > Appearance > Menus. (_Default: Main menu_)

Example:

```
[custommenu menu=Menu-name-here]
```

### Grid

For dividing your content into columns of various widths.

Example:

```
[row]
    [col class='col-md-12']Text[/col]
[/row]
```

### Intro ###
> This shortcode creates an italicized block of introduction text for the content.

> No attributes.

> Example:

```
  [intro] A block on introductory text for the content. [/intro]
```

### Modals

For adding a modal. Anything placed inside the `[uw_modal][/uw_modal]` shortcode will appear in the modal.

Attributes:

* **id**: The id of the modal, to be used for styling or additional functionality. (_Default: none_)
* **button**:  The button text. (_Default: none_)

Example:

```
[uw_modal id="arts" button="Arts"](modal content)[/uw_modal]
```

### Subpage List

This shortcode lists out all the subpages relative to the current page. There are two views this shortcode can render: list or grid. The list view displays all the subpages as anchor tags in an HTML list element. The grid view displays all the subpages as boxes, with their title, excerpt and author if available.

Attributes:

* **link**: The text in the anchor tag that will link to the subpage. (_Default: Read more_)
* **tilebox**: Enable the grid layout of the subpages. Options: true, false. (_Default: false_)

Example:

```
[subpage-list link="More information here" tilebox=true ]
```

### Tabs and Tours

This tabs/tours shortcode uses the [Bootstrap tabs](https://getbootstrap.com/docs/4.6/components/navs/#tabs) and vertical tabs for tours, with additional keyboard accessibility added per [WAI-ARIA Authoring Practices 1.1](https://www.w3.org/TR/wai-aria-practices/examples/tabs/tabs-2/tabs.html).

Example:

```
[uw_tabs name="tabs name"]
	[tabs_section title="section title"] content [/tabs_section]
	[tabs_section title="section title"] content [/tabs_section]
	[tabs_section title="section title"] content [/tabs_section]
[/uw_tabs]
```

Options include defaulting a specific tab open by setting it to active and specifying an alternate style. For example:

```
[uw_tabs name="tabs name" style="alt-tab"]
	[tabs_section title="section title"] content [/tabs_section]
	[tabs_section title="section title"] content [/tabs_section]
	[tabs_section title="section title" active="true"] content [/tabs_section]
[/uw_tabs]
```

To use as a tour, or vertical tabs, set the tour flag. You can also set a default tab in this layout. For example:

```
[uw_tabs name="tabs name" tour="true"]
	[tabs_section title="section title"] content [/tabs_section]
	[tabs_section title="section title" active="true"] content [/tabs_section]
	[tabs_section title="section title"] content [/tabs_section]
[/uw_tabs]
```


### Tagboard

This shortcode embeds a Tagboard feed onto the page. Tagboards that you wish to embed should already be embeddable. You can check that your Tagboard is embeddable by visiting the Tagboard's dashboard and looking for the embed icon.

Attributes:

* **slug**: the ID of your Tagboard. This can be found by visiting your Tagboard's dashboard and looking for the 6-digit ID at the end of the url. (_Default: none_)
* **layout**: the layout of the Tagboard. Options: grid, waterfall, carousel. (_Default: grid_)
* **post-count**: the number of posts to display. (_Default: 50_)
* **mobile-count**: the number of posts to display on mobile. (_Default: 50_)
* **toolbar**: whether or not the toolbar is displayed. Options: default, none. (_Default: default_)
* **feed-type**: Choosing auto will only show featured posts. If toolbar="default", choosing default will allow the user to show latest posts or featured posts. Options: auto, default. (_Default: default_)

Example:

```
[tagboard slug="435487" layout="waterfall" post-count="30" mobile-count="15" toolbar="none" feed-type="auto"]
```

### Tile Box

Display branded tiles to structure content in elegantly. [See an example of tiles here](https://www.washington.edu/newhuskies/). Each tile is setup as a series of shortcodes wrapped in a [box] shortcode.

Attributes:

* **alignment**: How the text is aligned in each tile. Options: centered, none. (_Default: none_)
* **color**: Background color of the tiles. Options: tan, none. (_Default: none_)
* **empty**: (Add this to [tile], not [box]). If tile has no content, allow it to be transparent, but take up the normal amount of space. Options: true, false. (_Default: false_)

Example:

```
[box alignment=centered]
    [tile] Text for tile one [/tile]
    [tile] Text for tile two [/tile]
    [tile] Text for tile three [/tile]
    [tile] Text for tile four [/tile]
[/box]
```

### Trumba

For displaying a Trumba calendar spud in post or page content.

Attributes:

* **name**: Required Trumba web name of the desired calendar. (_Default: none_)
* **type**: The Trumba spud type of the desired calendar. Changing the type will change how the calendar is displayed. A list of all spud types can be found here. (_Default: none_)
* **base**: The full url of the desired base calendar. This can be embedded on your site with the spud type='main' (_Default: none_)

```
[trumba name='my web name' type='desired spud type' base='teaser base url']
```

Example:

```
[trumba name='sea_campus' type='main' base='https://www.washington.edu/calendar']
```


### Trumba RSS

For embedding an RSS feed from a trumba calendar.

Attributes:

* **url**: url of the calendar rss feed.
* **category**: Display event categories. Options: true, false. (_Default: true_)
* **description**: Display event descriptions. Options: true, false. (_Default: false_)

Example:

```
[trumba-rss url='calendar rss url' category='true' description='false']
```

### YouTube

Embed a YouTube video or playlist into your post content.

Attributes:

* **type**: Pick whether to display a single video or playlist. Options: single, playlist. (_Default: None_)
* **id**: The youtube video or playlist id (_Default: None_)
* **max-results** (OPTIONAL): The maximum number of results to return for a playlist. (_Default: None_)

Example:

```
[youtube type='type' id='video or playlist id' max-results='integer that defines max results']
```

## Widgets

### UW Campus Map ###

>Embed the location of a UW campus building on your page using the UW branded campus map. You can find the building code on the [UW Campus Map](https://www.washington.edu/maps/)

> Options:

> - **Title** : The title of the widget (*Default: None*)
> - **Building code** : The UW campus building code for the desired building to embed, ie: 'kne' for Kane Hall. (*Default: None*)


### UW Image Card ###

> Displays one of three styles of branded card. Both text and image can be customized.

> Options:

> - **Title** : The title of the widget (_Default: Image Widget_)
> - **Select an image** : Select an image from the WordPress  media library (_Default: None_)
> - **Featured text** : A small blurb that is shown below or on top of the image (_Default: None_)
> - **Link** : A URL for the More link text (_Default: None_)
> - **More link** : The text to display in the more link (_Default: Read more_)
> - **Card style** : Choose one of three styles (_Default: None_)

### UW Recent Posts ###

>  Similar to the default WordPress widget Recent Posts but with different options and layout.

> Options:

> - **Title** : The title of the widget (*Default: None*)
> - **Number of posts to display** : The number of posts to show (*Default: 1*)
> - **Display more link** : Display an anchor tag that links to the blogroll page (*Default: false*)
