# UW WordPress Theme
![UW WordPress Theme version 1.3.2](https://img.shields.io/static/v1?label=version&message=v1.3.1&color=green)

Please visit the [theme Wiki pages](https://github.com/uweb/uw_wp_theme/wiki) for more information on changes from the uw-2014 theme, Bootstrap features, child themes, and developer documentation.

You can also follow along on our progress and learn more about our [development roadmap](https://github.com/uweb/uw_wp_theme/projects/1) and [backlog](https://github.com/uweb/uw_wp_theme/projects/2).

## Requirements
- [PHP](https://php.net/) 7.2
- [WordPress](https://wordpress.org/) 5.4

## Theme features

The UW WordPress Theme theme includes the following features.

- [Bootstrap 4](https://getbootstrap.com/) integration
- UW brand styled shortcodes and components
- Mobile-first
- Progressive enhancement
- Modern styling and layouts using grid and flexbox
- Modern JavaScript
- Starter child theme

## For Developers

Are you a developer on this project? Please see the [developer documentation](https://github.com/uweb/uw_wp_theme/wiki/Developer-information) on the theme wiki to get started.

## Installation
1. Download this repo as a zip file.
2. If needed, rename the zip file or folder to `uw_wp_theme.zip`.
3. Log into your WordPress admin, if not already.
4. Go to Appearance > Themes and click the Add New button.
5. Click the Upload Theme button.
6. Drag and drop the UW WordPress Theme zip file to the file upload area and click the Install Now button.
7. Click the Activate link.

Do you need a child theme? If so, download and install our [starter child theme](https://github.com/uweb/uw_wp_theme_child).

## Navigation Menus

The theme has 2 menu options to choose from. You can toggle between them in the Theme Panel settings page.

1. **Default (classic uw-2014)** is an updated version of the classic UW-2014 theme's menu. This will look familiar if you have used this theme before. To build your menu, go to Appearance > Menus. Create a menu and set it to **_Display Location:_** White Bar.

2. **Mega Menu** is a menu system that allows for up to 3 columns of menus with sections. Build your navigation menu in the WordPress admin (Appearance > Menus) as you normally would with top-level items and drop-down items nested below. Set it to **_Display Location:_** Mega Menu.

### Mega Menu Columns ###
Sub-menus or drop-downs will build out columns to the right and then wrap to a new row depending on how many columns there are. One section will look like a regular list view (1 column). Two sections will be 2 columns, three sections will be 3 columns, four sections will be 2 columns and 2 rows, five sections will be 3 columns and 2 rows, six sections will be 3 columns and 2 rows, etc. We do not recommend going beyond 6 sections but the menu will continue to build as long as you make it.

Here is a visual example of building out a mega menu.

```
Top level 1 (2 columns, 1 row)
-- Column (optional heading)
  -- Page link
  -- Page link
  -- Page link
-- Column (optional heading)
  -- Page link
  -- Page link
Top Level 2 (3 columns, 1 row)
-- Column (optional heading)
  -- Page link
  -- Page link
  -- Page link
-- Column (optional heading)
  -- Page link
  -- Page link
-- Column (optional heading)
  -- Page link
  -- Page link
  -- Page link
Top Level 3 (2 columns, 2 rows)
-- Column (optional heading)
  -- Page link
  -- Page link
-- Column (optional heading)
  -- Page link
  -- Page link
-- Column (optional heading)
  -- Page link
  -- Page link
-- Column (optional heading)
  -- Page link
  -- Page link
```

To apply the **heading styling** in the mega menu, go to Screen Options and enable the Advanced menu property for CSS Classes. Now, add the `heading` class to the navigation items you want to show as headings.

If you want to create column with a single item, you can add the `nav-group` class to the top-level item you wish to be a column. You can also combine this with the `heading` class.

## Quicklinks

Default quicklinks are provided in the theme if you would like them to be consistent with what is on the https://uw.edu website. To customize them, just create a menu in the **Quick Links** location. *Note: For multisites, Quick Links location will only appear on blog/site 1 and populate all other sites*.

Links that have a class set containing an icon will appear at the top formatted as a larger link with an icon. Links without an icon will appear under the "Helpful Links" section.

Icon class options:
```
icon-map
icon-directories
icon-calendar
icon-libraries
icon-medicine
icon-myuw
icon-uwtoday
```


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

### Blockquote ###

This shortcode creates a UW-branded blockquote with styling options.

Attributes:

* **style** : Choose the styling for the blockquote. Options: **brand**, **simple**. (_Default: brand_)
* **align** : Set the alignment for the blockquote. Options: **left**, **right**, **center**. (_Default: left_)
* **name** : Set the name for the blockquote source.
* **title** : Set the title of the blockquote source.
* Content is _required_.

```
[blockquote style="" align="" name="Dubs Husky" title="Official Live Mascot" ] blockquote text [/blockquote]
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

### Cards

There are a ton of options available for cards. In general, there are small cards, content-width cards, and full-width cards. Small cards are variable width and should be used in conjunction with the `[row][col][/col][/row]` grid shortcode for layout.

_Note:_ Not all attributes and options go with all card types.

Attributes:

* **style**: Choose from 6 different small card styles, content-width (large), or edge-to-edge (full-width). Options: inset, no-image, image-top, block, text-link, step, large, full-width. (_Default: inset_)
* **align**: Currently only used for large and full-width cards. Sets the image to the left or right, with the card body on the other side. Options: left, right. (_Default: left_)
* **color**: Choose a color scheme for small and large cards. Not all cards have all color options. Options: gold, white, purple. (_Default: Each card type has its own default. inset: gold, no-image: gold, image-top: gold, block: white, text-link: white, step: white, large: gold, full-width: gold_)
* **image**: For inset, image-top, block, large, and full-width cards. Sets the URL of the image. (_Default: none_)
* **alt**: Sets the alt text for the image. Use with inset, image-top, block, large, and full-width cards. (_Default: none_)
* **icon**: Only used with step cards. [Available icons](https://www.washington.edu/brand/web/guides-and-how-tos/html-templates/web-icons/) are listed on the UW Brand site. Use without the period at the beginning: e.g. `.ic-check` should be `ic-check`. (_Default: none_)
* **title**: Title or heading for the card. Required for all cards. (_Default: Add a title!_)
* **titletag**: Heading tag used for the title. Supported tags: h2, h3, h4 (_Default: h2_)
* **subtitle**: Only used with step cards. (_Default: none_)
* **button**: Button text. Required for all cards except block (no button). (_Default: ADD BUTTON TEXT!_)
* **link**: Button link. Required for all cars except block (no button). (_Default: none_

Shortcode with all options:
```
[uw_card style="" align="" color="" image="" alt="" icon="" title="" subtitle="" button="" link=""]content goes here[/uw_card]
```

Image top card example:
```
[uw_card style="image-top" image="link_to_image_goes_here" alt="alt_text_goes_here" title="title_goes_here" button="button_text_goes_here" link="button_link_goes_here"]content goes here[/uw_card]
```

Large card example:
```
[uw_card style="large" align="right" color="purple" image="link_to_image_goes_here" alt="alt_text_goes_here" title="title_goes_here" button="button_text_goes_here" link="button_link_goes_here"]content goes here[/uw_card]
```

Example with grid shortcode for responsive 3-column layout:
```
[row]
	[col class="col-sm"]
		[uw_card style="inset" color="gold" image="link_to_image_goes_here" alt="alt_text_goes_here" title="title_goes_here" button="button_text_goes_here" link="#"]Something goes here...[/uw_card]
	[/col]
	[col class="col-sm"]
		[uw_card style="inset" color="purple" image="link_to_image_goes_here" alt="alt_text_goes_here" title="title_goes_here" button="button_text_goes_here" link="#"]Something goes here...[/uw_card]
	[/col]
	[col class="col-sm"]
		[uw_card style="inset" color="white" image="link_to_image_goes_here" alt="alt_text_goes_here" title="title_goes_here" button="button_text_goes_here" link="#"]Something goes here...[/uw_card]
	[/col]
[/row]
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

### Gallery/Carousel

Uses and extends the built-in WordPress gallery functionality and shortcode. Enable carousel mode for a Bootstrap carousel or leave as-is for a photo grid layout. See options below for each mode. There can be any combination of carousels and galleries on the same page.

Make sure you add descriptive alt text to all of your images.

_**Note:** It is recommended you use the WordPress gallery dialog to set up your carousel or gallery._

#### Gallery mode

Options used from Gallery dialog:

**Link To**: Attachment Page, Media File, None. (_Default: Attachment Page_)
**Columns**: 1-9 (_Default: 3_) Note: some column layouts are adjusted for mobile on smaller screen sizes
**Random Order**: Check to enable random order (_Default: disabled_)
**Size**: Ideally, always use **_Full Size_**. (_Default: Thumbnail_)
**Disable space between images**: Enable if you do not want the spacing gap between images. (_Default: disabled_)

Optional shortcode:
```
[gallery size="full" uw_carousel="false" uw_carousel_fullwidth="false" uw_carousel_captions="false" uw_photo_grid_gap="false" columns="4" link="file" ids="comma_separated_ids_of_photos"]
```

#### Carousel mode

Make sure to add captions to your images!

Options used from Gallery dialog:

**Random Order**: Check to enable random order (_Default: disabled_)
**Size**: Ideally, always use **_Full Size_**. (_Default: Thumbnail_)
**Enable carousel**: Required. Must be checked to enable carousel. (_Default: disabled_)
**Enable full-width**: Check to enable full-width carousel. Note: Make sure to use on a page without a sidebar! (_Default: disabled_)
**Enable simple captions**: Check to enable black text on a white background, below image. Default captions are white text with purple background over image. (_Default: disabled_)

Optional shortcode:
```
[gallery size="full" uw_carousel="true" uw_carousel_fullwidth="false" uw_carousel_captions="true" columns="1" ids="comma_separated_ids_of_photos" orderby=""]
```

### Grid

For dividing your content into columns of various widths. Uses [Bootstrap grid](https://getbootstrap.com/docs/4.6/layout/grid/) classes.

Options:

* **class**: any Bootstrap class (_Default: row_)
* **height**: equal: sets all columns to equal height (_Default: none_)

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

### Jumbotron

Display hero-style content. A lightweight, flexible component that can optionally extend the entire viewport to showcase key marketing messages on your site. Several options and styles are available.

Default style is content-width. All other styles are full-width.

Attributes:

* **style**: block, block-slant, block-center, simple, default (_Default: default or none_)
* **overlay**: gray, white, gold, purple (_Default: none_) Optional, for default and simple styles only.
* **align**: right (_Default: none_) Optional, for block and block-slant styles only. Adjusts the overlay positioning.
* **image**: background image URL (_Default: aerial new burke image_)
* **title**: Title for jumbotron (_Default: Add a title!_) Required.
* **titletag**: Heading tag used for the title. Supported tags: h1, h2, h3 (_Default: h2_)
* **button**: Text for jumbotron button (_Default: Add button text!_) Required.
* **link**: URL for jumbotron button (_Default: none_) Required.

**_Note_:** On pages with a sidebar, only the default style should be used or you will see unexpected behavior.

Example:

```
[uw_jumbotron style="default" title="Jumbotron title" overlay="purple" image="link-to-image" button="Button text" link="url-for-button"]This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.[/uw_jumbotron]
```

### Modal

For adding a modal. Anything placed inside the `[uw_modal][/uw_modal]` shortcode will appear in the modal window.

Attributes:

* **id**: The id of the modal. Used to connect button to modal window. (_Default: none_)
* **title**: Title that shows at the top of the modal window.
* **button**: Trigger button text. (_Default: 'Set button text'_)
* **width**: narrow, wide, default/none (medium-width). Sets width of modal. (_Default: none_)
* **color**: gold, purple. Sets the color of the trigger button. (_Default: purple_)
* **scroll**: true. Set to `true` if scroll inside modal. (_Default: none_)
* **position**: center. Set to `center` if modal vertically centered in viewport. (_Default: none_)

Example:

```
[uw_modal id="" title="Enter a title" width="wide" color="purple" button="Button text" scroll="true" position="center"](modal content)[/uw_modal]
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

**_Deprecated. Use Cards instead._**

Display branded tiles to structure content in elegantly. Each tile is setup as a series of shortcodes wrapped in a [box] shortcode.

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

## Other features ##
### Info Box ###

Creates a floated info box for highlighting content.

Options:

**class**: float-right, full-width. (_Default: float left_)

Base:

```
<div class="info-box">content</div>
```

With options:

```
<div class="info-box float-right">content</div>
```

```
<div class="info-box full-width">content</div>
```

## Deprecated features from UW 2014 and what to use instead ##

### Google Apps/Calendar shortcode ###

The `[googleapps]` shortcode has be deprecated. Please use the `[iframe]` shortcode instead.

To migrate from the `[googleapps]` calendar shortcode to the `[iframe]` shortcode, you will need to update as follows.

Your old Google Calendar `[googleapps]` shortcode looks like this:

```
[googleapps domain="www" dir="calendar/embed" query="src=somenetid%40uw.edu&amp;ctz=America%2FLos_Angeles" width="500" height="500"]

```

Update it to:

```
[iframe src="https://calendar.google.com/calendar/embed?src=somenetid%40uw.edu&amp;ctz=America%2FLos_Angeles" height="500" width="500"]

```

Options:

* **src**: The sharing URL for your calendar [Instructions from Google to _Add a Google calendar to your website_, see "Embed a calendar on your website"](https://support.google.com/calendar/answer/37082?hl=en). _Required_
* **height**: Height of the iframe embed, in pixels.
* **width**: Width of the iframe embed, in pixels.


### YouTube

Simply copy and paste the YouTube video URL to embed videos and playlists.

## Changelog
1.1.0
- Initial public release

1.0.0-beta
- Initial beta release
